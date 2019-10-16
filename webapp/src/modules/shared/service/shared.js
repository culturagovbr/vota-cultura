import * as service from './base/index';
/* eslint-disable import/prefer-default-export */

// `${path}/${id}`
export const downloadArquivo = coArquivo => service.downloadArquivo(coArquivo);
export const obterBinarioArquivo = coArquivo => service.obterBinarioArquivo(coArquivo);
