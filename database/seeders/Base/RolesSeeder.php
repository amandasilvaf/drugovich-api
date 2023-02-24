<?php


namespace Database\Seeders\Base;


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class RolesSeeder extends Seeder
{
    /**
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            [
                'id' => 1,
                'name' => 'Gerente nível 1'
            ],
            [
                'id' => 2,
                'name' => 'Gerente nível 2'
            ]
        ]);
    }
}
