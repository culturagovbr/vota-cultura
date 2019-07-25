<?php

namespace App\Modules\Uf\Model;

use Illuminate\Database\Eloquent\Model;

class Uf extends Model
{
    protected $table = 'tb_uf';
    protected $primaryKey = 'co_ibge';

    protected $fillable = [
        'sg_uf',
        'no_uf',
    ];

    public $timestamps = false;

}