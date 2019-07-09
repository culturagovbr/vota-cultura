# Sistemas de Leis de Incentivo (SLI)

## Sobre


## Tecnologias

Repositório com responsabilidade de disponibilizar uma stack com serviços que permitam trabalhar com o projeto.


## Tecnologias utilizadas

- Docker
- PHP 7.3 (php-fpm)
  - Laravel Framework
  - Eloquent ORM
  - PSR : 2, 3, 4, 7, 11, 14, 15, 17, 18
- Nginx
- Javascript
  - Node
  - VueJS + VueX + Vuetify
- Postgres

## Estrutura de pastas

O projeto foi divido em 3 estruturas de pastas principais:

- [api](./api)
- database
- [webapp](./webapp)

## Serviços Disponíveis

Para reunir todos os módulos acima, foi criada uma stack Docker da aplicação, contendo os serviços abaixo:

- webapp-service - Porta 8080
- api-service - Porta 9000
- webserver-service - Porta 88
- database-service - Porta 5432

## Como inicializar a Stack

O comando abaixo servirá para a criação das imagens utilizadas nos serviços referentes a API(php-fpm),
WebServer(NGINX) e WebApp(NodeJS).

```console
docker-compose up
```

## Funcionalidades 
  
- [x] Manter Usuário
- [x] Manter Perfil
- [x] Manter Responsáveis
- [ ] Manter Cadastro de Proposta 
- [ ] Manter  

## Autenticação
