<?php

namespace App\Modules\Organizacao\Model;

use App\Modules\Core\Helper\CPF;
use Illuminate\Database\Eloquent\Model;

class OrganizacaoIndicacao extends Model
{
    protected $table = 'tb_organizacao_indicacao';
    protected $primaryKey = 'co_organizacao_indicacao';

    protected $fillable = [
        'co_organizacao',
        'nu_cpf_indicado',
        'no_indicado',
        'tp_indicado',
        'dt_nascimento_indicado',
        'ds_curriculo'
    ];

    public $timestamps = false;

    public function getCpfFormatadoAttribute()
    {
        return CPF::adicionarMascara($this->nu_cpf_indicado);
    }
}
