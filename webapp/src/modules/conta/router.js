import { AuthLayout , DefaultLayout } from '@/core/components/layouts';


export default [
  {
    path: '/conta',
    component: AuthLayout,
    meta: { title: 'Login' },
    redirect: '/conta/autenticar',
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
        path: 'recuperar-senha',
        name: 'conta-recuperar-senha',
        meta: { title: 'Recuperar Senha', public: true },
        component: () => import(/* webpackChunkName: "recuperar-senha" */ '@/modules/conta/views/RecuperacaoDeSenha.vue'),
      },
      {
        path: 'alterar-senha/:ds_codigo_alteracao',
        name: 'conta-alterar-senha',
        meta: { title: 'Alterar Senha', public: true },
        component: () => import(/* webpackChunkName: "conta-alterar-senha" */ '@/modules/conta/views/AlteracaoDeSenha.vue'),
      },
      {
        path: 'primeiro-acesso',
        name: 'conta-primeiro-acesso',
        meta: { title: 'Primeiro Acesso', public: true },
        component: () => import(/* webpackChunkName: "conta-primeiro-acesso" */ '@/modules/conta/views/PrimeiroAcesso.vue'),
      },
    ],
  },
  {
    path: '/conta/usuario',
    component: DefaultLayout,
    hidden: true,
    children: [
      {
        path: 'alterar-senha',
        name: 'conta-usuario-alterar-senha',
        meta: { title: 'Alterar Senha', public: true },
        component: () => import(/* webpackChunkName: "recuperar-senha" */ '@/modules/conta/views/usuario/AlteracaoDeSenha.vue'),
      },
    ],
  },
];
