import {AuthLayout, DefaultLayout} from '@/core/components/layouts';

export default [
  {
    path: '/organizacao',
    name: 'Organizacao',
    component: DefaultLayout,
    meta: {
      title: 'Organizacao',
      group: 'apps',
      icon: ''
    },
    redirect: '/organizacao/inscricao',
    children: [
      {
        path: '/organizacao/inscricao',
        name: 'InscricaoOrganizacao',
        meta: {
          title: 'Inscrição Organização',
          group: 'apps',
          icon: 'dashboard',
        },
        component: () => import(/* webpackChunkName: "eleitor" */ '@/modules/organizacao/views/Organizacao.vue'),
      },
      {
        path: '/organizacao/revisao-organizacao',
        name: 'InscricaoOrganizacaoRevisao',
        meta: {
          title: 'Revisão - Dados Organização',
          group: 'apps',
          icon: 'dashboard',
        },
        component: () => import(/* webpackChunkName: "eleitor" */ '@/modules/organizacao/views/RevisaoOrganizacao.vue'),
      },
    ],
  },
];
