<?php

namespace App\Modules\Conselho\Model;

use App\Modules\Localidade\Model\Regiao;
use Illuminate\Database\Eloquent\Model;

class ConselhoRanking extends Model
{
    public $timestamps = FALSE;

    protected $table = 'tb_conselho_ranking';
    protected $primaryKey = 'co_conselho_ranking';

    protected $fillable = [
        'co_conselho_ranking',
        'co_regiao',
        'nu_votos',
        'nu_ranking',
        'co_conselho_indicacao',
    ];

    public function indicado()
    {
        return $this->hasOne(
            ConselhoIndicacao::class,
            'co_conselho_indicacao',
            'co_conselho_indicacao'
        );
    }

    public function regiao()
    {
        return $this->hasOne(
            Regiao::class,
            'co_regiao',
            'co_regiao'
        );
    }
}
