<?php


namespace Database\Seeders\Base;


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class PermissionsSeeder extends Seeder
{
    /**
     * @return void
     */
    public function run()
    {
        DB::table('permissions')->insert([
            [
                'id' => 1,
                'name' => 'client-list'
            ],
            [
                'id' => 2,
                'name' => 'client-read'
            ],
            [
                'id' => 3,
                'name' => 'client-search'
            ],
            [
                'id' => 4,
                'name' => 'client-store'
            ],
            [
                'id' => 5,
                'name' => 'client-update'
            ],
            [
                'id' => 6,
                'name' => 'client-delete'
            ],
            [
                'id' => 7,
                'name' => 'group-list'
            ],
            [
                'id' => 8,
                'name' => 'group-read'
            ],
            [
                'id' => 9,
                'name' => 'group-search'
            ],
            [
                'id' => 10,
                'name' => 'group:store'
            ],
            [
                'id' => 11,
                'name' => 'group:update'
            ],
            [
                'id' => 12,
                'name' => 'group:delete'
            ],
            [
                'id' => 13,
                'name' => 'group-client-list'
            ],
            [
                'id' => 14,
                'name' => 'group-client-add'
            ],
            [
                'id' => 15,
                'name' => 'group-client-remove'
            ],
        ]);
    }
}