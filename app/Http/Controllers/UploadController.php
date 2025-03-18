<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;

use App\Models\FilesModel;

class UploadController extends Controller
{

    public function uploadFiles(Request $request) {

        $files_src = [];

        foreach ($request['files'] as $key=>$file) {

            $file_original_name = $file->getClientOriginalName();
            $file_saved_src = Storage::disk('local')->put('/users_files/user', $file);

            FilesModel::create([
                'src' => $file_saved_src,
                'user_id' => 1
            ]);

            $files_src[$file_original_name] = $file_saved_src;

        }

        return response()->json([
            "success" => true,
            "errors" => [],
            "files_uploaded" => $files_src
        ], 200);

    }

}
