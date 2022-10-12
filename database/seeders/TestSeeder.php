<?php

namespace Database\Seeders;

use App\Models\Folder;
use App\Models\FolderTag;
use App\Models\Tag;
use App\Models\Task;
use App\Models\TaskTag;
use Illuminate\Database\Seeder;

class TestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createRealitySimulationItems();
        $this->createStandardTestingItems();
    }

    private function createRealitySimulationItems () {

        $folder1 = new Folder();
        $folder1->name = 'camara.pt';
        $folder1->save();

        $folder2 = new Folder();
        $folder2->parent_folder_id = $folder1->id;
        $folder2->name = 'task-manager.camara.pt';
        $folder2->save();

        $task1 = new Task();
        $task1->title = 'Create MVP';
        $task1->folder_id = $folder2->id;
        $task1->save();

        $tag1 = new Tag();
        $tag1->name = 'PHP 8';
        $tag1->save();

        $tag2 = new Tag();
        $tag2->name = 'Laravel 9';
        $tag2->save();

        $tag3 = new Tag();
        $tag3->name = 'MySql';
        $tag3->save();

        $taskTag = new TaskTag();
        $taskTag->task_id = $task1->id;
        $taskTag->tag_id = $tag1->id;
        $taskTag->save();

        $taskTag = new TaskTag();
        $taskTag->task_id = $task1->id;
        $taskTag->tag_id = $tag2->id;
        $taskTag->save();

        $taskTag = new TaskTag();
        $taskTag->task_id = $task1->id;
        $taskTag->tag_id = $tag3->id;
        $taskTag->save();


    }

    private function createStandardTestingItems() {
        // create task without folder
        $taskWithoutFolder = new Task();
        $taskWithoutFolder->title = 'Task without folder';
        $taskWithoutFolder->save();

        // create folder without parent folder
        $folderWithoutParentFolder = new Folder();
        $folderWithoutParentFolder->name = 'Folder without parent folder';
        $folderWithoutParentFolder->save();

        // create subfolder ( folder with parent folder )
        $subFolder1 = new Folder();
        $subFolder1->parent_folder_id = $folderWithoutParentFolder->id;
        $subFolder1->name = 'Subfolder 1';
        $subFolder1->save();

        // create task inside top folder
        $taskInTopFolder = new Task();
        $taskInTopFolder->title = 'Task inside top folder';
        $taskInTopFolder->folder_id = $folderWithoutParentFolder->id;
        $taskInTopFolder->save();


        // create task inside subfolder
        $taskInsideSubfolder = new Task();
        $taskInsideSubfolder->title = 'Task inside subfolder';
        $taskInsideSubfolder->folder_id = $subFolder1->id;
        $taskInsideSubfolder->save();

        // create task with tags, without a parent folder
        $taskWithoutFolderWithTags = new Task();
        $taskWithoutFolderWithTags->title = 'Task with tags, without a parent folder';
        $taskWithoutFolderWithTags->save();

        // create some tags
        $tag1 = new Tag();
        $tag1->name = 'Tag 1';
        $tag1->save();

        $tag2 = new Tag();
        $tag2->name = 'Tag 2';
        $tag2->save();

        $tag3 = new Tag();
        $tag3->name = 'Tag 3';
        $tag3->save();

        // add the tags to the task
        $taskTag1 = new TaskTag();
        $taskTag1->task_id = $taskWithoutFolderWithTags->id;
        $taskTag1->tag_id = $tag1->id;
        $taskTag1->save();

        $taskTag2 = new TaskTag();
        $taskTag2->task_id = $taskWithoutFolderWithTags->id;
        $taskTag2->tag_id = $tag2->id;
        $taskTag2->save();


        // create folder without parent folder, with tags
        $folderWithoutParentFolderWithTags = new Folder();
        $folderWithoutParentFolderWithTags->name = 'Folder without parent folder, with tags';
        $folderWithoutParentFolderWithTags->save();

        // add tag to the folder
        $folderTag1 = new FolderTag();
        $folderTag1->folder_id = $folderWithoutParentFolderWithTags->id;
        $folderTag1->tag_id = $tag3->id;
        $folderTag1->save();
    }
}
