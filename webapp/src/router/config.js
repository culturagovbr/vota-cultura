import { DefaultLayout } from '@/core/components/layouts';
import RoutersConta from '@/modules/conta/router';

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
        name: 'Dashboard',
        meta: {
          title: 'Início', group: 'apps', icon: 'dashboard',
        },
        component: () => import(/* webpackChunkName: "inicio" */ '@/core/views/Inicio.vue'),
      },
    ],
  },

];
