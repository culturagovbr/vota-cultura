<?php

namespace App\Modules\Upload\Service;

use App\Core\Service\AbstractService;
use App\Modules\Core\Exceptions\EParametrosInvalidos;
use App\Modules\Representacao\Model\Representante as RepresentanteModel;
use App\Modules\Upload\Model\Arquivo as ArquivoModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;


class Upload extends AbstractService
{
    public function __construct(ArquivoModel $model)
    {
        parent::__construct($model);
    }

    public function uploadArquivoCodificadoBase64($stringCodificada, $diretorioArmazenamento = '')
    {
        try {
            DB::beginTransaction();
            $arquivoDecodificado = base64_decode($stringCodificada);
            $model = $this->getModel();
            $nomeArquivo = uniqid() . '.' . $model->no_extensao;
            $localizacaoArquivo = "{$diretorioArmazenamento}/{$nomeArquivo}";
            Storage::put($localizacaoArquivo, $arquivoDecodificado);
            $model->ds_localizacao = $localizacaoArquivo;
            $model->save();
            DB::commit();
            return $model;
        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }

    public function uploadArquivoCodificado(\Illuminate\Http\UploadedFile $binario, $diretorioArmazenamento = '')
    {
        try {
            DB::beginTransaction();
            $model = $this->getModel();
            $nomeArquivo = uniqid() . '.' . $model->no_extensao;
            $localizacaoArquivo = "{$diretorioArmazenamento}";
            Storage::putFileAs($localizacaoArquivo, $binario, $nomeArquivo);
            $model->ds_localizacao = "{$localizacaoArquivo}/{$nomeArquivo}";
            $model->save();
            DB::commit();
            return $model;
        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }

    public function downloadArquivo($identificador)
    {
        $usuario = Auth::user();

        if ($usuario->souAdministrador()) {
            $arquivoModel = app(ArquivoModel::class);

            $arquivo = $arquivoModel->find($identificador);

            if (empty($arquivo)) {
                throw new EParametrosInvalidos("O arquivo solicitado não existe.");
            }
            return Storage::download($arquivo->ds_localizacao, $arquivo->no_arquivo);
        }

        $representanteModel = app(RepresentanteModel::class);
        $representante = $representanteModel->where([
            'nu_cpf' => $usuario->nu_cpf
        ])->first();

        if (empty($representante)) {
            throw new EParametrosInvalidos("O usuario logado não possui representante cadastrado.");
        }

        $arquivosDoRepresentante = $representante->arquivos()->get();
        $arquivo = $arquivosDoRepresentante->where('co_arquivo', $identificador)->first();

        if (empty($arquivo)) {
            throw new EParametrosInvalidos("O arquivo solicitado não existe.");
        }

        return Storage::download($arquivo->ds_localizacao, $arquivo->no_arquivo);
    }
}
