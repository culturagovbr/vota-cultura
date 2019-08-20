<?php

namespace App\Modules\Representacao\Database\Seeds;

use Illuminate\Database\Seeder;

class RepresentanteSeeder extends Seeder
{
    public function run()
    {
        \App\Modules\Representacao\Model\Representante::create( [
            'co_representante'=>1,
            ' ds_email'=>'viniciusfesil@gmail.com',
            ' no_nome'=>'Vinicius Feitosa da Silva',
            ' nu_rg'=>'12345678',
            ' nu_cpf'=>'12345678901'
        ] );
    }
}
