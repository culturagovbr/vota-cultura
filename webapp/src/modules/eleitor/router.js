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
    name: 'Eleitor',
    redirect: '/eleitor/inscricao',
    children: [
      {
        path: '/eleitor/inscricao',
        name: 'InscricaoEleitor',
        meta: {
          title: 'Inscrição Eleitor',
          group: 'apps',
          icon: 'dashboard',
        },
        component: () => import(/* webpackChunkName: "eleitor" */ '@/modules/eleitor/views/Eleitor.vue'),
      },
      {
        path: '/eleitor/revisao-eleitor',
        name: 'InscricaoEleitorRevisao',
        meta: {
          title: 'Revisão - Dados Eleitor',
          group: 'apps',
          icon: 'dashboard',
        },
        component: () => import(/* webpackChunkName: "eleitor" */ '@/modules/eleitor/views/RevisaoEleitor.vue'),
      },
    ],
  },
];
