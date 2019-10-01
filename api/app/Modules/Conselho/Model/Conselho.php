<?php

namespace App\Modules\Conselho\Model;

use App\Modules\Conta\Model\Usuario;
use App\Modules\Core\Helper\CNPJ;
use App\Modules\Core\Helper\Telefone as TelefoneHelper;
use App\Modules\Localidade\Model\Endereco;
use App\Modules\Representacao\Model\Representante;
use Illuminate\Database\Eloquent\Model;
use \App\Modules\Conselho\Model\ConselhoHabilitacaoRecurso;

class Conselho extends Model
{
    protected $table = 'tb_conselho';
    protected $primaryKey = 'co_conselho';

    protected $fillable = [
        'no_orgao_gestor',
        'no_conselho',
        'ds_email',
        'nu_telefone',
        'nu_cnpj',
        'tp_governamental',
        'co_endereco',
        'co_representante',
        'co_usuario',
        'ds_sitio_eletronico',
        'st_inscricao',
    ];

    public $timestamps = FALSE;

    public function endereco()
    {
        return $this->hasOne(
            Endereco::class,
            'co_endereco',
            'co_endereco'
        );
    }

    public function habilitacaoRecurso()
    {
        return $this->hasOne(
            ConselhoHabilitacaoRecurso::class,
            'co_conselho',
            'co_conselho'
        );
    }

    public function representante()
    {
        return $this->hasOne(
            Representante::class,
            'co_representante',
            'co_representante'
        );
    }

    public function conselhoHabilitacao()
    {
        return $this->hasOne(
            ConselhoHabilitacao::class,
            'co_conselho',
            'co_conselho'
        );
    }

    public function usuario()
    {
        return $this->hasOne(Usuario::class,
            'co_usuario',
            'co_usuario'
        );
    }

    public function getTelefoneFormatadoAttribute()
    {
        return TelefoneHelper::adicionarMascara($this->nu_telefone);
    }

    public function getCnpjFormatadoAttribute()
    {
        return CNPJ::adicionarMascara($this->nu_cnpj);
    }
}
