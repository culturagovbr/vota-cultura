<?php

namespace App\Modules\Conta\Database\Seeds;

use App\Modules\Conta\Model\Perfil;
use Illuminate\Database\Seeder;

class PerfilSeeder extends Seeder
{
    public function run()
    {
        Perfil::create([
            'no_perfil' => 'administrador',
            'ds_perfil' => 'Administrador do sistema',
            'st_ativo' => true
        ]);
    }
}
