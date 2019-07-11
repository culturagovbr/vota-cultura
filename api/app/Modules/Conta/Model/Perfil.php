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

    protected $hidden = [
        'pivot'
    ];

    public function usuarios()
    {
        return $this->belongsToMany(
            \App\Modules\Conta\Model\Usuario::class,
            'rl_usuario_perfil',
            'co_perfil',
            'co_usuario'
        )->as('rl_usuario_perfil');
    }

    protected $casts = [];

    public $timestamps = false;
}
