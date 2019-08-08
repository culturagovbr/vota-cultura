<?php

namespace App\Modules\Organizacao\Service;

use App\Core\Service\AbstractService;
use App\Modules\Localidade\Service\Endereco;
use App\Modules\Organizacao\Model\Organizacao as OrganizacaoModel;
use App\Modules\Representacao\Service\Representante;
use App\Modules\Representacao\Model\Representante as RepresentanteModel;
use App\Modules\Upload\Model\Arquivo;
use App\Modules\Upload\Service\Upload;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class Organizacao extends AbstractService
{
    public function __construct(OrganizacaoModel $model)
    {
        parent::__construct($model);
    }

    public function cadastrar(array $dados): ?Model
    {
        try {

            $anexos = $dados['anexos'];
            unset($dados['anexos']);

            DB::beginTransaction();
            $organizacao = $this->getModel()->where([
                'ds_email' => $dados['ds_email']
            ])->orWhere([
                'no_organizacao' => $dados['no_organizacao']
            ])->orWhere([
                'nu_cnpj' => $dados['nu_cnpj']
            ])->first();

            if ($organizacao) {
                throw new \HttpException(
                    'Organizacao já cadastrada.',
                    Response::HTTP_NOT_ACCEPTABLE
                );
            }

            $serviceRepresentante = app()->make(Representante::class);
            $representante = $serviceRepresentante->cadastrar($dados['representante']);

            if (!$representante) {
                throw new \HttpException('Não foi possível cadastrar o representante.');
            }
            $dados['co_representante'] = $representante->co_representante;

            $serviceEndereco = app()->make(Endereco::class);
            $endereco = $serviceEndereco->cadastrar($dados['endereco']);

            if (!$endereco) {
                throw new \HttpException('Não foi possível cadastrar o endereço.');
            }

            $dados['co_endereco'] = $endereco->co_endereco;
            $organizacao = parent::cadastrar($dados);

            foreach(array_values($dados['criterios']) as $criterioId) {
                $organizacao->criterios()->attach($criterioId);
            }

            foreach($anexos as $dadosCriterio) {
                $modeloArquivo = app()->make(Arquivo::class);
                $modeloArquivo->fill($dadosCriterio);
                $serviceUpload = new Upload($modeloArquivo);
                $arquivoArmazenado = $serviceUpload->uploadArquivoCodificado(
                    $dadosCriterio['arquivoCodificado'],
                    'organizacao/' . $dadosCriterio['tp_arquivo']
                );

                $representante->arquivos()->attach(
                    $arquivoArmazenado->co_arquivo,
                    [
                        'tp_arquivo' => $dadosCriterio['tp_arquivo'],
                        'tp_inscricao' => RepresentanteModel::TIPO_INSCRICAO_ORGANIZACAO
                    ]
                );
            }

//            Mail::to($organizacao->ds_email)->send(
//                new CadastroComSucesso($organizacao)
//            );

            DB::commit();
            return $organizacao;
        } catch (\Exception $queryException) {
            DB::rollBack();
            throw $queryException;
        }
    }

}
