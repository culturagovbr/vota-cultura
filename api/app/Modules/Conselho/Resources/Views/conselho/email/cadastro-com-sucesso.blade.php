<h1>Vota Cultura</h1>
<p>
    Seu cadastro foi realizado com sucesso!
</p>
<p>
    <b>
        CPF:
    </b>
    {{ $conselho->nu_cpf }}
</p>
<p>
    <b>
        Nome Completo:
    </b>
    {{ $conselho->no_eleitor }}
</p>
<p>
    <b>
        RG:
    </b>
    {{ $conselho->nu_rg }}
</p>
<p>
    <b>
        CPF:
    </b>
    {{ $conselho->nu_cpf }}
</p>
<p>
    <b>
        Data de Nascimento:
    </b>
    {{ $conselho->dt_nascimento->format('d/m/Y') }}
</p>
<p>
    <b>
        E-mail:
    </b>
    {{ $conselho->ds_email }}
</p>
<p>
    <b>
        Nacionalidade:
    </b>
    {{ $conselho->nacionalidade }}
</p>
<p>
    <b>
        Unidade da Federação:
    </b>
    {{ $conselho->uf->no_uf }}
</p>

<p>Atenciosamente,</p>
<p>Minist&eacute;rio da Cidadania</p>
