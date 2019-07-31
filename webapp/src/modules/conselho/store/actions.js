import * as conselhoService from '../service/conselho';

// eslint-disable-next-line no-empty-pattern
export const cadastrarConselho = async ({}, conselho) => conselhoService.cadastrarConselho(conselho);
