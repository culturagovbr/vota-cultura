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
        component: () => import(/* webpackChunkName: "eleitor" */ '@/modules/conselho/views/Conselho.vue'),
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
        component: () => import(/* webpackChunkName: "eleitor" */ '@/modules/conselho/views/RevisaoConselho.vue'),
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
        // component: () => import(/* webpackChunkName: "eleitor" */ '@/modules/conselho/views/ConselhoDetalhesInscricao.vue'),
      },
    ],
  },
];
