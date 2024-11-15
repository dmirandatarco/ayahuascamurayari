<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'id'=>'1',
            'nombre'=>'David',
            'apellido'=>'Miranda Tarco',
            'tipo_documento'=>'DNI',
            'num_documento'=>'74747474',
            'celular'=>'982733597',
            'email'=>'dmirandatarco@gmail.com',
            'cumpleaños'=>'1994-11-02',
            'usuario'=>'david',
            'password'=>'$2y$10$NtFWYlOGWPewcw7NpC6wReaDkC6Z/7nMilspRUCbXmKJC6GTKbAou',
            'estado'=>'1',
            'imagen'=>'default.png',
            'updated_at'=>'2023-01-06',
            'created_at'=>'2023-01-06',
        ])->assignRole('GERENTE');
    }
}
