<?php

namespace App\Modules\Conselho\Model;

use Illuminate\Database\Eloquent\Model;

class ConselhoIndicacaoHabilitacaoRecurso extends Model
{
    protected $table = 'tb_conselho_indicacao_habilitacao_recurso';

    protected $primaryKey = 'co_conselho_indicacao_habilitacao_recurso';

    protected $dateFormat = 'Y-m-d H:i:s.u';

    protected $dates = [
        'dh_cadastro_recurso',
        'dt_nascimento_indicado',
    ];

    protected $fillable = [
        'co_conselho_indicacao_habilitacao_recurso',
        'co_conselho_indicacao_habilitacao',
        'ds_recurso',
        'st_parecer',
        'co_usuario_avaliador',
        'dt_nascimento_indicado'
    ];

    public function indicacaoHabilitacao()
    {
        return $this->hasMany(
            ConselhoIndicacaoHabilitacao::class,
            'co_conselho_indicacao_habilitacao',
            'co_conselho_indicacao_habilitacao'
        );
    }

    public $timestamps = FALSE;

}
