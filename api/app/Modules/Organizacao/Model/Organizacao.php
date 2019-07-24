<?php

namespace App\Modules\Organizacao\Model;

use Illuminate\Database\Eloquent\Model;

class Organizacao extends Model
{

    protected $table = 'tb_organizacao';
    protected $primaryKey = 'co_organizacao';

    protected $fillable = [
        'nu_cnpj',
        'no_organizacao',
        'ds_email',
        'nu_telefone',
        'co_segmento',
        'co_usuario',
        'co_endereco',
        'co_representante',
        'ds_sitio_eletronico',
        'st_inscricao',
    ];

    public $timestamps = false;

}