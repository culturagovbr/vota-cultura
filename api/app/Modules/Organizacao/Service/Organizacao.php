<?php

namespace App\Modules\Organizacao\Service;

use App\Core\Service\AbstractService;
use App\Modules\Localidade\Service\Endereco;
use App\Modules\Organizacao\Model\Organizacao as OrganizacaoModel;
use App\Modules\Representacao\Service\Representante;
use App\Modules\Segmento\Service\Segmento;
use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Http\Response;
use function json_decode;
use function json_encode;

class Organizacao extends AbstractService
{
    public function __construct(OrganizacaoModel $model)
    {
        parent::__construct($model);
    }

    public function cadastrar(array $dados): ?Model
    {
        try {
            $organizacao = $this->getModel()->where([
                'ds_email' => $dados['ds_email']
            ])->orWhere([
                'no_organizacao' => $dados['no_organizacao']
            ])->orWhere([
                'nu_cnpj' => $dados['nu_cnpj']
            ])->first();

            $criteriosIds = [];
            foreach($dados['criterios'] as $criterio ) {
                $criteriosIds[] = $criterio;
//                $criteriosIds[] = $criterio;
            }
            print_r(json_encode($criteriosIds));
            die();


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

            foreach($dados['anexos'] as $dadosArquivo) {
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
                        'tp_inscricao' => 1
                    ]
                );
            }

//            Mail::to($organizacao->ds_email)->send(
//                new CadastroComSucesso($organizacao)
//            );
            return $organizacao;
        } catch (\Exception $queryException) {
            DB::rollBack();
            throw $queryException;
        }
    }

}
