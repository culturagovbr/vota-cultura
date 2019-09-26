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

    public $timestamps = FALSE;

    public function municipio()
    {
        return $this->hasOne(
            Municipio::class,
            'co_municipio',
            'co_municipio'
        );
    }

}
