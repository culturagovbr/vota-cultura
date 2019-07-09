<?php

namespace App\Modules\Agente\Database\Seeds;

use Illuminate\Database\Seeder;

class AgenteTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Modules\Agente\Model\Agente::firstOrCreate([
            'tp_pessoa' => 1,
            'nu_cpf_cnpj' => '12345678988810',
            'no_nome' => 'Agente 1',
            'no_razao_social' => ' Razao Social 1',
            'co_tipo_entidade' => '1',
            'no_site' => '',
            'dt_cadastro' => '',
            'dt_atualizacao' => '',
            'st_ativo' => true,
        ]);
    }
}
