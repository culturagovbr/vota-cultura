<p>
    <b>
        {{ $usuario->no_nome }}
    </b>
    , seu cadastro foi realizado com sucesso!
    <p>
    Sua senha é <b>{{$usuario->ds_senha}}</b>.
    </p>
</p>
<p>
    Clique <a href="{{ $linkAtivacao }}">aqui</a> para ativar o seu cadastro.
</p>
<p>
    <b>CPF:</b> {{$usuario->nu_cpf}}
</p>
<p>
    <b>E-mail:</b> {{$usuario->ds_email}}
</p>

<p>Atenciosamente,</p>
<p>Minist&eacute;rio do Desenvolvimento Social</p>
