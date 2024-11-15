<?php

namespace Database\Seeders;

use App\Models\Servicio;
use App\Models\Tipo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServicioSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Tipo::create([
            'id'=>'1',
            'nombre'=>'HOTEL',
        ]);

        Tipo::create([
            'id'=>'2',
            'nombre'=>'AGENCIA',
        ]);

        Tipo::create([
            'id'=>'3',
            'nombre'=>'GUIA',
        ]);

        Tipo::create([
            'id'=>'4',
            'nombre'=>'TRANSPORTE',
        ]);

        Tipo::create([
            'id'=>'5',
            'nombre'=>'RESTAURANTE',
        ]);

        Tipo::create([
            'id'=>'6',
            'nombre'=>'ENTRADAS',
        ]);

        Tipo::create([
            'id'=>'7',
            'nombre'=>'TICKETS',
        ]);

        Servicio::create([
            'id'=>'1',
            'nombre'=>'HOTEL',
            'tipo_id'=>'1',
        ]);

        Servicio::create([
            'id'=>'2',
            'nombre'=>'AGENCIA',
            'tipo_id'=>'2',
        ]);

        Servicio::create([
            'id'=>'3',
            'nombre'=>'GUIA',
            'tipo_id'=>'3',
        ]);

        Servicio::create([
            'id'=>'4',
            'nombre'=>'TRANSPORTE',
            'tipo_id'=>'4',
        ]);

        Servicio::create([
            'id'=>'5',
            'nombre'=>'RESTAURANTE',
            'tipo_id'=>'5',
        ]);
    }
}
