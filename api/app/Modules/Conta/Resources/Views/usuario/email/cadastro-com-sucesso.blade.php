<p>
    <b>
        {{ $usuario->no_nome }}
    </b>
    , seu cadastro foi realizado com sucesso!
</p>
<p>
    Clique aqui para ativar o seu cadastro {{ $linkAtivacao }}.
</p>
<p>
    <b>CPF:</b> {{$usuario->no_cpf}}
    <b>E-mail:</b> {{$usuario->no_email}}
    <b>Data de Nascimento:</b> {{$usuario->dt_nascimento->format('d/m/Y')}}
</p>

<p>Atenciosamente,</p>
<p>Minist&eacute;rio do Desenvolvimento Social</p>
