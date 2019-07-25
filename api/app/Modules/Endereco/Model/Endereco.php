<?php

namespace App\Modules\Endereco\Model;

use Illuminate\Database\Eloquent\Model;

class Endereco extends Model
{
    protected $table = 'tb_endereco';
    protected $primaryKey = 'co_endereco';

    protected $fillable = [
        'ds_complemento',
        'nu_cep',
        'ds_logradouro',
        'co_municipio',
    ];

    public $timestamps = false;

}