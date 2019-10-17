<?php

namespace App\Modules\Conselho\Model;

use App\Modules\Upload\Model\Arquivo;
use Illuminate\Database\Eloquent\Model;

class ConselhoHabilitacaoRecurso extends Model
{
    protected $table = 'tb_conselho_habilitacao_recurso';
    protected $primaryKey = 'co_conselho_habilitacao_recurso';

    protected $fillable = [
        'ds_recurso',
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
}
