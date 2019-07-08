import axios from 'axios';
import { obterInformacoesJWT } from '../helpers/jwt';
import { eventHub } from '@/event';

const instance = axios.create({
  baseURL: process.env.VUE_APP_API_HOST,
});

const tratarErro = (erro) => {
  let msgErro = 'Desculpe, houve um erro ao executar a operação';

  if (typeof erro === 'object') {
    msgErro = erro;
    if (Object.keys(JSON.parse(JSON.stringify(erro))) > 0) {
      msgErro = JSON.parse(JSON.stringify(erro)).message;
    }
  }
  eventHub.$emit('eventoErro', msgErro);
};

const isEmpty = string => (!string || string.length === 0);

// request
instance.interceptors.request.use((config) => {
  const userToken = localStorage.getItem('user_token');
  const conf = config;

  const tokenValida = !isEmpty(obterInformacoesJWT(userToken));

  if (tokenValida) {
    conf.headers.Authorization = `Bearer ${userToken}`;
  }
  return conf;
}, (error) => {
  tratarErro(error);
  return Promise.reject(error);
});

// response
instance.interceptors.response.use(response => response, (error) => {
  tratarErro(error);
  return Promise.reject(error);
});

const buildData = (params) => {
  const bodyFormData = new FormData();

  Object.keys(params).forEach((key) => {
    bodyFormData.append(key, params[key]);
  });

  return bodyFormData;
};

export const getRequest = (path, params = '') => instance.get(path, params);

export const postRequest = (path, payload) => instance.post(path, buildData(payload));

export const putRequest = (path, payload, id) => instance.put(`${path}/${id}`, buildData(payload));

export const deleteRequest = (path, id) => instance.delete(`${path}/${id}`);
