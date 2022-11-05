<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BasicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('menus')->truncate();
        Menu::insert([[
            'title' => 'Dashboard',
            'parent_id' => null,
            'url' => "/admin",
            'icon' => "fas fa-fw fa-tachometer-alt",
            'section' => "100"
        ], [
            'title' => 'Utilities',
            'url' => "/#",
            'parent_id' => null,
            'icon' => "fas fa-fw fa-wrench",
            'section' => "900"
        ], [
            'title' => 'Menu',
            'parent_id' => '2',
            'url' => "/admin/menu",
            'icon' => "fas fa-fw fa-tachometer-alt",
            'section' => "900"
        ], [
            'title' => 'Article',
            'url' => "/admin/article",
            'parent_id' => null,
            'icon' => "fas fa-fw fa-book",
            'section' => "200"
        ]]);
    }
}
