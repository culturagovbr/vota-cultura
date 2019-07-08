import Vue from 'vue';
import Router from 'vue-router';
import NProgress from 'nprogress';
import store from '../store/index';
import { publicRoute, protectedRoute } from './config';
import { obterInformacoesJWT } from '@/service/helpers/jwt';
import 'nprogress/nprogress.css';

const routes = publicRoute.concat(protectedRoute);

Vue.use(Router);
const router = new Router({
  mode: 'history',
  linkActiveClass: 'active',
  routes,
});

const isEmpty = string => (!string || string.length === 0);

// router gards
router.beforeEach((to, from, next) => {
  NProgress.start();

  const authRequired = !publicRoute.some(route => route.path === to.matched[0].path); // melhorar isso para rotas filhas

  const userToken = localStorage.getItem('user_token');
  const tokenValida = !isEmpty(obterInformacoesJWT(userToken));

  try {
    if (authRequired && !tokenValida) {
      const error = 'Acesso expirado!';
      localStorage.removeItem('user_token');
      throw error;
    }
    return next();
  } catch (Exception) {
    store.dispatch('app/setMensagemErro', `Erro: ${Exception}`, { root: true });
    return next('/auth/login');
  }
});

router.afterEach(() => {
  NProgress.done();
});

export default router;
