<?php

namespace App\Modules\Conselho\Service;

use App\Core\Service\AbstractService;
use App\Modules\Conselho\Model\ConselhoIndicacaoHabilitacao as ConselhoIndicacaoHabilitacaoModel;
use App\Modules\Conselho\Model\ConselhoIndicacaoHabilitacaoHistorico;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class ConselhoIndicacaoHabilitacao extends AbstractService
{
    public function __construct(ConselhoIndicacaoHabilitacaoModel $model)
    {
        parent::__construct($model);
    }

    public function cadastrar(Collection $dados): ?Model
    {
        try {
            DB::beginTransaction();
            $usuarioAutenticado = Auth::user()->dadosUsuarioAutenticado();

            $conselhoIndicacaoHabilitacaoModel = $this->getModel()->fill(
                $dados->only([
                    'ds_parecer',
                    'st_avaliacao',
                    'co_indicado',
                ])->toArray()
            );

            $conselhoIndicacaoHabilitacaoModel->co_usuario_avaliador = $usuarioAutenticado['co_usuario'];

            $conselhoIndicacaoHabilitacaoModel->save();
            DB::commit();
            return $conselhoIndicacaoHabilitacaoModel;
        } catch (\HttpException $queryException) {
            DB::rollBack();
            throw $queryException;
        }
    }

    public function atualizar(Request $request, int $identificador) : ?array
    {
        try {
            $conselhoIndicacaoHabilitacaoModel = $this->getModel()->find($identificador);

            if (!$conselhoIndicacaoHabilitacaoModel) {
                throw new \HttpException(
                    'Dados não encontrados.',
                    Response::HTTP_NOT_ACCEPTABLE
                );
            }

            DB::beginTransaction();

            $historicoAvaliacao = $conselhoIndicacaoHabilitacaoModel;

            $conselhoIndicacaoHabilitacaoModel->fill($request->only([
                'ds_parecer',
                'st_avaliacao'
            ]));

            $usuarioAutenticado = Auth::user()->dadosUsuarioAutenticado();
            $conselhoIndicacaoHabilitacaoModel->co_usuario_avaliador = $usuarioAutenticado['co_usuario'];
            $conselhoIndicacaoHabilitacaoModel->dh_avaliacao = Carbon::now()->format('Y-m-d H:i:s.u');

            unset($conselhoIndicacaoHabilitacaoModel->co_conselho_indicacao_habilitacao);
            unset($conselhoIndicacaoHabilitacaoModel->st_revisao_final);


            $teste = new ConselhoIndicacaoHabilitacaoHistorico();

            print_r($conselhoIndicacaoHabilitacaoModel->toArray());
            die;

            $conselhoIndicacaoHabilitacaoModel->save();
            DB::rollBack();
//            DB::commit();
            return $conselhoIndicacaoHabilitacaoModel->toArray();
        } catch (\HttpException $queryException) {
            DB::rollBack();
            throw $queryException;
        }
    }
}
