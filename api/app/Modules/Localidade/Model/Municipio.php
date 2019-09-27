<?php

namespace App\Modules\Localidade\Model;

use App\Modules\Localidade\Model\UF as ModelUF;
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

    public $timestamps = FALSE;

    public function uf()
    {
        return $this->hasOne(
            ModelUF::class,
            'co_ibge',
            'co_uf'
        );
    }
}
