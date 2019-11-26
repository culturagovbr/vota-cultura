import { DefaultLayout } from '@/core/components/layouts';

export default [
  {
    path: '/votacao',
    component: DefaultLayout,
    meta: {
      title: 'Votação',
      public: true,
    },
    name: 'Votacao',
    redirect: '/votacao/mapa',
    children: [
      {
        path: '/votacao/mapa',
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
        path: '/votacao/resultado',
        name: 'resultado-votacao-route',
        meta: {
          title: 'Resultado da votação',
          public: true,
        },
        component: () => import(/* webpackChunkName: "resultado-votacao-route" */ '@/modules/votacao/views/VotacaoResultado.vue'),
      },
      {
        path: '/votacao/gerar-resultado-final',
        name: 'administrador-gerar-resultado-final-route',
        meta: {
          title: 'Resultado final',
          public: false,
        },
        component: () => import(/* webpackChunkName: "administrador-gerar-resultado-final-route'" */ '@/modules/votacao/views/VotacaoGerarResultadoFinal.vue'),
      },
      {
        path: '/votacao/ranking-parcial',
        name: 'administrador-ranking-indicados-route',
        meta: {
          title: 'Ranking',
          public: false,
        },
        component: () => import(/* webpackChunkName: "administrador-ranking-indicados-route" */ '@/modules/votacao/views/VotacaoListaParcial.vue'),
      },
      {
        path: '/votacao/:regiao',
        name: 'votacao-indicado-route',
        meta: {
          title: 'Votação',
          public: true,
        },
        component: () => import(/* webpackChunkName: "votacao-indicado-route" */ '@/modules/votacao/views/VotacaoIndicado.vue'),
      },
    ],
  },
];
