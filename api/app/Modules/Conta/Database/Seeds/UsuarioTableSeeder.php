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
        \App\Modules\Conta\Model\Usuario::firstOrCreate([
            'no_cpf' => '01234567890',
            'no_email' => 'teste@teste.teste',
            'ds_senha' => password_hash('123456', PASSWORD_DEFAULT),
            'dt_nascimento' => '2019-01-01',
            'st_ativo' => true,
            'dt_cadastro' => '2019-01-01',
        ]);
    }
}
