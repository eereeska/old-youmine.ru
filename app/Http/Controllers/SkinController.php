<?php

namespace App\Http\Controllers;

use App\Models\Skin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class SkinController extends Controller
{
    public function index(Request $r)
    {

    }

    public function upload(Request $r)
    {
        $v = Validator::make($r->all(), [
            'skin' => ['required', 'image', 'max:10', 'dimensions:min_width=64,max_width=64,min_height=64,max_height=64']
        ], [
            'skin.required' => 'Файл не выбран',
            'skin.image' => 'Загружаемый файл не является изображением',
            'skin.max' => 'Максимальный размер файла: 10кб',
            'skin.dimensions' => 'Изображение должно быть 64x64 пикселя'
        ]);

        if ($v->fails()) {
            return response()->json([
                'success' => false,
                'message' => $v->errors()->first()
            ]);
        }

        $user = $r->user();
        $file = $r->file('skin');

        // Storage::putFileAs('public/skins/raw', $r->file('skin'), 'temp' . '.png');

        // $file = Storage::get('public/skins/raw/temp.png');

        // if (!$user->admin and Skin::where('owner_id', $user->id)->count() > 0) {
        //     return response()->json([
        //         'success' => false,
        //         'message' => 'У тебя уже есть скин, ожидающий проверки. Пожалуйста, сначала дождись, когда мы проверим его'
        //     ]);
        // }

        $model = ((imagecolorat(imagecreatefrompng($file->path()), 54, 20) >> 24) & 0x7F == 127) ? 'alex' : 'steve';

        $response = Http::attach('file', file_get_contents($file->path()), 'skin.png')->post('https://api.mineskin.org/generate/upload?visibility=1&name=YouMine&model=' . $model);

        if (!$response->successful()) {
            return response()->json([
                'success' => false,
                'message' => 'Не удалось получить информацию о скине: ' . $response
            ]);
        }

        $texture = $response['data']['texture']['value'];
        $signature = $response['data']['texture']['signature'];

        if (Skin::where('texture', $texture)->where('signature', $signature)->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Указанный скин уже загружен'
            ]);
        }

        $skin = new Skin();
        $skin->owner_id = $user->id;
        // $skin->confirmed = true; TODO: Подтверждение скинов
        $skin->slim = $model == 'alex';
        $skin->texture = $texture;
        $skin->signature = $signature;
        $skin->save();

        $im = imagecreatefromstring(file_get_contents($file->path()));
        $av = imagecreatetruecolor(8, 8);

        imagecopyresized($av, $im, 0, 0, 8, 8, 8, 8, 8, 8);
        imagecolortransparent($im, imagecolorat($im, 63, 0));
        imagecopyresized($av, $im, 0, 0, 8 + 32, 8, 8, 8, 8, 8);

        imagepng($av, storage_path('app/public/skins/avatars/' . $skin->id . '.png'));

        // foreach (User::where('admin', true)->where('nn_admin_skin_request', true)->get() as $admin) {
        //     VKController::sendMessage($admin, 'Новый запрос на добавление скина: ' . route('skin', ['id' => $skin->id]));
        // }

        $user->skin_id = $skin->id;
        $user->save();

        return response()->json([
            'success' => true,
            'skin' => [
                'avatar' => url('avatars/' . $skin->id . '.png')
            ]
            // 'redirect' => route('skins')
        ]);
    }

    public static function getSkinModel()
    {

    }
}