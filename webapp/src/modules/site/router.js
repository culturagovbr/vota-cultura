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
          title: 'Lista Parcial de Inscritos',
          group: 'apps',
          icon: 'dashboard',
          public: true,
        },
        component: () => import(/* webpackChunkName: "inscricao-lista-parcial-route" */ '@/modules/site/views/inscricao/ListaParcial.vue'),
      },
    ],
  },
];
