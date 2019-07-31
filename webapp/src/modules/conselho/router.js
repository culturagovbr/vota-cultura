import {AuthLayout, DefaultLayout} from '@/core/components/layouts';

export default [
  {
    path: '/conselho',
    component: DefaultLayout,
    meta: {
      title: 'Conselho',
      group: 'apps',
      icon: ''
    },
    redirect: '/conselho',
    children: [
      {
        path: '/conselho/inscricao',
        name: 'InscricaoConselho',
        meta: {
          title: 'Inscrição Conselho',
          group: 'apps',
          icon: 'dashboard',
        },
        component: () => import(/* webpackChunkName: "eleitor" */ '@/modules/inscricao/views/Conselho.vue'),
      },
      {
        path: '/inscricao/revisao-conselho',
        name: 'InscricaoConselhoRevisao',
        meta: {
          title: 'Revisão - Dados Conselho',
          group: 'apps',
          icon: 'dashboard',
        },
        component: () => import(/* webpackChunkName: "eleitor" */ '@/modules/inscricao/views/RevisaoConselho.vue'),
      },
    ],
  },
];
