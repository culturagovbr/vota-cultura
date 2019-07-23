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
          title: 'Revisão - Dados Eleitor', group: 'apps', icon: 'dashboard',
        },
        component: () => import(/* webpackChunkName: "eleitor" */ '@/modules/inscricao/views/RevisaoEleitor.vue'),
      },
      {
        path: '/inscricao/conselho',
        name: 'Conselho',
        meta: {
          title: 'Inscrição Conselho', group: 'apps', icon: 'dashboard',
        },
        component: () => import(/* webpackChunkName: "eleitor" */ '@/modules/inscricao/views/Conselho.vue'),
      },
      {
        path: '/inscricao/revisao-conselho',
        name: 'RevisaoConselho',
        meta: {
          title: 'Revisão - Dados Conselho', group: 'apps', icon: 'dashboard',
        },
        component: () => import(/* webpackChunkName: "eleitor" */ '@/modules/inscricao/views/RevisaoConselho.vue'),
      },
      {
        path: '/inscricao/organizacao',
        name: 'Organizacao',
        meta: {
          title: 'Inscrição Organização', group: 'apps', icon: 'dashboard',
        },
        component: () => import(/* webpackChunkName: "eleitor" */ '@/modules/inscricao/views/Organizacao.vue'),
      },
      {
        path: '/inscricao/revisao-organizacao',
        name: 'RevisaoOrganizacao',
        meta: {
          title: 'Revisão - Dados Organização', group: 'apps', icon: 'dashboard',
        },
        component: () => import(/* webpackChunkName: "eleitor" */ '@/modules/inscricao/views/RevisaoOrganizacao.vue'),
      },
    ],
  },
];
