<?php

use Illuminate\Database\Seeder;

class ColorSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('color_settings')->insert([
            'name' => 'Registrado',
            'css' => 'registered',
            'color' => '#FFFFFF',
            'background' => '#006634'
        ]);
        DB::table('color_settings')->insert([
            'name' => 'Pagó',
            'css' => 'payed',
            'color' => '#222222',
            'background' => '#FF851B'
        ]);
        DB::table('color_settings')->insert([
            'name' => 'No Pagó',
            'css' => 'not-payed',
            'color' => '#222222',
            'background' => '#3D9970'
        ]);
        DB::table('color_settings')->insert([
            'name' => 'Retorno 1',
            'css' => 'return-1',
            'color' => '#FFFFFF',
            'background' => '#001f3f'
        ]);
        DB::table('color_settings')->insert([
            'name' => 'No Retorno 1',
            'css' => 'not-return-1',
            'color' => '#111111',
            'background' => '#2ECC40'
        ]);
        DB::table('color_settings')->insert([
            'name' => 'Retorno 2',
            'css' => 'return-2',
            'color' => '#FFFFFF',
            'background' => '#0074D9'
        ]);
        DB::table('color_settings')->insert([
            'name' => 'No Retorno 2',
            'css' => 'not-return-2',
            'color' => '#333333',
            'background' => '#01FF70'
        ]);
        DB::table('color_settings')->insert([
            'name' => 'Retorno 3',
            'css' => 'return-3',
            'color' => '#FFFFFF',
            'background' => '#7FDBFF'
        ]);
        DB::table('color_settings')->insert([
            'name' => 'No Retorno 3',
            'css' => 'return-3',
            'color' => '#222222',
            'background' => '#85144b'
        ]);
        DB::table('color_settings')->insert([
            'name' => 'Completado',
            'css' => 'completed',
            'color' => '#111111',
            'background' => '#39CCCC'
        ]);
    }
}
