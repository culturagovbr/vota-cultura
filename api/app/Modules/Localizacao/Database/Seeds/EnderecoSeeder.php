<?php

namespace App\Modules\Localizacao\Database\Seeds;

use App\Modules\Localizacao\Model\Endereco;
use Illuminate\Database\Seeder;

class EnderecoSeeder extends Seeder
{
    public function run()
    {
        Endereco::create([
            'ds_complemento' => 'Casa 99',
            'nu_cep' => '70750610',
            'ds_logradouro' => 'Samambaia Sul',
            'co_municipio' => 1
        ]);
    }
}
