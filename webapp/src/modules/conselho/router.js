import { DefaultLayout } from '@/core/components/layouts';

export default [
  {
    path: '/conselho',
    component: DefaultLayout,
    meta: {
      title: 'Conselho',
      group: 'apps',
      icon: '',
      public: true,
    },
    name: 'Conselho',
    redirect: '/conselho/inscricao',
    children: [
      {
        path: '/conselho/inscricao',
        name: 'InscricaoConselho',
        meta: {
          title: 'Inscrição Conselho',
          group: 'apps',
          icon: 'dashboard',
          public: true,
        },
        component: () => import(/* webpackChunkName: "conselho-inscricao" */ '@/modules/conselho/views/Conselho.vue'),
      },
      {
        path: '/conselho/revisao-conselho',
        name: 'InscricaoConselhoRevisao',
        meta: {
          title: 'Revisão - Dados Conselho',
          group: 'apps',
          icon: 'dashboard',
          public: true,
        },
        component: () => import(/* webpackChunkName: "conselho-revisao-conselho" */ '@/modules/conselho/views/RevisaoConselho.vue'),
      },
      {
        path: '/conselho/habilitacao-recurso',
        name: 'ConselhoHabilitacaoRecursoRoute',
        meta: {
          title: 'Recurso da habilitação',
          group: 'apps',
          icon: 'gavel',
          public: false,
        },
        component: () => import(/* webpackChunkName: "cadastra-recurso-habilitacao" */ '@/modules/conselho/views/ConselhoHabilitacaoRecurso.vue'),
      },
      {
        path: '/conselho/detalhes-inscricao',
        name: 'ConselhoDetalhesInscricaoRoute',
        meta: {
          title: 'Detalhes da inscrição',
          group: 'apps',
          icon: 'dashboard',
          public: false,
        },
        component: () => import(/* webpackChunkName: "conselho-detalhes-inscricao" */ '@/modules/conselho/views/ConselhoDetalhesInscricao.vue'),
      },
      {
        path: '/conselho/lista-habilitacao',
        name: 'ConselhoListaHabilitacaoRoute',
        meta: {
          title: 'Habilitação de conselhos',
          group: 'apps',
          icon: 'dashboard',
          public: false,
        },
        component: () => import(/* webpackChunkName: "conselho-lista-habilitacao" */ '@/modules/conselho/views/ConselhoListaHabilitacao.vue'),
      },
      {
        path: '/conselho/indicacao',
        name: 'ConselhoIndicacaoRoute',
        meta: {
          title: 'Indicação - Conselho de cultura',
          group: 'apps',
          icon: 'dashboard',
          public: false,
        },
        component: () => import(/* webpackChunkName: "conselho-indicacao" */ '@/modules/conselho/views/ConselhoIndicacao.vue'),
      },
      {
        path: '/conselho/indicacao-habilitacao',
        name: 'ConselhoIndicacaoHabilitacaoRoute',
        meta: {
          title: 'Habilitação de indicados - Conselho de cultura',
          group: 'apps',
          icon: 'dashboard',
          public: false,
        },
        component: () => import(/* webpackChunkName: "conselho-indicacao-habilitacao" */ '@/modules/conselho/views/ConselhoIndicacaoHabilitacao.vue'),
      },
    ],
  },
];
