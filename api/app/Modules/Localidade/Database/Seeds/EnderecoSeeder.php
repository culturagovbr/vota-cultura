<?php

namespace App\Modules\Localidade\Database\Seeds;

use App\Modules\Localidade\Model\Endereco;
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
