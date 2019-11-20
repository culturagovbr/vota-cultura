<?php

namespace App\Modules\Organizacao\Model;

use App\Modules\Core\Helper\CPF;
use Carbon\Carbon;
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
        'ds_curriculo',
        'dt_nascimento_indicado'
    ];

    public function organizacao()
    {
        return $this->hasOne(
            Organizacao::class,
            'co_organizacao',
            'co_organizacao'
        );
    }

    public $timestamps = false;

    public function getNuCpfIndicadoFormatadoAttribute()
    {
        return CPF::adicionarMascara($this->nu_cpf_indicado);
    }

    public function getDtNascimentoIndicadoFormatadoAttribute()
    {
        $carbon = new Carbon($this->dt_nascimento_indicado);
        return $carbon->format('d/m/Y');
    }
}
