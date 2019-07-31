import { DefaultLayout } from '@/core/components/layouts';
import RoutersConta from '@/modules/conta/router';
import RoutersOrganizacao from '@/modules/organizacao/router';
import RoutersConselho from '@/modules/conselho/router';
import RoutersEleitor from '@/modules/eleitor/router';

export default [
  {
    path: '/',
    component: DefaultLayout,
    meta: {
      title: 'Início',
      group: 'apps',
      icon: ''
    },
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
  ...RoutersConta,
  ...RoutersOrganizacao,
  ...RoutersConselho,
  ...RoutersEleitor,
];
