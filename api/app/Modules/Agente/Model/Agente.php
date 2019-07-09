<?php

namespace App\Modules\Agente\Model;

use Illuminate\Database\Eloquent\Model;

class Agente extends Model
{
    protected $table = 'tb_agente';
    protected $primaryKey = 'co_agente';

    protected $fillable = [
        'tp_pessoa',
        'nu_cpf_cnpj',
        'no_nome',
        'no_razao_social',
        'co_tipo_entidade',
        'no_site',
        'dt_cadastro',
        'dt_atualizacao',
        'st_ativo',
    ];

    public $timestamps = false;
}
