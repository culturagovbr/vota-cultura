<?php

namespace App\Modules\Conselho\Model;

use App\Modules\Upload\Model\Arquivo;
use Illuminate\Database\Eloquent\Model;

class ConselhoHabilitacaoRecurso extends Model
{
    protected $table = 'tb_conselho_recurso_habilitacao';
    protected $primaryKey = 'co_conselho_recurso_habilitacao';

    protected $fillable = [
        'ds_recurso',
        'co_arquivo',
        'co_conselho',
    ];

    public $timestamps = false;

    public function conselho()
    {
        return $this->hasOne(
            Conselho::class,
            'co_conselho',
            'co_conselho'
        );
    }

    public function anexoRecurso()
    {
        return $this->hasOne(
            Arquivo::class,
            'co_arquivo',
            'co_arquivo'
        );
    }
}
