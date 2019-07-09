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
        $usuario = \App\Modules\Conta\Model\Usuario::where('no_cpf', '12345678901')->first();
        $perfil = \App\Modules\Conta\Model\Perfil::where('no_perfil', 'usuario')->first();

        if($usuario && $perfil) {
            \App\Modules\Conta\Model\UsuarioPerfil::firstOrCreate([
                'co_usuario' => $usuario->co_usuario,
                'co_perfil' => $perfil->co_perfil,
                'st_perfil_atual' => true,
            ]);
        }
    }
}
