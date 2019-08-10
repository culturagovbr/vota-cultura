<?php

namespace App\Modules\Core\Helper;

class Telefone
{
    public static function adicionarMascara($numeroTelefone) : ?string
    {
        if(strlen($numeroTelefone) < 10) {
            throw new \Exception('A string precisa ter no mínimo 10 caracteres.');
        }
        $ddd = '(' . substr($numeroTelefone, 0, 2) . ')';
        if (strlen($numeroTelefone) == 10) {
            $numeroTelefone = $ddd . substr($numeroTelefone, 2, 4) . '-' . substr($numeroTelefone, 6);
        }

        if (strlen($numeroTelefone) == 11) {
            $numeroTelefone = $ddd . substr($numeroTelefone, 2, 5) . '-' . substr($numeroTelefone, 7);
        }

        return $numeroTelefone;
    }
}
