<h1>Vota Cultura</h1>
<p>
    Seu cadastro foi realizado com sucesso!
</p>
<p>
    <b>
        CPF:
    </b>
    {{ $eleitor->nu_cpf }}
</p>
<p>
    <b>
        Nome Completo:
    </b>
    {{ $eleitor->no_eleitor }}
</p>
<p>
    <b>
        RG:
    </b>
    {{ $eleitor->nu_rg }}
</p>
<p>
    <b>
        CPF:
    </b>
    {{ $eleitor->nu_cpf }}
</p>
<p>
    <b>
        Data de Nascimento:
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
        Unidade da Federação:
    </b>
    {{ $eleitor->uf->no_uf }}
</p>

<p>Atenciosamente,</p>
<p>Minist&eacute;rio da Cidadania</p>
