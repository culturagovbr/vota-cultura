<?php

namespace App\Modules\Organizacao\Model;

use Illuminate\Database\Eloquent\Model;

class Organizacao extends Model
{
    protected $table = 'tb_organizacao';
    protected $primaryKey = 'co_organizacao';

    protected $fillable = [
        'nu_cnpj',
        'no_organizacao',
        'ds_email',
        'nu_telefone',
        'co_segmento',
        'co_usuario',
        'co_endereco',
        'co_representante',
        'ds_sitio_eletronico',
        'st_inscricao',
    ];

    public $timestamps = false;

    public function segmento(){
        $this->hasOne(\App\Modules\Avaliacao\Model\Segmento::class, 'co_segmento', $this->getKey());
    }

    public function usuario(){
        $this->hasOne(\App\Modules\Conta\Model\Usuario::class,
            'co_usuario',
            'co_usuario');
    }

    public function endereco(){
        $this->hasOne(
            \App\Modules\Endereco\Model\Endereco::class,
            'co_endereco',
            'co_endereco');
    }

    public function representante(){
        $this->hasOne(
            \App\Modules\Representacao\Model\Representante::class,
            'co_representante',
            'co_representante');
    }

}