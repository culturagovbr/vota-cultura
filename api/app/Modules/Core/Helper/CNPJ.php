<?php

namespace App\Modules\Core\Helper;

class CNPJ
{
    public static function adicionarMascara($valor): ?string
    {
        $cnpj = preg_replace("/\D/", '', $valor);
        if (strlen($cnpj) < 14) {
            return null;
        }
        return preg_replace("/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/", "$1.$2.$3/$4-$5", $cnpj);
    }
}
