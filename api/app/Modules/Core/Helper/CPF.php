<?php

namespace App\Modules\Core\Helper;

class CPF
{
    public static function adicionarMascara($valor): ?string
    {
        $cpf = preg_replace("/\D/", '', $valor);
        if (strlen($cpf) < 11) {
            return null;
        }
        return preg_replace("/(\d{3})(\d{3})(\d{3})(\d{2})/", "\$1.\$2.\$3-\$4", $cpf);
    }
}
