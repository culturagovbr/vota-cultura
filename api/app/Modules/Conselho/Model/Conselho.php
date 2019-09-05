<?php

namespace App\Modules\Conselho\Model;

use App\Modules\Conta\Model\Usuario;
use App\Modules\Core\Helper\Telefone as TelefoneHelper;
use App\Modules\Localidade\Model\Endereco;
use App\Modules\Representacao\Model\Representante;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

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

    public $timestamps = false;

    public function endereco()
    {
        return $this->hasOne(
            Endereco::class,
            'co_endereco',
            'co_endereco'
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

    public function conselhoJaCadastrado(Collection $dados)
    {
        return $this->getModel()->where($dados->only([
            'ds_email',
            'no_orgao_gestor',
            'nu_cnpj',
        ]))->first();
    }
}
