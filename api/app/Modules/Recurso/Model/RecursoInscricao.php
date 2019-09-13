<?php

namespace App\Modules\Recurso\Model;

use App\Modules\Conta\Model\Usuario;
use App\Modules\Core\Helper\CNPJ;
use App\Modules\Core\Helper\CPF;
use App\Modules\Core\Helper\Telefone as TelefoneHelper;
use App\Modules\Fase\Model\Fase;
use Illuminate\Database\Eloquent\Model;

class RecursoInscricao extends Model
{
    protected $table = 'tb_recurso_inscricao';
    protected $primaryKey = 'co_recurso_inscricao';
    protected $dates = [
        'dh_cadastro',
        'dh_parecer',
    ];
    protected $fillable = [
        'co_recurso_inscricao',
        'co_fase',
        'ds_email',
        'nu_cnpj',
        'nu_cpf',
        'nu_telefone',
        'ds_recurso',
        'dh_cadastro',
        'co_usuario_parecer',
        'ds_parecer',
        'dh_parecer',
        'st_parecer',
    ];
    public $timestamps = false;

    public function fase()
    {
        return $this->hasOne(
            Fase::class,
            'co_fase',
            'co_fase'
        );
    }

    public function usuario()
    {
        return $this->belongsTo(
            Usuario::class,
            'co_usuario',
            'co_usuario'
        );
    }

    public function getTelefoneFormatadoAttribute()
    {
        return TelefoneHelper::adicionarMascara($this->nu_telefone);
    }

    public function getCpfFormatadoAttribute()
    {
        return CPF::adicionarMascara($this->nu_cpf);
    }

    public function getCnpjFormatadoAttribute()
    {
        return CNPJ::adicionarMascara($this->nu_cnpj);
    }

    public function getDhCadastroFormatadoAttribute()
    {
        return !empty($this->dh_cadastro) ? $this->dh_cadastro->format('d/m/Y h:i:s') : null;
    }

    public function getDhParecerFormatadoAttribute()
    {
        return !empty($this->dh_parecer) ? $this->dh_parecer->format('d/m/Y h:i:s') : null;
    }
}
