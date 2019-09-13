import { DefaultLayout } from '@/core/components/layouts';

export default [
  {
    path: '/recurso',
    component: DefaultLayout,
    name: 'Recurso',
    redirect: '/recurso/inscricao',
    meta: {
      title: 'Recurso',
      group: 'apps',
      icon: '',
      public: true,
    },
    children: [
      {
        path: '/recurso/inscricao',
        name: 'recurso-inscricao-route',
        meta: {
          title: 'Inscrição Recurso',
          group: 'apps',
          icon: 'dashboard',
          public: true,
        },
        component: () => import(/* webpackChunkName: "recurso" */ '@/modules/recurso/views/RecursoInscricao.vue'),
      },
    ],
  },
  {
    path: '/recurso/administrador',
    hidden: true,
    redirect: '/recurso/administrador/recurso',
    component: DefaultLayout,
    children: [
      {
        path: 'recurso',
        name: 'lista-recurso-route',
        meta: {
          title: 'Recursos',
          public: false,
        },
        component: () => import(/* webpackChunkName: "lista-recurso" */ '@/modules/recurso/views/administrador/AdministradorListaRecurso.vue'),
      },
    ],
  },
];
