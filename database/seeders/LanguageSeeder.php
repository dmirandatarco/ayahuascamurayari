<?php

namespace Database\Seeders;

use App\Models\Language;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Language::create([
            'id'=>'1',
            'abreviatura'=>'es',
            'icono'=>'es.svg',
        ]);
        Language::create([
            'id'=>'2',
            'abreviatura'=>'en',
            'icono'=>'en.svg',
        ]);
    }
}
