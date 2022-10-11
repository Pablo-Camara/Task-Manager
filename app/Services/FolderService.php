<?php

namespace App\Services;

use App\Models\Folder;

class FolderService
{

    public function getParentFolders($folderId, &$parentFolders = []) {

        $folder = null;

        if (!empty($folderId)) {
            $folder = Folder::find($folderId);
        }

        if (!empty($folder)) {
            if (empty($parentFolders)) {
                array_push(
                    $parentFolders,
                    [
                        'id' => $folder->id,
                        'name' => $folder->name
                    ]
                );
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
                $this->getParentFolders($folder->parent_folder_id, $parentFolders);
            } else {
                return $parentFolders;
            }
        }

        return $parentFolders;
    }
}
