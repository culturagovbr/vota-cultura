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
        meta: {
          name: 'inscricao-lista-parcial',
          title: 'Lista Parcial de Inscritos',
          group: 'apps',
          icon: 'dashboard',
          public: true,
        },
        component: () => import(/* webpackChunkName: "inscricao-lista-parcial" */ '@/modules/site/views/inscricao/ListaParcial.vue'),
      },
    ],
  },
];
