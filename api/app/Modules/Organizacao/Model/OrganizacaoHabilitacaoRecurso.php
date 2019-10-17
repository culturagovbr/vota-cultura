<?php

namespace App\Modules\Organizacao\Model;

use App\Modules\Upload\Model\Arquivo;
use Illuminate\Database\Eloquent\Model;

class OrganizacaoHabilitacaoRecurso extends Model
{
    protected $table = 'tb_organizacao_habilitacao_recurso';
    protected $primaryKey = 'co_organizacao_habilitacao_recurso';

    protected $fillable = [
        'ds_recurso',
        'co_organizacao',
        'ds_parecer',
        'st_parecer',
        'st_avaliacao',
        'nu_pontuacao',
    ];

    public $timestamps = false;

    public function organizacao()
    {
        return $this->hasOne(
            Organizacao::class,
            'co_organizacao',
            'co_organizacao'
        );
    }
}
