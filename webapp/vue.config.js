const CKEditorWebpackPlugin = require( '@ckeditor/ckeditor5-dev-webpack-plugin' );

module.exports = {
  devServer: {
    // proxy: {
    //   '/api': {
    //     target: 'https://localhost/api/v1',
    //     ws: false,
    //     changeOrigin: true
    //   },

    // }
  },
  assetsDir: 'static',
  runtimeCompiler: true,
};
