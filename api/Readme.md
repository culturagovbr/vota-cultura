# API

## Sobre

A API da aplicação disponibiliza rotas que são documentadas e geradas à partir do SWAGGER.

Os end-points disponíveis podem ser acessados à partir da rota abaixo
```http request
{server-api}:{api-port}/api/documentation
```

## Como utilizar

### Criar um novo módulo

 ```console
 php artisan make:module Conta
 ```
 
 ou duplicar o diretório `Foo` que está localizado dentro de `Modules`.
 
### Atualizar documentação gerada pelo Swagger

 ```console
 php artisan l5-swagger:generate
 ```
 
### Atualizar mapeamento de classes

 ```console
 composer dumpautoload
 ```
 
## Referencias

- [Laravel Modules](https://caffeinatedpackages.com/guide/packages/modules.html#installationn)
- [Laravel website](https://laravel.com)
