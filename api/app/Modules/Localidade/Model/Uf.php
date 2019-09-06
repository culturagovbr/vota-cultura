<?php

namespace App\Modules\Localidade\Model;

use Illuminate\Database\Eloquent\Model;

class Uf extends Model
{
    protected $table = 'tb_uf';
    protected $primaryKey = 'co_ibge';

    protected $fillable = [
        'sg_uf',
        'no_uf',
        'co_regiao',
    ];

    public $timestamps = false;

    public function regiao()
    {
        return $this->hasOne(
            Regiao::class,
            'co_regiao',
            'co_regiao'
        );
    }

}
