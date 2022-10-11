<?php

namespace App\Services;

use App\Models\Folder;

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
                'name',
            ]
        )
        ->with(
            [
                'tags' => function ($query) {
                    $query->select(['tags.id', 'tags.name']);
                }
            ]
        );

        if (empty($folderId)) {
            $folders = $folders->whereNull('parent_folder_id');
        } else {
            $folders = $folders->where('parent_folder_id', '=', $folderId);
        }

        $folders = $folders->get()->toArray();

        foreach ($folders as $key => $folder) {
            $folders[$key]['parent_folders'] = $this->getParentFolders($folder['id'], true);
            //$folders[$key]['time_spent_today'] = '00:00:00';
        }

        return $folders;
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
}
