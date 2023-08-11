<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pabloCamaraUser = new User(
            [
                'username' => 'PC',
                'password' => Hash::make('8218')
            ]
        );
        $pabloCamaraUser->save();
    }
}
