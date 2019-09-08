<h1>Vota Cultura</h1>
<p>
    Seu cadastro foi realizado com sucesso!
</p>
<p>
    <b>
        CNPJ:
    </b>
    {{ $recursoInscricao->nu_cnpj }}
</p>
<p>
    <b>
        Telefone:
    </b>
    {{ $recursoInscricao->telefone_formatado }}
</p>
<p>
    <b>
        E-mail:
    </b>
    {{ $recursoInscricao->ds_email }}
</p>
<p>
    <b>
        Sítio eletrônico da organização/entidade:
    </b>
    {{ $recursoInscricao->ds_sitio_eletronico }}
</p>
<p>
    <b>
        CEP:
    </b>
    {{ $recursoInscricao->endereco->nu_cep }}
</p>
<p>
    <b>
        Logradouro:
    </b>
    {{ $recursoInscricao->endereco->ds_logradouro }}
</p>
<p>
    <b>
        Complemento:
    </b>
    {{ $recursoInscricao->endereco->ds_complemento }}
</p>
<p>
    <b>
        Unidade da federação da sede:
    </b>
    {{ $recursoInscricao->endereco->municipio->uf->no_uf }}
</p>
<p>
    <b>
        Cidade:
    </b>
    {{ $recursoInscricao->endereco->municipio->no_municipio }}
</p>
<p>
    <b>
        Nome do representante:
    </b>
    {{ $recursoInscricao->representante->no_nome }}
</p>
<p>
    <b>
        Celular do representante:
    </b>
    {{ $recursoInscricao->representante->telefone_formatado }}
</p>
<p>
    <b>
        CPF:
    </b>
    {{ $recursoInscricao->representante->nu_cpf }}
</p>
<p>
    <b>
        RG:
    </b>
    {{ $recursoInscricao->representante->nu_rg }}
</p>
<p>
    <b>
        E-mail do representante:
    </b>
    {{ $recursoInscricao->representante->ds_email }}
</p>
<p>
    <b>
        Segmento:
    </b>
    {{ $recursoInscricao->segmento->ds_detalhamento }}
</p>
<p>
    <b>
        Critérios:
    </b>

    <ul>
        @foreach ($recursoInscricao->criterios as $criterio)
            <li>{{$criterio->ds_criterio}}: {{$criterio->ds_detalhamento}}</li>
        @endforeach
    </ul>
</p>

<p>Atenciosamente,</p>
<p>Minist&eacute;rio da Cidadania</p>
<p>(Mensagem automática, não responder)</p>
