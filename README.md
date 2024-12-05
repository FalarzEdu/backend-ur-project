# Sistema de gerenciamento de processos para restaurantes universitários (PT-BR)

### University restaurants process management system (EN)

<br>

## Português (PT-BR)

## Sumário

1. [Introdução](#1---Introdução)
2. [Dependências](#2---Dependências)
3. [Como testar o projeto localmente com docker](#3---Testando-localmente-com-docker)

### 1 - Introdução

Este projeto visa otimizar a qualidade, velocidade e eficiência do serviço em restaurantes universitários. Estes objetivos podem ser alcançados reduzindo o desperdício e o prejuízo com descartes de sobras do buffet, agilizando as atividades da cantina com pedidos antecipados de alimentos e estabelecendo uma comunicação direta entre os funcionários da empresa prestadora de serviços e os alunos, professores e visitantes esporádicos (palestrantes externos, alunos de cursos preparatórios etc) da instituição acadêmica.

### 2 - Dependências

- Docker
- Docker Compose

### 3 - Testando localmente com docker

#### Clone este repositório

```
$ git@github.com:FalarzEdu/backend-ur-project.git
$ cd backend-ur-project
```

#### Crie o arquivo ".env" e defina as variáveis de ambiente

```
$ cp .env.example .env
```

#### Instale as dependências

```
$ ./run composer install
```

#### Rode os contêineres

```
$ docker compose up -d
```

ou

```
$ ./run up -d
```

#### Crie o banco de dados e a base

```
$ ./run db:reset
```

#### Popule o banco de dados

```
$ ./run db:populate
```

#### Rode os testes

```
$ docker compose run --rm php ./vendor/bin/phpunit tests --color
```

ou

```
$ ./run test
```

#### Rode os Linters

[PHPCS](https://github.com/PHPCSStandards/PHP_CodeSniffer/)

```
$ ./run phpcs
```

[PHPStan](https://phpstan.org/)

```
$ ./run phpstan
```

#### Acesse o projeto no navegador

Acesse [localhost:8080/login](http://localhost:8080/login)

#########################

## English (EN)

### Summary

1. [Introduction](#1---Introduction)
2. [Dependencies](#2---Dependencies)
3. [How to test locally with docker](#3---Testing-locally-with-docker)

### 1 - Introduction

This project intends to optimize university restaurants' service quality, speed, and efficiency. These objectives can be accomplished by reducing waste from buffet food leftovers discarding, speeding up canteen activities with food pre-orders, and establishing a direct communication channel between the enterprise in charge and the students, professors, and sporadic visitors (external speakers, preparatory courses students, etc) of the academic institution.

### 2 - Dependencies

- Docker
- Docker Compose

### 3 - Testing locally with docker

#### Clone Repository

```
$ git clone git@github.com:SI-DABE/problem-track.git
$ cd problem-track
```

#### Define the env variables

```
$ cp .env.example .env
```

#### Install the dependencies

```
$ ./run composer install
```

#### Up the containers

```
$ docker compose up -d
```

or

```
$ ./run up -d
```

#### Create database and tables

```
$ ./run db:reset
```

#### Populate database

```
$ ./run db:populate
```

#### Run the tests

```
$ docker compose run --rm php ./vendor/bin/phpunit tests --color
```

or

```
$ ./run test
```

#### Run the linters

[PHPCS](https://github.com/PHPCSStandards/PHP_CodeSniffer/)

```
$ ./run phpcs
```

[PHPStan](https://phpstan.org/)

```
$ ./run phpstan
```

#### Access the project through a web navigator

Access [localhost:8080/login](http://localhost:8080/login)
