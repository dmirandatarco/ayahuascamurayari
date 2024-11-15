<?php

namespace Database\Seeders;

use App\Models\Moneda;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MonedaSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Moneda::create([
            'id'=>'1',
            'abreviatura'=>'S/',
            'nombre'=>'SOLES',
        ]);

        Moneda::create([
            'id'=>'2',
            'abreviatura'=>'$',
            'nombre'=>'DOLARES',
        ]);
    }
}
