import { AuthLayout } from '@/core/components/layouts';

export default [
  {
    path: '/conta',
    component: AuthLayout,
    meta: { title: 'Login' },
    redirect: '/conta/login',
    hidden: true,
    children: [
      {
        path: 'autenticar',
        name: 'conta-autenticar',
        meta: { title: 'Autenticar', public: true },
        component: () => import(/* webpackChunkName: "autenticar" */ '@/modules/conta/views/Login.vue'),
      },
      {
        path: 'sair',
        name: 'conta-sair',
        meta: { title: 'Sair do sistema', public: true },
        component: () => import(/* webpackChunkName: "logout" */ '@/modules/conta/views/Logout.vue'),
      },
      {
        path: 'cadastrar',
        name: 'conta-cadastrar',
        meta: { title: 'Cadastrar-se', public: true },
        component: () => import(/* webpackChunkName: "cadastro" */ '@/modules/conta/views/Cadastro.vue'),
      },
      {
        path: 'ativar-usuario/:ds_codigo_ativacao',
        name: 'conta-ativar-usuario',
        meta: { title: 'Ativar usuário', public: true },
        component: () => import(/* webpackChunkName: "cadastro-ativacao-usuario" */ '@/modules/conta/views/CadastroAtivacaoUsuario.vue'),
      },
      {
        path: 'cadastro2',
        name: 'cadastro2',
        meta: { title: 'Cadastrar-se', public: true },
        component: () => import(/* webpackChunkName: "login" */ '@/modules/conta/views/CadastroPassos.vue'),
      },
      {
        path: 'recuperar-senha',
        name: 'conta-recuperar-senha',
        meta: { title: 'Recuperar Senha', public: true },
        component: () => import(/* webpackChunkName: "recuperar-senha" */ '@/modules/conta/views/RecuperacaoDeSenha.vue'),
      },
    ],
  },
];
