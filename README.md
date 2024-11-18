# Sistema de gerenciamento de processos para restaurantes universitários (PT-BR)
### University restaurants process management system (EN)

<br>

### Em desenvolvimento :building_construction: (PT-BR)

### Under development :building_construction: (EN)

<br>

## Português (PT-BR)

<br>

### Sumário

1. [Introdução](#1---Introdução)
2. [Como testar o projeto localmente com docker](<#2---Testando-localmente-(com-docker)>)

#### 1 - Introdução

Este projeto visa otimizar a qualidade, velocidade e eficiência do serviço em restaurantes universitários. Estes objetivos podem ser alcançados reduzindo o desperdício e o prejuízo com descartes de sobras do buffet, agilizando as atividades da cantina com pedidos antecipados de alimentos e estabelecendo uma comunicação direta entre os funcionários da empresa prestadora de serviços e os alunos, professores e visitantes esporádicos (palestrantes externos, alunos de cursos preparatórios etc) da instituição acadêmica.

#### 2 - Testando localmente (com docker)

1. Clone o repositório em sua máquina.
2. Navegue até o diretório raiz do projeto.
3. Importe a base localizada na pasta "sql" para o seu SGBD (Sistema Gerenciador de Bancos de Dados).
4. Mude o usuário padrão e sua senha e a senha do usuário _root_ no arquivo "docker-compose.yml" conforme necessário.

```
environment:
  MYSQL_USER: manager ---> Usuário padrão
  MYSQL_DATABASE: restaurant ---> Nome do banco
  # For development environments only
  MYSQL_PASSWORD: databasepassword ---> Senha do usuário padrão
  MYSQL_ROOT_PASSWORD: rootdatabasepassword ---> Senha do usuário root
  # -----------------------------------------
```

5. Rode o comando:
   5.1. docker-compose up
6. Acessos:
   1. Projeto:
      1. http://localhost:8080
   2. Banco de dados:
      1. http://localhost:8081

-------------------------------------------------------------------------
<br>

## English (EN)

<br>

### Summary

1. [Introduction](#1---Introduction)
2. [How to test locally with docker](<#2----Testing-locally-(with-docker)>)

### 1 - Introduction

This project intends to optimize university restaurants' service quality, speed, and efficiency. These objectives can be accomplished by reducing waste from buffet food leftovers discarding, speeding up canteen activities with food pre-orders, and establishing a direct communication channel between the enterprise in charge and the students, professors, and sporadic visitors (external speakers, preparatory courses students, etc) of the academic institution.

### 2 - Testing locally (with docker)

1. Clone this repository into your machine.
2. Navigate to the root directory of the project.
3. Import the database under the "sql" directory into your DBMS (Database Management System).
4. Change the standard user and its password and the root password in the "docker-compose.yml" file if necessary.

```
environment:
  MYSQL_USER: manager ---> Standard user
  MYSQL_DATABASE: restaurant ---> Database name
  # For development environments only
  MYSQL_PASSWORD: databasepassword ---> Standard user password
  MYSQL_ROOT_PASSWORD: rootdatabasepassword ---> Root user password
  # -----------------------------------------
```

5. Run the command:
   1. docker-compose up
6. Access:
   1. Project:
      1. http://localhost:8080
   2. Database:
      1. http://localhost:8081
