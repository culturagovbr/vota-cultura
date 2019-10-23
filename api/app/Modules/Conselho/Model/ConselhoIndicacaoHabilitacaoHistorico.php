<?php

namespace App\Modules\Conselho\Model;

use Illuminate\Database\Eloquent\Model;

class ConselhoIndicacaoHabilitacaoHistorico extends Model
{
    protected $table = 'tb_conselho_indicacao_habilitacao_historico';

    protected $primaryKey = 'co_conselho_indicacao_habilitacao_historico';

    protected $dateFormat = 'Y-m-d H:i:s.u';

    protected $dates = [
        'dh_avaliacao',
    ];

    protected $fillable = [
        'co_conselho_indicacao_habilitacao_historico',
        'dh_avaliacao',
        'st_avaliacao',
        'co_indicado',
        'ds_parecer',
        'co_usuario_avaliador',
    ];

    public $timestamps = FALSE;

    public function indicado()
    {
        return $this->belongsTo(
            ConselhoIndicacao::class,
            'co_conselho_indicacao',
            'co_indicado'
        );
    }
}
