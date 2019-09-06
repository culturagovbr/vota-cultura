const isCpfValido = (strCPF) => {
  let soma;
  let resto;
  soma = 0;
  if (strCPF === '00000000000') return false;
  for (let i = 1; i <= 9; i += 1) soma += parseInt(strCPF.substring(i - 1, i), 10) * (11 - i);
  resto = (soma * 10) % 11;
  if ((resto === 10) || (resto === 11)) resto = 0;
  if (resto !== parseInt(strCPF.substring(9, 10), 10)) return false;
  soma = 0;
  for (let i = 1; i <= 10; i += 1) soma += parseInt(strCPF.substring(i - 1, i), 10) * (12 - i);
  resto = (soma * 10) % 11;
  if ((resto === 10) || (resto === 11)) resto = 0;
  if (resto !== parseInt(strCPF.substring(10, 11), 10)) return false;
  return true;
};

const isCnpjValido = (strCnpj) => {
  const stripped = strCnpj.replace(/[^\d]+/g, '');

  if (stripped === '') return false;

  if (stripped.length !== 14) return false;

  const BLACKLIST = [
    '00000000000000',
    '11111111111111',
    '22222222222222',
    '33333333333333',
    '44444444444444',
    '55555555555555',
    '66666666666666',
    '77777777777777',
    '88888888888888',
    '99999999999999',
  ];

  if (BLACKLIST.includes(stripped)) return false;

  let tamanho = stripped.length - 2;
  let numeros = stripped.substring(0, tamanho);
  const digitos = stripped.substring(tamanho);

  let soma = 0;
  let pos = tamanho - 7;

  for (let i = tamanho; i >= 1; i -= 1) {
    /* eslint-disable no-plusplus */
    soma += numeros.charAt(tamanho - i) * pos--;
    if (pos < 2) pos = 9;
  }

  /* eslint-disable no-mixed-operators */
  let resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
  if (parseInt(resultado, 10) !== parseInt(digitos.charAt(0), 10)) return false;

  tamanho += 1;

  numeros = stripped.substring(0, tamanho);
  soma = 0;
  pos = tamanho - 7;

  for (let y = tamanho; y >= 1; y -= 1) {
    soma += numeros.charAt(tamanho - y) * pos--;
    if (pos < 2) pos = 9;
  }
  resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;

  return parseInt(resultado, 10) === parseInt(digitos.charAt(1), 10);
};


const isEmailValido = (strEmail) => {
  const regex = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,24}))$/;
  return regex.test(strEmail);
};

const isSenhaValida = (strSenha) => {
  const regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/;
  return regex.test(strSenha);
};


export default {
  isCpfValido,
  isEmailValido,
  isSenhaValida,
  isCnpjValido,
};
