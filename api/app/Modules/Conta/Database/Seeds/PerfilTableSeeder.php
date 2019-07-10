<?php

namespace App\Modules\Conta\Database\Seeds;

use Illuminate\Database\Seeder;

class PerfilTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Modules\Conta\Model\Foo::firstOrCreate([
            'no_perfil' => 'usuario',
            'ds_perfil' => 'Perfil padrão para todos os usuários do sistema',
            'st_ativo' => true,
        ]);
    }
}
