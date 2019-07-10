import { DefaultLayout } from '@/core/components/layouts';
import RoutersConta from '@/modules/conta/router';

export default [
  ...RoutersConta,
  {
    path: '/',
    component: DefaultLayout,
    meta: { title: 'Home', group: 'apps', icon: '' },
    redirect: '/dashboard',
    children: [
      {
        path: '/dashboard',
        name: 'Dashboard',
        meta: {
          title: 'Home', group: 'apps', icon: 'dashboard',
        },
        component: () => import(/* webpackChunkName: "dashboard" */ '@/core/views/Dashboard.vue'),
      },
    ],
  },

  // list
  {
    path: '/cms',
    component: DefaultLayout,
    redirect: '/cms/table',
    meta: { title: 'CMS', icon: 'view_compact', group: 'cms' },
    children: [
      {
        path: '/cms/table',
        name: 'ListTable',
        meta: { title: 'CMS Table' },
        component: () => import(/* webpackChunkName: "table" */ '@/core/views/list/Table.vue'),
      },
    ],
  },

];
