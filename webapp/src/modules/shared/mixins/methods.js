import Validate from '../util/validate';

export default {
  methods: {
    isCpfValido(strCPF) {
      Validate.isCpfValido(strCPF);
    },
  },
};
