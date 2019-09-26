<?php

namespace App\Modules\Organizacao\Model;

use Illuminate\Database\Eloquent\Model;

class Segmento extends Model
{
    protected $table = 'tb_segmento';
    protected $primaryKey = 'co_segmento';

    protected $fillable = [
        'no_descricao',
        'st_ativo',
    ];

    public $timestamps = FALSE;

    public function organizacoes()
    {
        return $this->hasMany(
            \App\Modules\Organizacao\Model\Organizacao::class,
            'co_segmento',
            'co_segmento'
        );
    }

}
