import { AuthLayout, DefaultLayout } from '@/core/components/layouts';


export default [
  {
    path: '/conta',
    component: AuthLayout,
    meta: {
      title: 'Login',
    },
    redirect: '/conta/autenticar',
    hidden: true,
    children: [
      {
        path: 'autenticar',
        name: 'conta-autenticar',
        meta: {
          title: 'Autenticar',
          public: true,
        },
        // beforeEnter: (to, from, next) => {
        //   console.log('to');
        //   console.log('from');
        // },
        component: () => import(/* webpackChunkName: "conta-autenticar" */ '@/modules/conta/views/Login.vue'),
      },
      {
        path: 'sair',
        name: 'conta-sair',
        meta: {
          title: 'Sair do sistema',
          public: true,
        },
        component: () => import(/* webpackChunkName: "conta-logout" */ '@/modules/conta/views/Logout.vue'),
      },
      {
        path: 'cadastrar',
        name: 'conta-cadastrar',
        meta: {
          title: 'Cadastrar-se',
          public: true,
        },
        component: () => import(/* webpackChunkName: "conta-cadastro" */ '@/modules/conta/views/Cadastro.vue'),
      },
      {
        path: 'ativar-usuario/:ds_codigo_ativacao',
        name: 'conta-ativar-usuario',
        meta: {
          title: 'Ativar usuário',
          public: true,
        },
        component: () => import(/* webpackChunkName: "conta-cadastro-ativacao-usuario" */ '@/modules/conta/views/CadastroAtivacaoUsuario.vue'),
      },
      {
        path: 'recuperar-senha',
        name: 'conta-recuperar-senha',
        meta: {
          title: 'Recuperar Senha',
          public: true,
        },
        component: () => import(/* webpackChunkName: "conta-recuperar-senha" */ '@/modules/conta/views/RecuperacaoDeSenha.vue'),
      },
      {
        path: 'alterar-senha/:ds_codigo_ativacao',
        name: 'conta-alterar-senha',
        meta: {
          title: 'Definir Senha',
          public: true,
        },
        component: () => import(/* webpackChunkName: "conta-alterar-senha" */ '@/modules/conta/views/AlteracaoDeSenha.vue'),
      },
      {
        path: 'primeiro-acesso',
        name: 'conta-primeiro-acesso',
        meta: {
          title: 'Criar login de acesso',
          public: true,
        },
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
        meta: {
          title: 'Alterar Senha',
          public: true,
        },
        component: () => import(/* webpackChunkName: "conta-recuperar-senha" */ '@/modules/conta/views/usuario/AlteracaoDeSenha.vue'),
      },
    ],
  },
  {
    path: '/conta/administrador',
    component: DefaultLayout,
    hidden: true,
    redirect: '/conta/administrador/usuario',
    children: [
      {
        path: 'usuario',
        name: 'administrador-lista-usuarios-route',
        meta: {
          title: 'Usuarios',
          public: false,
        },
        component: () => import(/* webpackChunkName: "conta-administrador-lista-usuarios-route" */ '@/modules/conta/views/administrador/AdministradorListaUsuarios.vue'),
      },
    ],
  },
  {
    path: '/conta/administrador',
    component: DefaultLayout,
    hidden: true,
    redirect: '/conta/administrador/usuario',
    children: [
      {
        path: 'usuario',
        name: 'administrador-lista-usuarios-route',
        meta: {
          title: 'Usuarios',
          public: false,
        },
        component: () => import(/* webpackChunkName: "conta-administrador-lista-usuarios-route" */ '@/modules/conta/views/administrador/AdministradorListaUsuarios.vue'),
      },
    ],
  },
];
