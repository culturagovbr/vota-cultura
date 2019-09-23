import { DefaultLayout } from '@/core/components/layouts';

export default [
  {
    path: '/',
    component: DefaultLayout,
    meta: {
      title: 'Início',
      group: 'apps',
      icon: '',
    },
    redirect: 'inicio',
    children: [
      {
        path: 'inicio',
        name: 'Inicio',
        meta: {
          title: 'Início',
          group: 'apps',
          icon: 'dashboard',
          public: true,
        },
        component: () => import(/* webpackChunkName: "inicio" */ '@/modules/site/views/Inicio.vue'),
      },
      {
        path: 'inscricao/lista-parcial',
        name: 'inscricao-lista-parcial-route',
        meta: {
          title: 'Lista final de inscritos',
          group: 'apps',
          icon: 'dashboard',
          public: true,
        },
        component: () => import(/* webpackChunkName: "inscricao-lista-parcial-route" */ '@/modules/site/views/inscricao/ListaParcial.vue'),
      },
      {
        path: 'inscricao/administrador/lista-parcial',
        name: 'administrador-lista-inscritos-route',
        meta: {
          title: 'Inscritos',
          group: 'apps',
          icon: 'dashboard',
          public: false,
        },
        component: () => import(/* webpackChunkName: "administrador-lista-inscritos-route" */ '@/modules/site/views/administrador/AdministradorListaIncritos.vue'),
      },
    ],
  },
];
