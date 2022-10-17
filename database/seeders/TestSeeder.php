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
        $task1->name = 'Create MVP';
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
        // create task with big name
        $taskWithoutFolder = new Task();
        $taskWithoutFolder->name = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras ac dolor tempus, sagittis justo eget, tempor risus. Curabitur convallis eleifend massa, et bibendum nibh ullamcorper eu. Suspendisse potenti. Aliquam pharetra convallis nulla molestie scelerisque. Aliquam non felis nisl. Curabitur non sollicitudin diam. Suspendisse hendrerit velit vitae dui venenatis, non bibendum dui mattis. Nam eget euismod justo.';
        $taskWithoutFolder->save();

        // create another task with big name
        $taskWithoutFolder = new Task();
        $taskWithoutFolder->name = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed bibendum nec metus ut viverra. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Nulla quis eleifend eros, nec blandit orci. Maecenas interdum nunc ipsum, eget efficitur lacus porttitor quis. Nullam fringilla efficitur ex, in pharetra dui imperdiet sed. Sed nisl lectus, suscipit vel pretium ac, iaculis quis elit. Proin maximus, enim sit amet gravida placerat, nisi diam ultricies neque, vel rhoncus leo neque eu lacus. In non lacus suscipit, blandit ipsum in, dictum metus. In volutpat vehicula erat nec suscipit. Nullam mi leo, facilisis ut ex quis, vulputate elementum lacus.Nam ut vehicula elit. Integer consequat aliquet quam, ultricies ornare lorem fringilla a. Vivamus vel condimentum nunc. Nulla a metus tincidunt, ornare nunc eu, feugiat augue. Ut egestas maximus dictum. Morbi scelerisque posuere eros, non dictum turpis fringilla ac. Duis ipsum enim, posuere euismod vestibulum a, porta quis lorem. Mauris tincidunt ultrices ex vitae interdum.Quisque non rutrum libero. Vestibulum iaculis nibh magna, ac aliquam orci molestie quis. Duis congue rutrum ante a cursus. Curabitur mattis purus ut libero finibus rutrum. Vestibulum nulla est, porttitor accumsan nulla ac, consequat sodales ipsum. Nam ut lectus at quam faucibus ornare sit amet ac nulla. Proin aliquet, nibh eu faucibus rutrum, erat magna convallis orci, id facilisis tellus lectus eget nunc. Donec dignissim dui mollis purus tristique, et viverra est luctus. Morbi porta urna sed augue fermentum auctor. Morbi condimentum quis mauris fermentum ultrices.Pellentesque non leo lacinia, vestibulum quam at, feugiat elit. Sed maximus purus sit amet aliquet faucibus. Aliquam hendrerit volutpat lorem, vitae mattis sem finibus vitae. Vestibulum tincidunt, libero sed lobortis sagittis, enim massa congue odio, et fermentum ipsum ligula vitae nulla. Phasellus in dignissim eros, eu interdum ante. Duis sed luctus augue. Vestibulum non fringilla leo. Mauris euismod eros ege.Dot nets.';
        $taskWithoutFolder->save();

        // create task without folder
        $taskWithoutFolder = new Task();
        $taskWithoutFolder->name = 'Task without folder';
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
        $taskInTopFolder->name = 'Task inside top folder';
        $taskInTopFolder->folder_id = $folderWithoutParentFolder->id;
        $taskInTopFolder->save();


        // create task inside subfolder
        $taskInsideSubfolder = new Task();
        $taskInsideSubfolder->name = 'Task inside subfolder';
        $taskInsideSubfolder->folder_id = $subFolder1->id;
        $taskInsideSubfolder->save();

        // create task with tags, without a parent folder
        $taskWithoutFolderWithTags = new Task();
        $taskWithoutFolderWithTags->name = 'Task with tags, without a parent folder';
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
