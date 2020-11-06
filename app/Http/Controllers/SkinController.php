<?php

namespace App\Http\Controllers;

use App\Models\Skin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class SkinController extends Controller
{
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
        $file_contents = file_get_contents($file->path());

        $model = ((imagecolorat(imagecreatefrompng($file->path()), 54, 20) >> 24) & 0x7F == 127) ? 'alex' : 'steve';

        $mineskin_request = Http::attach('file', $file_contents, 'skin.png')->post('https://api.mineskin.org/generate/upload?visibility=1&name=YouMine&model=' . $model);

        if (!$mineskin_request->successful()) {
            return response()->json([
                'success' => false,
                'message' => 'Не удалось получить информацию о скине: ' . $mineskin_request
            ]);
        }

        // TODO: Подтверждение скинов

        $texture = $mineskin_request['data']['texture']['value'];
        $signature = $mineskin_request['data']['texture']['signature'];

        $skin = Skin::where('texture', $texture)->where('signature', $signature)->first();

        if ($skin) {
            $user->skin_id = $skin->id;
            $user->save();

            return response()->json([
                'success' => true,
                'skin' => [
                    'avatar' => url('avatars/' . $skin->id . '.png')
                ]
            ]);
        }

        $skin = new Skin();
        $skin->owner_id = $user->id;
        $skin->slim = $model == 'alex';
        $skin->texture = $texture;
        $skin->signature = $signature;
        $skin->save();

        $im = imagecreatefromstring($file_contents);
        $av = imagecreatetruecolor(8, 8);

        imagecopyresized($av, $im, 0, 0, 8, 8, 8, 8, 8, 8);
        imagecolortransparent($im, imagecolorat($im, 63, 0));
        imagecopyresized($av, $im, 0, 0, 8 + 32, 8, 8, 8, 8, 8);

        imagepng($av, storage_path('app/public/skins/avatars/' . $skin->id . '.png'));

        $user->skin_id = $skin->id;
        $user->save();

        return response()->json([
            'success' => true,
            'skin' => [
                'avatar' => url('avatars/' . $skin->id . '.png')
            ]
        ]);
    }
}