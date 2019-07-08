import axios from 'axios';
import { eventHub } from '@/event';

const instance = axios.create({
  baseURL: process.env.VUE_APP_API_HOST,
});

const tratarErro = (erro) => {
  let msgErro = 'Desculpe, houve um erro ao executar a operação';

  if (typeof erro === 'object') {
    const erroObjeto = JSON.parse(JSON.stringify(erro));
    msgErro = erroObjeto.message;
  }

  eventHub.$emit('eventoErro', msgErro);
};

const self = this;
instance.interceptors.request.use((config) => {
  const user = JSON.parse(localStorage.getItem('user'));
  const conf = config;

  if (user) {
    conf.headers.Authorization = `Bearer ${user.token}`;
  }

  return conf;
}, (error) => {
  tratarErro(error);
  return Promise.reject(error);
});

instance.interceptors.response.use(response =>
  // Do something with response data
  response,
(error) => {
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
