<template>
  <div id="app">
    <file-pond
      ref="pond"
      v-bind="$attrs"
      :max-file-size="maxFileSize"
      :accepted-file-types="acceptedFileTypes"
      :files="files"
      :label-idle="labelIdle"
      :allowDownloadByUrl="true"
      label-file-waiting-for-size="Calculando tamanho"
      label-invalid-field="Arquivo(s) invalido(s)"
      label-file-size-not-available="Tamanho não disponível"
      label-file-loading="Carregando"
      label-file-load-error="Erro ao carregar"
      label-file-processing="Enviando"
      label-file-processing-complete="Enviado"
      label-file-processing-aborted="Envio cancelado"
      @addfile="setFileMetaData"
      label-file-processing-error="Erro durante o envio"
      label-file-processing-revert-error="Erro ao reverter"
      label-file-remove-error="Erro ao remover"
      label-tap-to-cancel="Clique para cancelar"
      label-tap-to-retry="Clique para tentar novamente"
      label-tap-to-undo="Clique para desfazer"
      label-button-remove-item="Remover"
      label-button-abort-item="Abortar"
      label-button-retry-item-load="Cancelar"
      label-button-undo-item-processing="Desfazer"
      label-button-retry-item-processing="Tentar novamente"
      label-button-process-item="Enviar"
      label-file-type-not-allowed="Tipo de arquivo inválido"
      file-validate-type-label-expected-types="Esperando {allButLastType} ou {lastType}"
      label-max-file-size-exceeded="Arquivo muito grande"
      label-max-file-size="Tamanho máximo é {filesize}"
      label-max-total-file-size-exceeded="Tamanho máximo excedido"
      label-max-total-file-size="Tamanho máximo de arquivos é {filesize}"
      @removefile="self = {}; error=false"
      @error="setError"
    />
  </div>
</template>

<script>
import vueFilePond, { setOptions } from 'vue-filepond';

import 'filepond/dist/filepond.min.css';

import 'filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css';

import FilePondPluginFileValidateType from 'filepond-plugin-file-validate-type';
import FilePondPluginImagePreview from 'filepond-plugin-image-preview';
import FilePondPluginFileEncode from 'filepond-plugin-file-encode';
import FilePondPluginFileValidateSize from 'filepond-plugin-file-validate-size';

const FilePond = vueFilePond(
  FilePondPluginFileValidateType,
  FilePondPluginImagePreview,
  FilePondPluginFileEncode,
  FilePondPluginFileValidateSize,
);


export default {
  name: 'File',
  components: {
    FilePond,
  },
  props: {
    value: {},
    acceptedFileTypes: {
      type: Array,
      default: () => [
        'application/pdf',
        'image/jpeg',
        'application/zip',
        'application/x-rar-compressed',
        'application/vnd.rar',
      ],
    },
    labelIdle: {
      type: String,
      default: 'Clique aqui para anexar',
    },
    maxFileSize: {
      type: String,
      default: '80MB',
    },
    fileValidateTypeLabelExpectedTypesMap: {
      type: Object,
      default: () => ({
        'application/pdf': '.pdf',
        'image/jpeg': '.jpeg',
        'application/zip': '.zip',
        'application/x-rar-compressed': '.rar',
        'application/vnd.rar': '.rar',
      }),
    },
    options: {
      type: Object,
      default: () => {},
    },
    // server: {
    //   type: Object,
    //   default: () => {},
    // },
    files: {
      type: Array,
      // default: () => [],
      default: () => [
        // {
        //   source: 'https://www.google.com/logos/doodles/2018/baba-amtes-104th-birthday-6729609885253632-s.png',
        //   options: {
        //     type: 'remote',
        //   },
        // },

        // {
        //   source: 'blob:http://localhost:8080/cc34373e-db63-488f-8c48-97d921d81054',
        //   options: {
        //     type: 'remote',
        //   },
        // },
      ],
    },
  },
  data() {
    return {
      self: {},
      error: false,
    };
  },
  watch: {
    fileValidateTypeLabelExpectedTypesMap(defaultMap) {
      this.$refs.pond._pond.fileValidateTypeLabelExpectedTypesMap = defaultMap;
    },
    value(val) {
      this.self = val;
    },
    self(val) {
      this.$emit('input', val);
    },
    files(val) {
      console.log(val)
    },
  },
  mounted() {
    setOptions(this.options);
  },
  methods: {
    setFileMetaData() {
      try {
        this.self = this.$refs.pond.getFile();
        if (!!this.$refs.pond.allowMultiple) {
          this.self = this.$refs.pond.getFiles();
        }
      } catch (Exception) {
        this.self = {};
      }
    },
    reset() {
      this.$refs.pond.removeFiles();
      this.self = {};
    },
    setError() {
      this.error = true;
    },
    fileHasError() {
      return this.error;
    },
  },
};
</script>