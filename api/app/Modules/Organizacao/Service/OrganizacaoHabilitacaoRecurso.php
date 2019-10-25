<?php

namespace App\Modules\Organizacao\Service;

use App\Core\Service\AbstractService;
use App\Modules\Core\Exceptions\EAcessoRestrito;
use App\Modules\Organizacao\Mail\Organizacao\CadastroOrganizacaoHabilitacaoRecursoSucesso;
use \App\Modules\Organizacao\Model\OrganizacaoHabilitacaoRecurso as OrganizacaoHabilitacaoRecursoModel;
use App\Modules\Core\Exceptions\EParametrosInvalidos;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class OrganizacaoHabilitacaoRecurso extends AbstractService
{
    public function __construct(OrganizacaoHabilitacaoRecursoModel $model)
    {
        parent::__construct($model);
    }

    /**
     * @param $requestParams
     * @return \Illuminate\Database\Eloquent\Model|null
     * @throws EParametrosInvalidos
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function cadastrarHabilitacaoRecurso($requestParams)
    {
        throw new EAcessoRestrito('O prazo de cadastro do recurso expirou.', 412);
    }
}
