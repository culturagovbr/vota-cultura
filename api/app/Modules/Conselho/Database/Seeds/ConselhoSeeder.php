<?php

namespace App\Modules\Conselho\Database\Seeds;

use App\Modules\Conselho\Model\Conselho;
use Illuminate\Database\Seeder;

class ConselhoSeeder extends Seeder
{
    public function run()
    {
        Conselho::create([
            'no_orgao_gestor' => 'Orgão Gestor 1',
            'ds_email' => 'vinicius.feitosa@basis.com.br',
            'nu_telefone' => '06199999999',
            'nu_cnpj' => '40230926000198',
            'tp_governamental' => '1',
            'co_endereco' => 1,
            'co_representante' => 1,
            'co_usuario' => 1,
            'ds_sitio_eletronico' => 'https://jsonplaceholder.typicode.com',
            'st_indicacao' => 'a'
        ]);
    }
}
