export default [
  { path: '*', component: () => import(/* webpackChunkName: "errors-404" */ './views/error/NotFound.vue') },
  {
    path: '/404',
    name: '404',
    meta: { title: 'Não encontrado' },
    component: () => import(/* webpackChunkName: "errors-404" */ './views/error/NotFound.vue'),
  },
  {
    path: '/500',
    name: '500',
    meta: { title: 'Erro no servidor' },
    component: () => import(/* webpackChunkName: "errors-500" */ './views/error/Error.vue'),
  },
  {
    path: '/403',
    name: 'Forbidden',
    meta: { title: 'Acesso negado', hiddenInMenu: true },
    component: () => import(/* webpackChunkName: "error-403" */ './views/error/Deny.vue'),
  },
];
