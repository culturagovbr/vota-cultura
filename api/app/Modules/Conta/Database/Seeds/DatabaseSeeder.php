<?php

namespace App\Modules\Conta\Database\Seeds;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         $this->call(PerfilTableSeeder::class);
         $this->call(UsuarioPerfilTableSeeder::class);
         $this->call(UsuarioTableSeeder::class);
    }
}
