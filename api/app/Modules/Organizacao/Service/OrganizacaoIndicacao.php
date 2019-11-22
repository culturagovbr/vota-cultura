<?php

namespace App\Modules\Organizacao\Service;

use App\Core\Service\AbstractService;

use App\Modules\Core\Exceptions\EValidacaoCampo;
use App\Modules\Organizacao\Model\OrganizacaoIndicacao as OrganizacaoIndicacaoModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class OrganizacaoIndicacao extends AbstractService
{
    public function __construct(OrganizacaoIndicacaoModel $model)
    {
        parent::__construct($model);
    }

    public function cadastrar(Collection $dados): ?Model
    {
        try {
            $dataNascimento = new \DateTime($dados['dt_nascimento_indicado']);
            $dados['dt_nascimento_indicado'] = $dataNascimento->format('Y-d-m');
            $this->validarCpfCadastrado($dados->only('nu_cpf_indicado')->toArray());
            $this->validarTipoCandidatoCadastrado($dados->only('tp_indicado', 'co_organizacao')->toArray());
            $modelPesquisada = $this->getModel()->fill($dados->toArray());
            $modelPesquisada->save();
            return $modelPesquisada;
        } catch (\EValidacaoCampo $queryException) {
            throw $queryException;
        }
    }

    private function validarCpfCadastrado($nuCpf)
    {
        $modelPesquisada = $this->getModel()->where($nuCpf)->get();
        if($modelPesquisada->count()) {
            throw new EValidacaoCampo('Indicado já cadastrado.');
        }
    }

    private function validarTipoCandidatoCadastrado($searchData)
    {
        $tipoCandidato = 'Titular';

        if($searchData['tp_indicado'] === 's') {
            $tipoCandidato = 'Suplente';
        }
        $modelPesquisada = $this->getModel()->where($searchData)->get();
        if($modelPesquisada->count()) {
            throw new EValidacaoCampo(sprintf('%s já cadastrado para esta organização.', $tipoCandidato));
        }
    }
}
