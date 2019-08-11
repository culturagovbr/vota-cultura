<p>
    <b>
        {{ $usuario->no_nome }}
    </b>
    , seu cadastro foi realizado com sucesso!
</p>
<p>
    Clique <a href="{{ $linkAtivacao }}">aqui</a> para ativar o seu cadastro.
</p>
<p>
    <b>CPF:</b> {{$usuario->no_cpf}}
    <b>E-mail:</b> {{$usuario->ds_email}}
    <b>Data de Nascimento:</b> {{$usuario->dt_nascimento->format('Localizacao')}}
</p>

<p>Atenciosamente,</p>
<p>Minist&eacute;rio do Desenvolvimento Social</p>
