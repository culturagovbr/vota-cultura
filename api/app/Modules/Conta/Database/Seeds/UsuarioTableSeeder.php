<?php

namespace App\Modules\Conta\Database\Seeds;

use Illuminate\Database\Seeder;
use App\Modules\Conta\Model\Usuario;

class UsuarioTableSeeder extends Seeder
{
    public function run()
    {
        $usuario = Usuario::where([
            'no_nome' => 'Testando haha',
            'ds_email' => 'teste@teste.teste',
            'dh_cadastro' => '2019-01-01',
            'st_ativo' => true,
        ])->first();

        if (!$usuario) {
            Usuario::Create([
                'st_ativo' => true,
                'ds_email' => 'viniciusfesil@gmail.com',
                'ds_senha' => password_hash('123456', PASSWORD_DEFAULT),
                'dh_cadastro' => '2019-07-29',
                'dh_ultima_atualizacao' => '2019-07-29',
                'ds_codigo_ativacao' => 'asdasdQEQWeqwrqwgt23tqwe',
                'co_perfil' => 1
            ]);

        }
    }
}
