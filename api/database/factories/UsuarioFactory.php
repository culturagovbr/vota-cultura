<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Modules\Conta\Model\Usuario::class, function (Faker $faker) {
    return [
        'no_cpf' => '12345678901',
        'no_email' => 'teste@teste.teste',
        'ds_senha' => password_hash('123456', PASSWORD_DEFAULT),
        'dt_nascimento' => '2019-01-01',
        'st_ativo' => true,
    ];
});
