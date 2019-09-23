<?php

namespace App\Modules\Representacao\Model;

use App\Modules\Conselho\Model\Conselho;
use App\Modules\Core\Helper\Telefone as TelefoneHelper;
use App\Modules\Organizacao\Model\Organizacao;
use App\Modules\Upload\Model\Arquivo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;


class RepresentanteArquivoPivot extends Pivot
{
    protected $table = 'rl_representante_arquivo';
    protected $primaryKey = 'co_representante_arquivo';
}
