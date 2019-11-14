<?php

namespace App\Modules\Conselho\Model;

use Illuminate\Database\Eloquent\Model;
use App\Modules\Eleitor\Model\Eleitor;

class ConselhoVotacao extends Model
{
    public $timestamps = FALSE;

    protected $table = 'tb_conselho_votacao';
    protected $primaryKey = 'co_conselho_votacao';
    protected $dateFormat = 'Y-m-d H:i:s.u';

    protected $dates = [
        'dh_voto',
    ];

    protected $fillable = [
        'co_conselho_indicacao',
        'co_eleitor',
        'dh_voto',
    ];


    public function indicado()
    {
        return $this->hasOne(
            ConselhoIndicacao::class,
            'co_conselho_indicacao',
            'co_conselho_indicacao'
        );
    }

    public function eleitor()
    {
        return $this->hasOne(
            Eleitor::class,
            'co_eleitor',
            'co_eleitor'
        );
    }
}
