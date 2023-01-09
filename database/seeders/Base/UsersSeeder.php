<?php


namespace Database\Seeders\Base;


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class UsersSeeder extends Seeder
{
    /**
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'name' => 'Amanda Ferreira',
                'email' => 'amandasilvaf1995@gmail.com',
                'password' => bcrypt('laravel'),
                'role_id' => 2
            ],
            [
                'name' => 'Usuário Gerente Nível 1',
                'email' => 'gerente-nivel1@gmail.com',
                'password' => bcrypt('nivel1'),
                'role_id' => 1
            ]
        ]);
    }
}
