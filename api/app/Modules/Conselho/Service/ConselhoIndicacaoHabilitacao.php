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
use App\Modules\Core\Exceptions\EParametrosInvalidos;



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
        } catch (EParametrosInvalidos $queryException) {
            DB::rollBack();
            throw $queryException;
        }
    }

    public function atualizar(Request $request, int $identificador) : ?array
    {
        try {
            DB::beginTransaction();

            $conselhoIndicacaoHabilitacaoModel = $this->getModel()->find($identificador);

            if (!$conselhoIndicacaoHabilitacaoModel) {
                throw new EParametrosInvalidos(
                    'Dados não encontrados.',
                    Response::HTTP_NOT_ACCEPTABLE
                );
            }

            $historicoAvaliacao = $conselhoIndicacaoHabilitacaoModel->toArray();

            $conselhoIndicacaoHabilitacaoModel->fill($request->only([
                'ds_parecer',
                'st_avaliacao'
            ]));

            if($request->input('st_revisao_final')){
                $conselhoIndicacaoHabilitacaoModel->st_revisao_final = $request->input('st_revisao_final');
            }

            if (!$conselhoIndicacaoHabilitacaoModel->isDirty()) {
                return $conselhoIndicacaoHabilitacaoModel->toArray();
            }

            $usuarioAutenticado = Auth::user()->dadosUsuarioAutenticado();
            $conselhoIndicacaoHabilitacaoModel->co_usuario_avaliador = $usuarioAutenticado['co_usuario'];
            $conselhoIndicacaoHabilitacaoModel->dh_avaliacao = Carbon::now()->format('Y-m-d H:i:s.u');

            unset($historicoAvaliacao['co_conselho_indicacao_habilitacao']);
            unset($historicoAvaliacao['st_revisao_final']);
            (new ConselhoIndicacaoHabilitacaoHistorico($historicoAvaliacao))->save();

            $conselhoIndicacaoHabilitacaoModel->save();
            DB::commit();
            return $conselhoIndicacaoHabilitacaoModel->toArray();
        } catch (\HttpException $queryException) {
            DB::rollBack();
            throw $queryException;
        }
    }

    public function obterTodosParcialmenteHabilitados()
    {
        return (new \App\Modules\Conselho\Model\ConselhoIndicacao())->has('avaliacaoHabilitacao')->get();
//        return (new \App\Modules\Conselho\Model\ConselhoIndicacao())->whereHas('avaliacaoHabilitacao' , function($q){
//            $q->where('st_avaliacao', TRUE);
//        })->get();
    }
}
