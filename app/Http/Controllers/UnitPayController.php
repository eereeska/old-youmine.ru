<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\User;

use Illuminate\Http\Request;

class UnitPayController extends Controller
{
    const SECRET_KEY = '';

    private $project_id = '326291';
    private $public_key = '326291-8e084';
    private $secret_key = 'd95f9908fcc9a18d0140d3d27c1aace3';

    private $supportedUnitpayIp = [
        '31.186.100.49',
        '178.132.203.105',
        '52.29.152.23',
        '52.19.56.234'
    ];

    public function getResult(Request $request)
    {
        if (empty($request->method) || empty($request->params) || !is_array($request->params)) {
            return $this->getResponseError('Invalid request');
        }

        $method = $request->method;
        $params = $request->params;

        if ($params['signature'] != $this->getSha256SignatureByMethodAndParams($method, $params)) {
            return $this->getResponseError('Incorrect digital signature');
        }

        if ($params['projectId'] != $this->project_id) {
            return response()->json([
                'error' => [
                    'message' => 'Incorrect project ID'
                ]
            ]);
        }

        if (!in_array($_SERVER['HTTP_CF_CONNECTING_IP'], $this->supportedUnitpayIp)) {
            return response()->json([
                'error' => [
                    'message' => 'Unknown IP'
                ]
            ]);
        }

        if ($method === 'check') {
            if (Payment::where('unitpayId', $params['unitpayId'])->exists()) {
                return $this->getResponseSuccess('Payment already exists');
            }

            $user = User::where('id', $params['account'])->first();

            if (!$user) {
                return $this->getResponseSuccess('Specified user is not exists');
            }

            if (!Payment::insert([
                'unitpayId' => $params['unitpayId'],
                'sum' => $params['sum'],
                'user_id' => $user->id
            ])) {
                return $this->getResponseError('Unable to create payment database');
            }

            return $this->getResponseSuccess('CHECK is successful');
        }

        if ($method === 'pay') {
            $payment = Payment::where('unitpayId', $params['unitpayId'])->first();

            if (!$payment) {
                return $this->getResponseSuccess('Payment not found');
            }

            if ($payment->status == 1) {
                return $this->getResponseSuccess('Payment has already been paid');
            }

            $user = User::where('id', $payment->user_id)->first();

            if (!$user) {
                return $this->getResponseError('Unable to find account');
            }

            if (!$user->increment('balance', $payment->sum)) {
                return $this->getResponseError('Unable to update user balance');
            }

            // VKController::sendMessage($user, 'Баланс на сайте был успешно пополнен, теперь он составляет: ' . $user->balance . 'руб', true);

            $payment->status = 1;
            $payment->complete_at = now();
            $payment->save();

            return $this->getResponseSuccess('PAY is successful');
        }

        return $this->getResponseError($method.' not supported');
    }

    public function deposit(Request $request, $sum)
    {
        $request->validate([$sum], [
            'sum' => ['required', 'integer', 'min:10', 'max:100000']
        ], [
            'sum.required' => 'Сумма не указана',
            'sum.integer' => 'Сумма должна быть в виде целого числа',
            'sum.min' => 'Минимальная сумма пополнения: 10 рублей',
            'sum.max' => 'Максимальная сумма пополнения за один раз: 100.000 рублей'
        ]);

        $user = $request->user();
        $desc = 'YouMine — Пополнение баланса';

        return redirect('https://unitpay.ru/pay/' . $this->public_key . '?sum=' . $sum . '&account=' . $user->id . '&currency=RUB&desc=' . $desc . '&signature=' . $this->getFormSignature($user->id, 'RUB', $desc, $sum));
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