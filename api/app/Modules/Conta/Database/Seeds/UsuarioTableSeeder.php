<?php

namespace App\Modules\Conta\Database\Seeds;

use Illuminate\Database\Seeder;

class UsuarioTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $usuario = \App\Modules\Conta\Model\Usuario::where([
            'no_cpf' => '12345678901',
            'no_nome' => 'Testando haha',
            'no_email' => 'teste@teste.teste',
            'dt_nascimento' => '2019-01-01',
            'dt_cadastro' => '2019-01-01',
            'st_ativo' => true,
        ])->first();

        if(!$usuario) {
            $usuario = \App\Modules\Conta\Model\Usuario::Create([
                'no_cpf' => '12345678901',
                'no_nome' => 'Testando haha',
                'no_email' => 'teste@teste.teste',
                'ds_senha' => password_hash('123456', PASSWORD_DEFAULT),
                'dt_nascimento' => '2019-01-01',
                'dt_cadastro' => '2019-01-01',
                'st_ativo' => true,
            ]);

        }
        $perfis = $usuario->perfis()->get();
        if(count($perfis) < 1) {
            $perfil = \App\Modules\Conta\Model\Perfil::where('no_perfil', 'usuario')->first();
            if(!is_null($perfil)) {
                $usuario->perfis()->attach($perfil->co_perfil);
            }
        }
    }
}
