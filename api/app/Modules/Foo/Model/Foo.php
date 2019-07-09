<?php

namespace App\Modules\Foo\Model;

use Illuminate\Database\Eloquent\Model;

class Foo extends Model
{

    protected $table = 'tb_foo';
    protected $primaryKey = 'co_foo';

    protected $fillable = [
        'no_foo',
        'ds_foo',
        'st_ativo',
    ];

    protected $casts = [];

    public $timestamps = false;
}
