<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UnitPayController extends Controller
{
    private $project_id = '326291';
    private $public_key = '326291-8e084';
    private $secret_key = 'd95f9908fcc9a18d0140d3d27c1aace3';

    private $supportedUnitpayIp = [
        '31.186.100.49',
        '178.132.203.105',
        '52.29.152.23',
        '52.19.56.234'
    ];

    public function check(Request $request)
    {
        if (empty($request->method) || empty($request->params) || !is_array($request->params)) {
            return $this->getResponseError('Неверные параметры запроса');
        }

        $method = $request->method;
        $params = $request->params;

        if ($params['signature'] !== $this->getSha256SignatureByMethodAndParams($method, $params)) {
            return $this->getResponseError('Неверная цифровая подпись');
        }

        if ($params['projectId'] !== $this->project_id) {
            return response()->json([
                'error' => [
                    'message' => 'Неверный ID проекта'
                ]
            ]);
        }

        if (!in_array($_SERVER['HTTP_CF_CONNECTING_IP'] ?? $request->ip(), $this->supportedUnitpayIp)) {
            return response()->json([
                'error' => [
                    'message' => 'Неизвестный IP'
                ]
            ]);
        }

        if ($method === 'check') {
            if (Payment::where('unitpay_id', $params['unitpayId'])->exists()) {
                return $this->getResponseSuccess('Платёж уже существует');
            }

            $user = User::where('id', $params['account'])->first();

            if (!$user) {
                return $this->getResponseError('Указанный пользователь не найден в базе данных');
            }

            $payment = new Payment();
            $payment->unitpay_id = $params['unitpayId'];
            $payment->sum = $params['sum'];
            $payment->user_id = $user->id;
            $payment->save();

            return $this->getResponseSuccess('Всё готово для оплаты');
        } else if ($method === 'pay') {
            $payment = Payment::where('unitpay_id', $params['unitpayId'])->first();

            if (!$payment) {
                return $this->getResponseError('Платёж не найден');
            }

            if ($payment->completed) {
                return $this->getResponseSuccess('Платёж уже оплачен');
            }

            $user = User::where('id', $payment->user_id)->first();

            if (!$user) {
                return $this->getResponseError('Указанный пользователь не найден в базе данных');
            }

            if (!$user->increment('balance', ((int) $payment->sum) * 2)) {
                return $this->getResponseError('Не удалось обновить баланс пользователя');
            }

            // VKController::sendMessage($user, 'Баланс на сайте был успешно пополнен, теперь он составляет: ' . $user->balance . 'руб', true);

            $payment->completed = true;
            $payment->save();

            return $this->getResponseSuccess('PAY is successful');
        }

        return $this->getResponseError($method.' не поддерживается');
    }

    public function deposit(Request $r)
    {
        $r->validate([
            'sum' => ['required', 'integer', 'min:1', 'max:100000']
        ], [
            'sum.required' => 'Сумма не указана',
            'sum.integer' => 'Сумма должна быть в виде целого числа',
            'sum.min' => 'Минимальная сумма пополнения: 1 рубль',
            'sum.max' => 'Максимальная сумма пополнения за один раз: 100.000 рублей'
        ]);

        $user = $r->user();
        $sum = $r->sum;
        $coins = $sum * 2;
        $bonus = $this->getCoinsBonus($coins);
        $desc = 'YouMine — Покупка ' . ($coins + $bonus) . ' ' . trans_choice('коин|коина|коинов', ($coins + $bonus), [], 'ru');

        return redirect('https://unitpay.ru/pay/' . $this->public_key . '?sum=' . $sum . '&account=' . $user->id . '&currency=RUB&desc=' . $desc . '&signature=' . $this->getFormSignature($user->id, 'RUB', $desc, $sum));
    }

    public function convertRubToCoins(Request $r)
    {
        $v = Validator::make($r->all(), [
            'sum' => ['required', 'integer', 'min:1', 'max:100000']
        ], [
            'sum.required' => 'Сумма в рублях не указана',
            'sum.integer' => 'Сумма должна быть в виде целого числа',
            'sum.min' => 'Мин. сумма пополнения: 1 рубль',
            'sum.max' => 'Макс. сумма пополнения за один раз: 100.000 рублей'
        ]);

        if ($v->fails()) {
            if ($r->ajax() || $r->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $v->errors()->first()
                ]);
            } else {
                return $v->errors()->first();
            }
        }

        $coins = $r->sum * 2;
        $bonus = $this->getCoinsBonus($coins);
        $message = $coins . ' ' . trans_choice('коин|коина|коинов', $coins, [], 'ru') . ($bonus > 0 ? ' + ' . $bonus . ' (бонус)' : '');

        if ($r->ajax() || $r->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => $message
            ]);
        } else {
            return $message;
        }
    }

    private function getCoinsBonus($sum)
    {
        if ($sum >= 10000) {
            return round((($sum * 2) / 100) * 10);
        } else if ($sum >= 5000) {
            return round((($sum * 2) / 100) * 5);
        } else if ($sum >= 1000) {
            return round((($sum * 2) / 100) * 4);
        } else if ($sum >= 500) {
            return round((($sum * 2) / 100) * 3);
        } else if ($sum >= 100) {
            return round((($sum * 2) / 100) * 2);
        } else if ($sum >= 50) {
            return round((($sum * 2) / 100) * 1);
        } else {
            return 0;
        }
    }

    private function getResponseSuccess($message)
    {
        return response()->json([
            'result' => [
                'message' => $message
            ]
        ]);
    }

    private function getResponseError($message)
    {
        return response()->json([
            'error' => [
                'message' => $message
            ]
        ]);
    }

    private function getSha256SignatureByMethodAndParams($method, array $params)
    {
        ksort($params);
        unset($params['sign'], $params['signature']);
        array_push($params, $this->secret_key);
        array_unshift($params, $method);

        return hash('sha256', implode('{up}', $params));
    }

    private function getFormSignature($account, $currency = 'RUB', $desc, $sum)
    {
        return hash('sha256', $account . '{up}' . $currency . '{up}' . $desc . '{up}' . $sum . '{up}' . $this->secret_key);
    }
}