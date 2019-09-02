<h1>Vota Cultura</h1>
<p>
    Seu cadastro como eleitor foi realizado com sucesso!
</p>
<p>
    <b>
        CPF:
    </b>
    {{ $eleitor->nu_cpf }}
</p>
<p>
    <b>
        Nome completo:
    </b>
    {{ $eleitor->no_nome }}
</p>
<p>
    <b>
        RG:
    </b>
    {{ $eleitor->nu_rg }}
</p>
<p>
    <b>
        Data de nascimento:
    </b>
    {{ $eleitor->dt_nascimento->format('d/m/Y') }}
</p>
<p>
    <b>
        E-mail:
    </b>
    {{ $eleitor->ds_email }}
</p>
<p>
    <b>
        Nacionalidade:
    </b>
    {{ $eleitor->nacionalidade }}
</p>
<p>
    <b>
        Unidade da federação:
    </b>
    {{ $eleitor->uf->no_uf }}
</p>

<p>Atenciosamente,</p>
<p>Minist&eacute;rio da Cidadania</p>




(Mensagem automática, não responder)
