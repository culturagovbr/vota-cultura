module.exports = {
  root: true,
  env: {
    node: true,
  },
  extends: [
    'plugin:vue/recommended',
    '@vue/airbnb',
  ],
  // check if imports actually resolve
  settings: {
    'import/resolver': {
      webpack: {
        config: 'node_modules/@vue/cli-service/webpack.config.js',
      },
    },
  },
  rules: {
    'import/extensions': ['error', 'always', {
      js: 'never',
      vue: 'never',
    }],
    'import/no-unresolved': [0, { commonjs: true, amd: true }],
    'no-console': process.env.NODE_ENV === 'production' ? 'error' : 'off',
    'no-debugger': process.env.NODE_ENV === 'production' ? 'error' : 'off',
    'no-param-reassign': ['error', {
      props: true,
      ignorePropertyModificationsFor: [
        'state', // for vuex state
        'acc', // for reduce accumulators
        'e', // for e.returnvalue
      ],
    }],
    // indent: ['error', 2],
    // 'vue/html-indent': ['error', 4, {
    //     alignAttributesVertically: true,
    // }],
    'no-shadow': ['error', { allow: ['state'] }],
    'max-len': ['error', { code: 120, ignoreUrls: true }],
  },
  parserOptions: {
    parser: 'babel-eslint',
  },
};
