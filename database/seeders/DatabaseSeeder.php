<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

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
        $this->call([
            Base\GroupsSeeder::class,
            Base\ClientsSeeder::class,
            Base\RolesSeeder::class,
            Base\PermissionsSeeder::class,
            Base\RoleHasPermissionSeeder::class,
        ]);
    }
}
