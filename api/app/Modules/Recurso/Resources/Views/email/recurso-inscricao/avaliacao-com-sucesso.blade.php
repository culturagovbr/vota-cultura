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
            E-mail do representante:
        </b>
        {{ $recursoInscricao->ds_email }}
    </p>
    <p>
        <b>
            Recurso:
        </b>
        {{ $recursoInscricao->ds_recurso }}
    </p>
</div>
<div>
    <p>
        <b>
            Parecer:
        </b>
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
