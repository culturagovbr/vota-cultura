<?php

namespace App\Modules\Conselho\Service;

use App\Core\Service\AbstractService;
use App\Modules\Conselho\Model\ConselhoHabilitacao as ConselhoHabilitacaoModel;
use App\Modules\Core\Exceptions\EParametrosInvalidos;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ConselhoHabilitacao extends AbstractService
{
    public function __construct(ConselhoHabilitacaoModel $model)
    {
        parent::__construct($model);
    }

    public function cadastrar(Collection $dados): ?Model
    {
        try {
            DB::beginTransaction();
            $carbon = Carbon::now();
            $dadosInclusao = $dados->only(
                [
                    'co_conselho',
                    'st_avaliacao',
                    'ds_parecer',
                ]
            )->toArray();
            $dadosInclusao['dh_avaliacao'] = $carbon->toDateTimeString();

            $conselhoHabilitacao = $this->getModel()
                ->where($dadosInclusao)
                ->first();

            if ($conselhoHabilitacao) {
                throw new EParametrosInvalidos(
                    'Avaliação já realizada.',
                    Response::HTTP_NOT_ACCEPTABLE
                );
            }

            $novoConselhoHabilitacao = parent::cadastrar($dados);
            $arquivosHabilitacacao = $dados['arquivosAvaliacao'];

            foreach($arquivosHabilitacacao as &$arquivoAvaliacao) {
                $arquivoAvaliacao['co_conselho_habilitacao'] = $novoConselhoHabilitacao->co_conselho_habilitacao;
                $arquivoAvaliacao['co_usuario_avaliador'] = Auth::user()->co_usuario;
                $arquivoAvaliacao['dh_avaliacao'] = $carbon->toDateTimeString();
            }

            $novoConselhoHabilitacao->representanteArquivoAvaliacao()->save($arquivosHabilitacacao);

            DB::commit();
            return $novoConselhoHabilitacao;
        } catch (EParametrosInvalidos $queryException) {
            DB::rollBack();
            throw $queryException;
        }
    }
}
