import axios from 'axios';
import { obterInformacoesJWT } from '../helpers/jwt';
import { eventHub } from '@/event';

const instance = axios.create({
  baseURL: process.env.VUE_APP_API_HOST,
});

const tratarErro = (error) => {
  const msgErro = 'Desculpe, houve um erro ao executar a operação';

  if (error.response) {
    return Promise.reject(error);
  }
  if (error.request) {
    console.log(error.request);
  } else {
    console.log('errro3');
    // Something happened in setting up the request that triggered an Error
    console.log('Error', error.message);
  }
  console.log(error.config);

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

export const buildData = function (obj, form, namespace) {
  const fd = form || new FormData();
  let formKey;

  for (const property in obj) {
    if (obj.hasOwnProperty(property)) {
      if (namespace) {
        formKey = `${namespace}[${property}]`;
      } else {
        formKey = property;
      }

      // if the property is an object, but not a File,
      // use recursivity.
      if (typeof obj[property] === 'object' && !(obj[property] instanceof File)) {
        buildData(obj[property], fd, property);
      } else {
        // if it's a string or a File object
        fd.append(formKey, obj[property]);
      }
    }
  }

  return fd;
};

export const getRequest = (path, config = {}) => instance.get(path, config);

export const postRequest = (path, payload) => instance.post(path, payload);

export const putRequest = (path, id, payload) => instance.put(`${path}/${id}`, payload);

export const patchRequest = (path, id, payload) => instance.patch(`${path}/${id}`, payload);

export const deleteRequest = (path, id) => instance.delete(`${path}/${id}`);

export const obterBinarioArquivo = (coArquivo, config = { responseType: 'blob' }) => instance.get(`/upload/${coArquivo}`, config);

export const replaceAll = function (searchString, replaceString, str) {
  return str.split(searchString).join(replaceString);
};
