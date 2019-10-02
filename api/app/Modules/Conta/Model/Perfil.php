<?php

namespace App\Modules\Conta\Model;

use Illuminate\Database\Eloquent\Model;

class Perfil extends Model
{
    const CODIGO_AVALIADOR = 1;
    const CODIGO_ELEITOR = 2;
    const CODIGO_CONSELHO = 3;
    const CODIGO_ORGANIZACAO = 4;
    const CODIGO_ADMINISTRADOR = 777;

    protected $table = 'tb_perfil';
    protected $primaryKey = 'co_perfil';

    protected $fillable = [
        'no_perfil',
        'ds_perfil',
        'st_ativo',
    ];

    public $timestamps = FALSE;

    public function usuario(){
        return $this->belongsTo(
            \App\Modules\Conta\Model\Usuario::class,
            'co_usuario',
            'co_usuario'
        );
    }

}
