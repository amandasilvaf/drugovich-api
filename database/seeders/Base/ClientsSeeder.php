<?php


namespace Database\Seeders\Base;


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class ClientsSeeder extends Seeder
{
    /**
     * @return void
     */
    public function run()
    {
        DB::table('clients')->insert([
            [
                'name' => 'Auto Center Maringá',
                'cnpj' => '35450529000191',
                'foundation' => '2019-11-07',
            ],
            [
                'name' => 'Auto Center Colombo',
                'cnpj' => '03900666000194',
                'foundation' => '2000-06-28',
            ],
        ]);
    }
}
