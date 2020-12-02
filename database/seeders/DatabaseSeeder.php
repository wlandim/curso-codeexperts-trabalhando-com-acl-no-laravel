<?php

namespace Database\Seeders;

use App\Models\Thread;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(ThreadsTableSeeder::class);
        /*
        User::factory(5)->create()->each(function (User $user)
        {
            $thread = Thread::factory(3)->make();
            $user->threads()->saveMany($thread);
        });
        */
    }
}
