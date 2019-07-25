<?php

namespace App\Modules\Avaliacao\Model;

use Illuminate\Database\Eloquent\Model;

class Segmento extends Model
{
    protected $table = 'tb_segmento';
    protected $primaryKey = 'co_segmento';

    protected $fillable = [
        'no_descricao',
        'st_ativo',
    ];

    public $timestamps = false;

}