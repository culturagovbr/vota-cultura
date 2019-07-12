<?php

namespace App\Modules\Conta\Database\Seeds;

use Illuminate\Database\Seeder;

class ContaDatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         $this->call(UsuarioTableSeeder::class);
         $this->call(PerfilTableSeeder::class);
         $this->call(UsuarioPerfilTableSeeder::class);
    }
}
