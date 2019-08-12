<h1>Vota Cultura</h1>
<p>
    Seu cadastro foi realizado com sucesso!
</p>
<p>
    <b>
        CNPJ:
    </b>
    {{ $organizacao->nu_cnpj }}
</p>
<p>
    <b>
        Nome da Organização/Entidade:
    </b>
    {{ $organizacao->no_organizacao }}
</p>
<p>
    <b>
        Telefone:
    </b>
    {{ $organizacao->telefone_formatado }}
</p>
<p>
    <b>
        E-mail:
    </b>
    {{ $organizacao->ds_email }}
</p>
<p>
    <b>
        Sítio eletrônico da Organização/Entidade:
    </b>
    {{ $organizacao->ds_sitio_eletronico }}
</p>
<p>
    <b>
        CEP:
    </b>
    {{ $organizacao->endereco->nu_cep }}
</p>
<p>
    <b>
        Logradouro:
    </b>
    {{ $organizacao->endereco->ds_logradouro }}
</p>
<p>
    <b>
        Complemento:
    </b>
    {{ $organizacao->endereco->ds_complemento }}
</p>
<p>
    <b>
        Unidade da Federação da sede:
    </b>
    {{ $organizacao->endereco->municipio->uf->no_uf }}
</p>
<p>
    <b>
        Cidade:
    </b>
    {{ $organizacao->endereco->municipio->no_municipio }}
</p>
<p>
    <b>
        Nome do representante:
    </b>
    {{ $organizacao->representante->no_pessoa }}
</p>
<p>
    <b>
        Celular do representante:
    </b>
    {{ $organizacao->representante->telefone_formatado }}
</p>
<p>
    <b>
        CPF:
    </b>
    {{ $organizacao->representante->nu_cpf }}
</p>
<p>
    <b>
        RG:
    </b>
    {{ $organizacao->representante->nu_rg }}
</p>
<p>
    <b>
        E-mail do representante:
    </b>
    {{ $organizacao->representante->ds_email }}
</p>
<p>
    <b>
        Segmento:
    </b>
    {{ $organizacao->segmento->ds_detalhamento }}
</p>
<p>
    <b>
        Critérios:
    </b>

    <ul>
        @foreach ($organizacao->criterios as $criterio)
            <li>{{$criterio->ds_criterio}}: {{$criterio->ds_detalhamento}}</li>
        @endforeach
    </ul>
</p>

<p>Atenciosamente,</p>
<p>Minist&eacute;rio da Cidadania</p>
