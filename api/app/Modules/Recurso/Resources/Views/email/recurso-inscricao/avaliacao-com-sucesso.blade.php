<h1>Vota Cultura</h1>
<p>
    Seu recurso foi avaliado.
</p>
<div>
    <p>
        <b>
            Categoria:
        </b>
        {{ $recursoInscricao->fase->ds_detalhamento }}
    </p>
    <p>
        <b>
            CNPJ:
        </b>
        {{ $recursoInscricao->cnpj_formatado }}
    </p>
    <p>
        <b>
            Razão social:
        </b>
        {{ $recursoInscricao->no_razao_social }}
    </p>
    <p>
        <b>
            Celular do representante:
        </b>
        {{ $recursoInscricao->telefone_formatado }}
    </p>
    <p>
        <b>
            CPF:
        </b>
        {{ $recursoInscricao->cpf_formatado }}
    </p>
    <p>
        <b>
            Nome do representante:
        </b>
        {{ $recursoInscricao->no_representante }}
    </p>
    <p>
        <b>
            E-mail do representante:
        </b>
        {{ $recursoInscricao->ds_email }}
    </p>
    <p>
        Este e-mail deverá ser acessado para acompanhamento do recurso
    </p>
    <p>
        <b>
            Recurso:
        </b>
        {{ $recursoInscricao->ds_recurso }}
    </p>
</div>
<div>
    <h3>Avaliação do recurso</h3>
    <p>
        <b>
            Parecer:
        </b>
    </p>
    <p>
        {{ $recursoInscricao->ds_parecer }}
    </p>
    <p>
        O recurso foi
        <b>
        {{ ($recursoInscricao->st_parecer === '1') ? 'aceito' : 'recusado' }}
        </b>.
    </p>
</div>

<p>Atenciosamente,</p>
<p>Minist&eacute;rio da Cidadania</p>
<p>(Mensagem automática, não responder)</p>
