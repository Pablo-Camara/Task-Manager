<?php

namespace App\Http\Controllers;

use App\Models\Folder;
use App\Services\FolderService;
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
                'id' => 'required|exists:folders,id',
                'name' => 'required|max:255'
            ],
            [
                'name.required' => __('The folder name cannot be empty'),
                'name.max' => __('The folder name cannot have more than 255 characters'),
            ]
        )->validate();

        /**
         * @var Folder
         */
        $folder = Folder::find(
            $request->input('id')
        );

        if (empty($folder)) {
            throw ValidationException::withMessages([
                'id' => __('Folder not found')
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

    public function setStatus(Request $request) {
        Validator::make(
            $request->all(),
            [
                'id' => 'required|exists:folders,id',
                'new_status_id' => 'required|exists:folder_statuses,id'
            ]
        )->validate();

        /**
         * @var Folder
         */
        $folder = Folder::find(
            $request->input('id')
        );

        $folder->folder_status_id = $request->input('new_status_id');
        $folderSaved = $folder->save();

        if ($folderSaved) {
            return new Response([
                'message' => __('Folder status updated')
            ], 200);
        }

        return new Response([
            'message' => __('Failed to save changes')
        ], 500);
    }

    public function createNew(Request $request, FolderService $folderService) {
        Validator::make(
            $request->all(),
            [
                'current-folder' => 'exists:folders,id',
            ]
        )->validate();

        $currentFolderId = $request->input('current-folder');

        $newFolder = new Folder();
        $newFolder->name = 'New folder';
        if (!empty($currentFolderId)) {
            $newFolder->parent_folder_id = $currentFolderId;
        }
        $newFolder->save();

        return new Response(
            $folderService->convertToListItemObj($newFolder)
        );
    }

    public function changeParentFolder(Request $request) {

        $validationRules = [
            'id' => 'exists:folders,id'
        ];

        if($request->input('new-parent-folder') !== 'null') {
            $validationRules = array_merge(
                $validationRules,
                [
                    'new-parent-folder' => 'exists:folders,id',
                ]
            );
        }

        Validator::make(
            $request->all(),
            $validationRules
        )->validate();

        /**
         * @var Folder
         */
        $folder = Folder::find(
            $request->input('id')
        );

        $newParentFolder = $request->input('new-parent-folder');

        if ($newParentFolder === 'null') {
            $newParentFolder = null;
        }

        $folder->parent_folder_id = $newParentFolder;
        $folderSaved = $folder->save();

        if ($folderSaved) {
            return new Response([
                'message' => __('Folder moved successfully')
            ], 200);
        }

        return new Response([
            'message' => __('Failed to move folder')
        ], 500);
    }
}
