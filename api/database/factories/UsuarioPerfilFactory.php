<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Modules\Conta\Model\UsuarioPerfil::class, function (Faker $faker) {
    return [
        'co_usuario' => '12345678901',
        'co_perfil' => 'teste@teste.teste',
        'st_perfil_atual' => true,
    ];
});
