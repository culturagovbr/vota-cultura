<?php

namespace App\Modules\Eleitor\Service;

use App\Core\Service\AbstractService;
use App\Modules\Eleitor\Mail\Eleitor\CadastroComSucesso;
use App\Modules\Localidade\Service\Endereco;
use App\Modules\Eleitor\Model\Eleitor as EleitorModel;
use App\Modules\Representacao\Service\Representante;
use App\Modules\Upload\Service\Upload;
use App\Modules\Upload\Model\Arquivo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;

class Eleitor extends AbstractService
{
    public function __construct(EleitorModel $model)
    {
        parent::__construct($model);
    }

    public function cadastrar(array $dados): ?Model
    {
        try {
            $eleitor = $this->getModel()->where([
                'nu_cpf' => $dados['nu_cpf']
            ])->orWhere([
                'nu_rg' => $dados['nu_rg']
            ])->orWhere([
                'ds_email' => $dados['ds_email']
            ])->first();

            if ($eleitor) {
                throw new \Exception(
                    Response::HTTP_NOT_ACCEPTABLE,
                    'Eleitor já cadastrado.'
                );
            }

            $eleitor = parent::cadastrar($dados);

            foreach($dados['anexos'] as $dadosArquivo) {
                $modeloArquivo = app()->make(Arquivo::class);
                $modeloArquivo->fill($dadosArquivo);
                $serviceUpload = new Upload($modeloArquivo);
                $arquivoArmazenado = $serviceUpload->uploadArquivoCodificado(
                    $dadosArquivo['arquivoCodificado'],
                    'eleitor/' . $dadosArquivo['tp_arquivo']
                );
                $eleitor->arquivos()->attach(
                    $arquivoArmazenado->co_arquivo,
                    ['tp_arquivo' => $dadosArquivo['tp_arquivo']]
                );
            }

            Mail::to($eleitor->ds_email)->send(
                new CadastroComSucesso($eleitor)
            );

            return $eleitor;
        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }

}
