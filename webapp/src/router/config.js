import { DefaultLayout } from '@/core/components/layouts';
import RoutersConta from '@/modules/conta/router';
import RoutersInscricao from '@/modules/inscricao/router';

export default [
  ...RoutersConta,
  {
    path: '/',
    component: DefaultLayout,
    meta: { title: 'Início', group: 'apps', icon: '' },
    redirect: '/inicio',
    children: [
      {
        path: '/inicio',
        name: 'Inicio',
        meta: {
          title: 'Início', group: 'apps', icon: 'dashboard',
        },
        component: () => import(/* webpackChunkName: "inicio" */ '@/core/views/Inicio.vue'),
      },
    ],
  },
  ...RoutersInscricao,
  {
    path: '/',
    component: DefaultLayout,
    meta: { title: 'Eleitor', group: 'apps', icon: '' },
    redirect: '/inscricao',
    children: [
      {
        path: '/inscricao/eleitor',
        name: 'Eleitor',
        meta: {
          title: 'Inscrição Eleitor', group: 'apps', icon: 'dashboard',
        },
        component: () => import(/* webpackChunkName: "eleitor" */ '@/modules/inscricao/views/Eleitor.vue'),
      },
      {
        path: '/inscricao/revisao-eleitor',
        name: 'RevisaoEleitor',
        meta: {
          title: 'Inscrição Eleitor', group: 'apps', icon: 'dashboard',
        },
        component: () => import(/* webpackChunkName: "eleitor" */ '@/modules/inscricao/views/RevisaoEleitor.vue'),
      },
    ],
  },
];
