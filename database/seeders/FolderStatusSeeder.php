<?php

namespace Database\Seeders;

use App\Helpers\Statuses\FolderStatuses;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use ReflectionClass;

class FolderStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $folderStatuses = (new ReflectionClass(FolderStatuses::class))->getConstants();

        foreach($folderStatuses as $key => $value) {
            DB::table('folder_statuses')->insert([
                'id' => $value,
                'name' => $key
            ]);
        }
    }
}
