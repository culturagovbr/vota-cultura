<?php

namespace App\Modules\Conselho\Model;

use App\Modules\Localidade\Model\Endereco;
use Illuminate\Database\Eloquent\Model;

class ConselhoIndicacao extends Model
{
    protected $table = 'tb_conselho_indicacao';
    protected $primaryKey = 'co_conselho_indicacao';
    protected $fillable = [
        'co_conselho',
        'nu_cpf_indicado',
        'no_indicado',
        'co_endereco',
    ];

    public $timestamps = false;

    public function endereco()
    {
        return $this->hasOne(
            Endereco::class,
            'co_endereco',
            'co_endereco'
        );
    }

    public function conselho()
    {
        return $this->belongsTo(
            Conselho::class,
            'co_conselho',
            'co_conselho'
        );
    }
}
