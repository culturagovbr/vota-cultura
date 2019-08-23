<?php

namespace App\Modules\Localidade\Model;

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

//    public function organizacoes()
//    {
//        return $this->hasMany(
//            \App\Modules\Organizacao\Model\Organizacao::class,
//            'co_endereco',
//            'co_endereco'
//        );
//    }

    public function municipio()
    {
        return $this->hasOne(\App\Modules\Localidade\Model\Municipio::class);
    }

}
