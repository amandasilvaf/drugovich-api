<?php


namespace Database\Seeders\Base;


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class GroupsSeeder extends Seeder
{
    /**
     * @return void
     */
    public function run()
    {
        DB::table('groups')->insert([
            [
                'name' => 'Cliente VIP'
            ],
            [
                'name' => 'Cliente Comum'
            ]
        ]);
    }
}
