import * as pessoaService from '../service/pessoa';

export const consultarCPF = async ({ commit }, cpf) => {
  return pessoaService.consultarCPF(cpf);
};

export const consultarCNPJ = async ({ commit }, cnpj) => {
  return pessoaService.consultarCPF(cnpj);
};
