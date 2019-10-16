<?php

namespace App\Modules\Conselho\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Modules\Conselho\Model\ConselhoIndicacao;
use App\Modules\Core\Exceptions\EParametrosInvalidos;
use App\Modules\Upload\Model\Arquivo;
use App\Modules\Upload\Service\Upload;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ConselhoIndicacaoArquivoController extends Controller
{
    public function store(Request $request)
    {
        $dados = $request->all();
        
        if(empty($dados['binario'])) {
          throw new EParametrosInvalidos('Nenhum anexo informado')  ;
        }
        
        try {
            
            DB::beginTransaction();
            /** @var UploadedFile $uploadedFile */
            $uploadedFile = $request['binario'];
            $slug = $request['slug'];
            $coConselhoIndicacao = $request['co_conselho_indicacao'];
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
                'conselho/indicacao'
            );
            $this->salvarRelacionamentoConselhoIndicacaoArquivo($arquivoArmazenado, $slug, $coConselhoIndicacao);
            DB::commit();
        } catch (EParametrosInvalidos $queryException) {
            DB::rollBack();
            throw $queryException;
        }
    }
    
    private function salvarRelacionamentoConselhoIndicacaoArquivo($arquivoArmazenado, $slugArquivo, $coConselhoIndicacao)
    {
        $conselhoIndicacaoModel = app(ConselhoIndicacao::class);
        $conselhoUsuarioLogado = $this->recuperarDadosConselhoUsuarioLogado();
        /** @var ConselhoIndicacao $conselhoIndicacao */
        $conselhoIndicacao = $conselhoIndicacaoModel->where([
            'co_conselho' => $conselhoUsuarioLogado->co_conselho
        ])->first();
        $conselhoIndicacao->arquivos()->attach(
            $arquivoArmazenado->co_arquivo,
            [
                'tp_arquivo' => $slugArquivo,
                'co_conselho_indicacao' => $coConselhoIndicacao
            ]
        );
    }

    private function recuperarDadosConselhoUsuarioLogado()
    {
        $usuarioAutenticado = Auth::user()->dadosUsuarioAutenticado();
        $modelConselho = app(\App\Modules\Conselho\Model\Conselho::class);
        return $modelConselho->where([
            'co_conselho' => $usuarioAutenticado['co_conselho']
        ])->first();
    }
}

