<?php

namespace App\Modules\Localidade\Model;

use Illuminate\Database\Eloquent\Model;

class Regiao extends Model
{
    protected $table = 'tb_regiao';
    protected $primaryKey = 'co_regiao';

    protected $fillable = [
        'no_regiao',
    ];

    public $timestamps = FALSE;

}
