import { DefaultLayout } from '@/core/components/layouts';

export default [
  {
    path: '/organizacao',
    name: 'Organizacao',
    component: DefaultLayout,
    meta: {
      title: 'Organizacao',
      group: 'apps',
      icon: '',
      public: true,
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
          public: true,
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
          public: true,
        },
        component: () => import(/* webpackChunkName: "eleitor" */ '@/modules/organizacao/views/RevisaoOrganizacao.vue'),
      },
      {
        path: '/organizacao/detalhes-inscricao',
        name: 'OrganizacaoDetalhesInscricaoRoute',
        meta: {
          title: 'Detalhes da inscrição',
          group: 'apps',
          icon: 'dashboard',
          public: false,
        },
        component: () => import(/* webpackChunkName: "eleitor" */ '@/modules/organizacao/views/OrganizacaoDetalhesInscricao.vue'),
      },
      {
        path: '/organizacao/documentacao-comprobatoria',
        name: 'OrganizacaoDocumentacaoComprobatoriaRoute',
        meta: {
          title: 'Enviar documentação',
          group: 'apps',
          icon: 'dashboard',
          public: false,
        },
        component: () => import(/* webpackChunkName: "eleitor" */ '@/modules/organizacao/views/OrganizacaoDocumentacaoComprobatoria.vue'),
      },
    ],
  },
];
