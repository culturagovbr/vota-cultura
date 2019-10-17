import * as service from '../service/shared';

export const downloadArquivo = async ({ commit }, coArquivo) => service.obterBinarioArquivo(coArquivo).then((response) => {
  const { headers } = response;
  const dadosFilename = headers['content-disposition'].split('filename=');
  const filename = dadosFilename[1].split('"').join('');
  const url = window.URL.createObjectURL(new Blob([response.data]));
  const link = document.createElement('a');
  link.href = url;
  link.setAttribute('download', filename);
  document.body.appendChild(link);
  link.click();
});

export const obterBinarioArquivo = async ({ commit }, coArquivo) => service.obterBinarioArquivo(coArquivo);
