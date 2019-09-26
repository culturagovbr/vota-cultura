import * as service from '../service/shared';

export const downloadArquivo = async ({ commit }, coArquivo) => service.downloadArquivo(coArquivo, { responseType: 'blob' });
