import * as jsonwebtoken from 'jsonwebtoken';

export function obterInformacoesJWT(token) {
  try {
    if (process.env.VUE_APP_JWT_SECRET === null) {
      const error = 'Variável de ambiente `VUE_APP_JWT_SECRET` não definida no arquivo `.env`.';
      throw error;
    }

    let finalToken = token;
    if (finalToken == null) {
      finalToken = localStorage.getItem('token_usuario');
    }
    return finalToken != null ? jsonwebtoken.verify(finalToken, process.env.VUE_APP_JWT_SECRET) : '';
  } catch (Exception) {
    // console.log(Exception);
    // return {};
    // throw Exception;
    const error = 'Acesso expirado!';
    localStorage.removeItem('token_usuario');
    throw error;
  }
}

export function obterCabecalhoComToken(token) {
  let finalToken = token;
  if (finalToken == null) {
    finalToken = localStorage.getItem('token_usuario');
  }
  if (finalToken) {
    return {
      headers: {
        Authorization: `Bearer ${finalToken}`,
      },
    };
  }
  return {};
}

export function tokenValida(token) {
  return Object.keys(obterInformacoesJWT(token)).length > 0;
}
