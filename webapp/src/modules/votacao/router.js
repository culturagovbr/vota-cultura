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
        path: '/votacao/ranking-parcial',
        name: 'administrador-ranking-indicados-route',
        meta: {
          title: 'Ranking',
          icon: '',
          public: false,
        },
        component: () => import(/* webpackChunkName: "administrador-ranking-indicados-route" */ '@/modules/votacao/views/VotacaoListaParcial.vue'),
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
