<?php
/**
 * Created by PhpStorm.
 * User: cinject
 * Date: 08.02.15
 * Time: 16:23
 */

namespace Cinject\AdminPanel\Controllers;


use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Http\Request;

class AjaxController extends BaseController {

    public function getLoadImages(Filesystem $filesystem)
    {
        $toJson = [];

        $files = \File::allFiles(public_path('uploads/all/'));

        /** @var \SplFileInfo $file */
        foreach ($files as $file) {
            $toJson[] = [
                'image' => '/uploads/all/'. $file->getBasename(),
                'thumb' => '/uploads/all/'. $file->getBasename(),
            ];
        }


        return $toJson;
    }

    public function postUploadImage(Request $request)
    {
        $request->file('file')->move(public_path('uploads/all/'));

        return ["filelink" => '/uploads/all/'. $request->file('file')->getBasename()];
    }
}