# Projeto PAW — API REST com Banco de Dados

Projeto acadêmico desenvolvido para o segundo bimestre da disciplina de PAW, com foco na construção de uma API REST integrada a um banco de dados relacional. A proposta aplica conceitos de organização de software, persistência de dados e implementação de regras de negócio.

## Funcionalidades

- **CRUD completo:** criação, consulta, atualização e exclusão de registros das entidades principais.
- **Relacionamento entre entidades:** banco de dados estruturado com pelo menos cinco tabelas relacionadas.
- **Validação de dados:** regras de negócio para impedir registros inválidos e duplicidades.
- **Comunicação em JSON:** endpoints que recebem e retornam informações de forma padronizada.
- **Operações HTTP:** utilização de `GET`, `POST`, `PUT/PATCH` e `DELETE` conforme a finalidade de cada endpoint.

## Organização do projeto

A aplicação utiliza o padrão MVC para organizar as responsabilidades do sistema e o padrão DAO para concentrar as operações de acesso ao banco de dados. Essa estrutura facilita a manutenção do código e a separação entre as regras de negócio e a persistência das informações.

## Testes da API

Os endpoints podem ser testados pelo Insomnia, permitindo executar requisições, conferir as respostas e verificar a integração com o banco de dados.

## Objetivo

Praticar o desenvolvimento de APIs REST, a modelagem de bancos de dados relacionais e a organização do código com MVC e DAO, construindo uma aplicação com operações de gerenciamento e validação de dados.
