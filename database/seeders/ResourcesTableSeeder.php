<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Route;

class ResourcesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (Route::getRoutes()->getRoutes() as $route) {

            $routeName = $route->getName();

            if ($routeName) {
                \App\Models\Resource::create([
                    'name' => ucwords(str_replace('.', ' ', $routeName)),
                    'resource' => $routeName,
                    'is_menu' => false,
                ]);
            }
        }
    }
}
