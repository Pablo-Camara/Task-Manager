<?php

namespace App\Services;

use App\Helpers\Statuses\FolderStatuses;
use App\Models\Folder;
use Illuminate\Support\Facades\DB;

class FolderService
{
    /**
     * Gets all the folders inside a folder
     * or all the top level folders
     *
     * @param $folderId
     * @return array
     */
    public function search($folderId = null) {
        $folders = Folder::select(
            [
                'id',
                DB::raw('name AS title'),
                'parent_folder_id'
            ]
        )
        ->with(
            [
                'tags' => function ($query) {
                    $query->select(['tags.id', 'tags.name']);
                }
            ]
        );

        $folders = $folders->where('folder_status_id', '=', FolderStatuses::ACTIVE);

        if (empty($folderId)) {
            $folders = $folders->whereNull('parent_folder_id');
        } else {
            $folders = $folders->where('parent_folder_id', '=', $folderId);
        }

        $folders = $folders->get();

        foreach ($folders as $key => $folder) {
            $folders[$key] = $this->convertToListItemObj($folder, true);
        }

        return $folders->toArray();
    }

    public function getParentFolders($folderId, $excludeSelf = false, &$parentFolders = [], $firstSearch = true) {

        $folder = null;

        if (!empty($folderId)) {
            $folder = Folder::find($folderId);
        }

        if (!empty($folder)) {
            if ($firstSearch == true) {
                if ($excludeSelf != true) {
                    array_push(
                        $parentFolders,
                        [
                            'id' => $folder->id,
                            'name' => $folder->name
                        ]
                    );
                }
            } else {
                array_unshift (
                    $parentFolders,
                    [
                        'id' => $folder->id,
                        'name' => $folder->name
                    ]
                );
            }


            if ($folder->hasParentFolder()) {
                $this->getParentFolders($folder->parent_folder_id, $excludeSelf, $parentFolders, false);
            } else {
                return $parentFolders;
            }
        }

        return $parentFolders;
    }

    public function convertToListItemObj(Folder $folder) {
        return [
            'id' => $folder->id,
            'title' => $folder->name ?? $folder->title,
            'tags' => $folder->tags,
            'parent_folder_id' => $folder->parent_folder_id,
            'parent_folders' => $this->getParentFolders($folder->parent_folder_id)
        ];
    }
}
