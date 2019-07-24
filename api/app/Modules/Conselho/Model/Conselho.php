<?php

namespace App\Modules\Conselho\Model;

use Illuminate\Database\Eloquent\Model;

class Conselho extends Model
{
    protected $table = 'tb_conselho';
    protected $primaryKey = 'co_conselho';

    protected $fillable = [
        'no_orgao_gestor',
        'ds_email',
        'nu_telefone',
        'nu_cnpj',
        'tp_governamental',
        'co_endereco',
        'co_representante',
        'co_usuario',
        'ds_sitio_eletronico',
        'st_inscricao',
    ];

    public $timestamps = false;

}