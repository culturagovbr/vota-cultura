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


export default {
  isCpfValido,
};
