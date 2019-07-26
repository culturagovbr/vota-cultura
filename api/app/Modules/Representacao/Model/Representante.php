<?php

namespace App\Modules\Representacao\Model;

use Illuminate\Database\Eloquent\Model;


class Representante extends Model
{
    protected $table = 'tb_representante';
    protected $primaryKey = 'co_representante';

    protected $fillable = [
        'ds_email',
        'no_pessoa',
        'nu_rg',
        'nu_cpf',
    ];

    public $timestamps = false;

    public function organizacoes()
    {
        return $this->hasMany(
            \App\Modules\Organizacao\Model\Organizacao::class,
            'co_representante',
            'co_representante'
        );
    }
}
