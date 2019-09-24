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
        component: () => import(/* webpackChunkName: "recurso-inscricao-route" */ '@/modules/recurso/views/RecursoInscricao.vue'),
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
        component: () => import(/* webpackChunkName: "recurso-lista-administrador" */ '@/modules/recurso/views/administrador/AdministradorListaRecurso.vue'),
      },
    ],
  },
];
