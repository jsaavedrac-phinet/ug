<?php

use Illuminate\Database\Seeder;

class UserDefaultSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'full_name' => 'Super Administrador',
            'user' => 'superadmin',
            'password' => bcrypt('ug*2020'),
            'role' => 'superadmin'
        ]);
    }
}
