<?php

namespace App\Modules\Conselho\Model;

use App\Modules\Representacao\Model\RepresentanteArquivoAvaliacao;
use Illuminate\Database\Eloquent\Model;

class ConselhoHabilitacao extends Model
{
    protected $table = 'tb_conselho_habilitacao';
    protected $primaryKey = 'co_conselho_habilitacao';

    protected $dates = [
        'dh_avaliacao',
    ];

    protected $fillable = [
        'co_conselho',
        'st_avaliacao',
        'ds_parecer',
        'dh_avaliacao',
    ];

    public $timestamps = FALSE;

    public function conselho()
    {
        return $this->hasOne(
            Conselho::class,
            'co_conselho',
            'co_conselho'
        );
    }

    public function representanteArquivoAvaliacao()
    {
        return $this->hasMany(
            RepresentanteArquivoAvaliacao::class,
            'co_conselho_habilitacao',
            'co_conselho_habilitacao'
        );
    }
}
