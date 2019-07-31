<?php

namespace App\Modules\Eleitor\Model;

use Illuminate\Database\Eloquent\Model;

class Eleitor extends Model
{
    protected $table = 'tb_eleitor';
    protected $primaryKey = 'co_eleitor';

    protected $dates = [
        'dt_nascimento',
    ];


    protected $fillable = [
        'nu_cpf',
        'ds_email',
        'no_eleitor',
        'nu_rg',
        'dt_nascimento',
        'st_estrangeiro',
        'co_endereco',
        'co_usuario',
    ];

    public $timestamps = false;

}
