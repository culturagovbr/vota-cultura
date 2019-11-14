import { DefaultLayout } from '@/core/components/layouts';

export default [
  {
    path: '/votacao',
    component: DefaultLayout,
    meta: {
      title: 'Votação',
      group: 'apps',
      icon: '',
      public: true,
    },
    name: 'Votacao',
    redirect: '/votacao',
    children: [
      {
        path: '/votacao',
        name: 'votacao-route',
        meta: {
          title: 'Votação',
          group: 'apps',
          icon: 'dashboard',
          public: true,
        },
        component: () => import(/* webpackChunkName: "votacao-route" */ '@/modules/votacao/views/Votacao.vue'),
      },
      {
        path: '/votacao/:regiao',
        name: 'votacao-indicado-route',
        meta: {
          title: 'Votação',
          icon: '',
          public: true,
        },
        component: () => import(/* webpackChunkName: "votacao-indicado-route" */ '@/modules/votacao/views/VotacaoIndicado.vue'),
      },
    ],
  },
];
