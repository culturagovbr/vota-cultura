<?php

namespace App\Modules\Localizacao\Model;

use Illuminate\Database\Eloquent\Model;

class Municipio extends Model
{
    protected $table = 'tb_municipio';
    protected $primaryKey = 'co_municipio';

    protected $fillable = [
        'co_ibge',
        'no_municipio',
        'co_uf',
    ];

    public $timestamps = false;

}