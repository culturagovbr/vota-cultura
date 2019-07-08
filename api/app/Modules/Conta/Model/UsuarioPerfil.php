<?php

namespace App\Modules\Conta\Model;

use Illuminate\Database\Eloquent\Model;

class UsuarioPerfil extends Model
{

    protected $table = 'rl_usuario_perfil';
    protected $primaryKey = 'co_usuario_perfil';

    protected $fillable = [
        'co_usuario',
        'co_perfil',
        'st_perfil_atual',
    ];

    public $timestamps = false;
}
