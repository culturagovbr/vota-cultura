## Problema de compatibilidade com o Vue

Ao tentar executar uma versão antiga do Vue Cli utilizando o node mais recente podem ocorrer problemas na instalação, siga as etapas abaixo para solucionar.

Remover o pacote global do vue cli

```
npm uninstall -g @vue/cli
```

Se o sistema continuar com a referência antiga, faça o procedimento abaixo:

Encontrando a referência atual

```
$ which vue
```

Será listado o diretório da referência: Exemplo: 

```
/usr/local/bin/vue
```

Basta remover
```
sudo rm /usr/local/binvue
```

E instalar novamente

```
sudo npm install -g @vue/cli
```