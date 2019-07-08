<?php

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
        factory(\App\Modules\Conta\Model\Perfil::class, 1)->create([
            'no_perfil' => 'usuario',
            'ds_perfil' => 'Perfil padrão para todos os usuários do sistema',
            'st_ativo' => true,
        ]);
//        factory(\App\Modules\Conta\Model\Perfil::class, 1)->create([
//            'no_perfil' => 'proponente',
//            'ds_perfil' => 'Perfil de proponente',
//            'st_ativo' => true,
//        ]);
    }
}
