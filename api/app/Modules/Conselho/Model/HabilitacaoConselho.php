<?php

namespace App\Modules\Conselho\Model;

use App\Modules\Conta\Model\Usuario;
use App\Modules\Core\Helper\Telefone as TelefoneHelper;
use App\Modules\Localidade\Model\Endereco;
use App\Modules\Representacao\Model\Representante;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class HabilitacaoConselho extends Model
{
    protected $table = 'tb_habilitacao_conselho';
    protected $primaryKey = 'co_habilitacao_conselho';

    protected $fillable = [
        'co_conselho',
        'st_avaliacao',
        'ds_parecer',
    ];

    public $timestamps = false;

    public function conselho()
    {
        return $this->hasOne(
            Conselho::class,
            'co_conselho',
            'co_conselho'
        );
    }
}
