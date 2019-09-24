import { DefaultLayout } from '@/core/components/layouts';

export default [
  {
    path: '/representante',
    component: DefaultLayout,
    meta: {
      title: 'Representante',
      group: 'apps',
      icon: '',
      public: true,
    },
    name: 'Representante',
    children: [
      // {
      //   path: '/representante/inscricao',
      //   name: 'InscricaoRepresentante',
      //   meta: {
      //     title: 'Inscrição Representante',
      //     group: 'apps',
      //     icon: 'dashboard',
      //     public: true,
      //   },
      //   component: () => import(/* webpackChunkName: "representante" */ '@/modules/representante/views/Representante.vue'),
      // },
    ],
  },
];
