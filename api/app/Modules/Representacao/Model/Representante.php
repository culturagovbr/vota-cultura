<?php

namespace App\Modules\Representacao\Model;

use App\Modules\Core\Helper\Telefone as TelefoneHelper;
use Illuminate\Database\Eloquent\Model;


class Representante extends Model
{
    const TIPO_INSCRICAO_ORGANIZACAO = 1;
    const TIPO_INSCRICAO_CONSELHO = 2;

    protected $table = 'tb_representante';
    protected $primaryKey = 'co_representante';

    protected $fillable = [
        'ds_email',
        'no_nome',
        'nu_rg',
        'nu_cpf',
        'nu_telefone',
    ];

    public $timestamps = false;

    public function organizacoes()
    {
        return $this->hasMany(
            \App\Modules\Organizacao\Model\Organizacao::class,
            'co_representante',
            'co_representante'
        );
    }

    public function arquivos()
    {
        return $this->belongsToMany(
            \App\Modules\Upload\Model\Arquivo::class,
            'rl_representante_arquivo',
            'co_representante',
            'co_arquivo'
        );
    }

    public function getTelefoneFormatadoAttribute()
    {
        return TelefoneHelper::adicionarMascara($this->nu_telefone);
    }
}
