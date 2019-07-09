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
        path: 'login',
        name: 'login',
        meta: { title: 'Login', public: true },
        component: () => import(/* webpackChunkName: "login" */ '@/modules/conta/views/Login.vue'),
      },
      {
        path: 'cadastro',
        name: 'cadastro',
        meta: { title: 'Cadastrar-se', public: true },
        component: () => import(/* webpackChunkName: "login" */ '@/modules/conta/views/Cadastro.vue'),
      },
      {
        path: 'recuperar-senha',
        name: 'recuperar-senha',
        meta: { title: 'Recuperar Senha', public: true },
        component: () => import(/* webpackChunkName: "login" */ '@/modules/conta/views/RecuperacaoDeSenha.vue'),
      },
    ],
  },
];
