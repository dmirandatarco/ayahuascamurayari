<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Unisharp\Laravelfilemanager\controllers\LfmController;
use Illuminate\Support\Facades\Input;

class CustomLfmController extends Controller
{
    public function upload()
    {
        $file = Input::file('upload');

        if ($file->getClientOriginalExtension() === 'heic') {
            // Convierte el archivo .heic a .jpg utilizando la biblioteca
            $jpgBlob = \Maestroerror\HeicToJpeg::convert($file->getRealPath());

            // Almacena el archivo .jpg en el sistema de archivos
            $jpgFileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) . '.jpg';
            Storage::disk($this->helper->config('disk'))->put($this->helper->getThumbPath($jpgFileName), $jpgBlob);
        } else {
            parent::upload();
        }

        return parent::success_response($file->getClientOriginalName());
    }
}
