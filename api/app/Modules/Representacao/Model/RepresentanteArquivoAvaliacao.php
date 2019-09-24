<?php

namespace App\Modules\Representacao\Model;

use App\Modules\Conselho\Model\Conselho;
use App\Modules\Conselho\Model\HabilitacaoConselho;
use App\Modules\Core\Helper\Telefone as TelefoneHelper;
use App\Modules\Organizacao\Model\Organizacao;
use App\Modules\Upload\Model\Arquivo;
use Illuminate\Database\Eloquent\Model;


class RepresentanteArquivoAvaliacao extends Model
{
    protected $table = 'tb_representante_arquivo_avaliacao';
    protected $primaryKey = 'co_representante_arquivo_avaliacao';
    protected $dateFormat = 'Y-m-d H:i:s.u';

    protected $dates = [
        'dh_avaliacao'
    ];

    protected $fillable = [
        'co_representante_arquivo',
        'st_em_conformidade',
        'ds_observacao',
        'co_usuario_avaliador',
        'dh_avaliacao',
    ];

    public $timestamps = false;

    public function conselho()
    {
        return $this->belongsTo(HabilitacaoConselho::class,
            'co_representante_arquivo',
            'co_representante_arquivo'
        );
    }
}
