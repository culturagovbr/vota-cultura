<?php

namespace App\Modules\Conta\Database\Seeds;

use Illuminate\Database\Seeder;
use App\Modules\Conta\Model\Usuario;

class UsuarioTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $usuario = Usuario::where([
            'no_nome' => 'Testando haha',
            'ds_email' => 'teste@teste.teste',
            'dh_cadastro' => '2019-01-01',
            'st_ativo' => true,
        ])->first();

        if(!$usuario) {
            Usuario::Create([
                'no_nome' => 'Testando haha',
                'ds_email' => 'teste@teste.teste',
                'ds_senha' => password_hash('123456', PASSWORD_DEFAULT),
                'dh_cadastro' => '2019-01-01',
                'st_ativo' => true,
            ]);

        }
    }
}
