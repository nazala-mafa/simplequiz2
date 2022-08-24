<?php

namespace Database\Seeders;

use App\Models\PostModel;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory(3)->create()->each(function($user) {
            PostModel::factory(10)->create(['user_id' => $user->id]);
        });
    }
}
