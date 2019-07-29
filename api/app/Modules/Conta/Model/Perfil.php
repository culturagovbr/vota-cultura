<?php

namespace App\Modules\Conta\Model;

use Illuminate\Database\Eloquent\Model;

class Perfil extends Model
{

    protected $table = 'tb_perfil';
    protected $primaryKey = 'co_perfil';

    protected $fillable = [
        'no_perfil',
        'ds_perfil',
        'st_ativo',
    ];

    public $timestamps = false;

    public function usuario(){
        return $this->belongsTo(
            \App\Modules\Conta\Model\Usuario::class,
            'co_usuario',
            'co_usuario',
            'rl_usuario_perfil'
        );
    }

}
