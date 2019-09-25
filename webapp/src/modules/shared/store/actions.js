import * as service from '../service/shared';

export const downloadArquivo = async ({ commit }, coArquivo) => {
  return service.downloadArquivo(coArquivo);
};
