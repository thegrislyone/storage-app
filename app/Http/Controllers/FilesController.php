<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class FilesController extends Controller
{

    public function getFilesList(Request $request) {

        return "ты пидорас";

    }

    public function uploadFiles(Request $request) {

        try {

            $files_src = [];

            foreach ($request['files'] as $key=>$file) {

                $file_original_name = $file->getClientOriginalName();
                $file_saved_src = Storage::disk('local')->put('/users_files/user', $file);

                FilesModel::create([
                    'src' => $file_saved_src,
                    'user_id' => Auth::user()->only('id')
                ]);

                $files_src[$file_original_name] = $file_saved_src;

            }

            return response()->json([
                "meta" => [ "success" => true, "errors" => [] ],
                "data" => [ "files_uploaded" => $files_src ]
            ], 200);

        } catch (Exception $e) {

            return response()->json([
                "meta" => [ "success" => false, "errors" => [] ],
                "data" => []
            ], 200);

        }

    }

}
