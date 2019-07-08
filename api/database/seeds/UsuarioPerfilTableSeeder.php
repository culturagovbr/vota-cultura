<?php

use Illuminate\Database\Seeder;

class UsuarioPerfilTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Modules\Conta\Model\UsuarioPerfil::class, 1)->create([
            'no_perfil' => 'usuario',
            'ds_perfil' => 'Perfil padrão para todos os usuários do sistema',
            'st_ativo' => true,
        ]);
    }
}
