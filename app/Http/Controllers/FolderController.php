<?php

namespace App\Http\Controllers;

use App\Models\Folder;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class FolderController extends Controller
{
    public function editName(Request $request) {
        Validator::make(
            $request->all(),
            [
                'folder_id' => 'required|exists:folders,id',
                'name' => 'required|max:255'
            ],
            [
                'folder.required' => __('The folder name cannot be empty'),
                'folder.max' => __('The folder name cannot have more than 255 characters'),
            ]
        )->validate();

        /**
         * @var Folder
         */
        $folder = Folder::find(
            $request->input('folder_id')
        );

        if (empty($folder)) {
            throw ValidationException::withMessages([
                'folder_id' => __('Folder not found')
            ]);
        }

        $folder->name = $request->input('name');
        $folderSaved = $folder->save();

        if ($folderSaved) {
            return new Response([
                'message' => __('Folder name updated')
            ], 200);
        }

        return new Response([
            'message' => __('Failed to save changes')
        ], 500);
    }
}
