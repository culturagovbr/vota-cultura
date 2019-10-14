<?php

namespace App\Modules\Conselho\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Modules\Core\Exceptions\EParametrosInvalidos;
use App\Modules\Upload\Model\Arquivo;
use Illuminate\Support\Facades\DB;

class ConselhoIndicacaoArquivoController extends Controller
{
    public function store(Request $request)
    {
        if(empty($request->anexos)) {
          throw new EParametrosInvalidos('Nenhum anexo informado')  ;
        }

        $anexos = $request->anexos;
        /** @var UploadedFile $uploadedFile */
        DB::beginTransaction();
        try {
            foreach($anexos as $uploadedFile) {
                $modeloUpload = [
                    'no_arquivo'  => $uploadedFile->getClientOriginalName(),
                    'no_extensao'  => $uploadedFile->getClientOriginalExtension(),
                    'no_mime_type'  => $uploadedFile->getClientMimeType(),
                ];
    
                $modeloArquivo = app(Arquivo::class);
                $modeloArquivo->fill($modeloUpload);
                $serviceUpload = new Upload($modeloArquivo);
    
                $arquivoArmazenado = $serviceUpload->uploadArquivoCodificado(
                    $uploadedFile,
                    'conselho/indicacao/'
                );
                $this->salvarRelacionamentoConselhoIndicacaoArquivo($arquivoArmazenado, $uploadedFile->slug);
            }
            DB::commit();
        } catch (EParametrosInvalidos $queryException) {
            DB::rollBack();
            throw $queryException;
        }
    }
    
    private function salvarRelacionamentoConselhoIndicacaoArquivo($arquivoArmazenado, $slugArquivo)
    {
        $conselhoIndicacaoModel = app(ConselhoIndicacaoModel::class);
        $conselhoUsuarioLogado = $this->recuperarDadosConselhoUsuarioLogado();
        /** @var ConselhoIndicacaoModel $conselhoIndicacao */
        $conselhoIndicacao = $conselhoIndicacaoModel->where([
            'co_conselho' => $conselhoUsuarioLogado['co_conselho']
        ])->first();
        $conselhoIndicacao->arquivos()->attach(
            $arquivoArmazenado->co_arquivo,
            [
                'tp_arquivo' => $slugArquivo,
            ]
        );
    }

    private function recuperarDadosConselhoUsuarioLogado() : array
    {
        $usuarioAutenticado = Auth::user()->dadosUsuarioAutenticado();
        $modelConselho = app(\App\Modules\Conselho\Model\Conselho::class);
        return $modelConselho->where([
            'co_conselho' => $usuarioAutenticado['co_conselho']
        ])->first();
    }
}

