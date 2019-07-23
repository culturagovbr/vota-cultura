import { AuthLayout , DefaultLayout } from '@/core/components/layouts';
export default [
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
