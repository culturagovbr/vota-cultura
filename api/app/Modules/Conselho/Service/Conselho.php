<?php

namespace App\Modules\Conselho\Service;

use App\Core\Service\AbstractService;
use App\Modules\Conselho\Mail\Conselho\CadastroComSucesso;
use App\Modules\Conselho\Model\Conselho as ConselhoModel;
use App\Modules\Localidade\Service\Endereco;
use App\Modules\Representacao\Service\Representante;
use App\Modules\Representacao\Model\Representante as RepresentanteModel;
use App\Modules\Upload\Service\Upload;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Response;
use App\Modules\Upload\Model\Arquivo;
use Illuminate\Support\Facades\Mail;

class Conselho extends AbstractService
{
    public function __construct(ConselhoModel $model)
    {
        parent::__construct($model);
    }

    public function cadastrar(array $dados): ?Model
    {
        try {
            $anexos = $dados['anexos'];
            unset($dados['anexos']);

            DB::beginTransaction();

            $conselho = $this->getModel()->where([
                'ds_email' => $dados['ds_email']
            ])->orWhere([
                'no_orgao_gestor' => $dados['no_orgao_gestor']
            ])->orWhere([
                'nu_cnpj' => $dados['nu_cnpj']
            ])->first();

            if ($conselho) {
                throw new \HttpException(
                    'Conselho já cadastrado.',
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
            $conselho = parent::cadastrar($dados);

            foreach($anexos as $dadosArquivo) {
                $modeloArquivo = app()->make(Arquivo::class);
                $modeloArquivo->fill($dadosArquivo);
                $serviceUpload = new Upload($modeloArquivo);
                $arquivoArmazenado = $serviceUpload->uploadArquivoCodificado(
                    $dadosArquivo['arquivoCodificado'],
                    'conselho/' . $dadosArquivo['tp_arquivo']
                );
                $representante->arquivos()->attach(
                    $arquivoArmazenado->co_arquivo,
                    [
                        'tp_arquivo' => $dadosArquivo['tp_arquivo'],
                        'tp_inscricao' => RepresentanteModel::TIPO_INSCRICAO_CONSELHO
                    ]
                );
            }

            Mail::to($representante->ds_email)->send(
                new CadastroComSucesso($representante)
            );

            DB::commit();
            return $conselho;
        } catch (\Exception $queryException) {
            DB::rollBack();
            throw $queryException;
        }
    }
}
