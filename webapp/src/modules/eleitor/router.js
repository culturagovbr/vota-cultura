import {AuthLayout, DefaultLayout} from '@/core/components/layouts';

export default [
  {
    path: '/eleitor',
    component: DefaultLayout,
    meta: {
      title: 'Eleitor',
      group: 'apps',
      icon: ''
    },
    redirect: '/eleitor',
    children: [
      {
        path: '/eleitor/inscricao',
        name: 'InscricaoEleitor',
        meta: {
          title: 'Inscrição Eleitor',
          group: 'apps',
          icon: 'dashboard',
        },
        component: () => import(/* webpackChunkName: "eleitor" */ '@/modules/inscricao/views/Eleitor.vue'),
      },
      {
        path: '/inscricao/revisao-eleitor',
        name: 'InscricaoEleitorRevisao',
        meta: {
          title: 'Revisão - Dados Eleitor',
          group: 'apps',
          icon: 'dashboard',
        },
        component: () => import(/* webpackChunkName: "eleitor" */ '@/modules/inscricao/views/RevisaoEleitor.vue'),
      },
    ],
  },
];
