import axios from 'axios';
import { obterInformacoesJWT } from '../helpers/jwt';
import { eventHub } from '@/event';

const instance = axios.create({
  //baseURL: process.env.VUE_APP_API_HOST,
  baseURL: '/api',
});

const tratarErro = (error) => {
  const msgErro = 'Desculpe, houve um erro ao executar a operação';

  if (error.response) {
    // se for erro de response lança para a próxima camada tratar
    // console.log(error.response.data);
    // console.log(error.response.status);
    // console.log(error.response.headers);
    // console.log(''. error);
    return Promise.reject(error);
  } if (error.request) {
    console.log('errro2');
    // The request was made but no response was received
    // `error.request` is an instance of XMLHttpRequest in the browser and an instance of
    // http.ClientRequest in node.js
    console.log(error.request);
  } else {
    console.log('errro3');
    // Something happened in setting up the request that triggered an Error
    console.log('Error', error.message);
  }
  console.log('error finall');
  console.log(error.config);

  // if (typeof erro === 'object') {
  //   msgErro = erro;
  //   if (Object.keys(JSON.parse(JSON.stringify(erro))) > 0) {
  //     msgErro = JSON.parse(JSON.stringify(erro)).message;
  //   }
  // }
  eventHub.$emit('eventoErro', msgErro);
  return Promise.reject(error);
};

const isEmpty = string => (!string || string.length === 0);

// request
instance.interceptors.request.use((config) => {
  const userToken = localStorage.getItem('token_usuario');
  const conf = config;

  const tokenValida = !isEmpty(obterInformacoesJWT(userToken));

  if (tokenValida) {
    conf.headers.Authorization = `Bearer ${userToken}`;
  }
  return conf;
}, error => Promise.reject(error));
// tratarErro(error);
//   return Promise.reject(error);
// });

// response
instance.interceptors.response.use(response => response, (error) => {
  tratarErro(error);
  return Promise.reject(error);
});

const buildData = (params) => {
  // console.log(Object.keys(params));
  const bodyFormData = new FormData();

  Object.keys(params).forEach((key) => {
    bodyFormData.append(key, params[key]);
  });

  return bodyFormData;
};

export const getRequest = (path, config = {}) => instance.get(path, config);

export const postRequest = (path, payload) => instance.post(path, payload);

export const putRequest = (path, id, payload) => instance.put(`${path}/${id}`, payload);

export const patchRequest = (path, id, payload) => instance.patch(`${path}/${id}`, payload);

export const deleteRequest = (path, id) => instance.delete(`${path}/${id}`);
