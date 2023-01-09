## Drugovich Laravel RESTful API

### Cenário 
Em nossa auto peças surgiu a demanda que nossos gerentes pudessem separar nossos clientes em grupos distintos. Nossos gerentes têm dois níveis.
### Requisitos
-   Um cliente deve pertencer a apenas um grupo;
-   Gerentes precisam estar autenticados;
-   Gerentes de nível um pode apenas visualizar grupos, adicionar/remover clientes;
-   Gerentes de nível dois são os únicos que podem criar, editar e excluir grupos
### Modelos
-   Clientes: Código Único, CNPJ, Nome, Data Fundação;
-   Gerentes: Código Único, Nome, E-mail, Nível;
-   Grupos: Código Único, Nome;
-   Clientes e Gerentes podem ser populados automaticamente.
### Objetivo
Queremos endpoints para operar os grupos e visualizar os clientes de um grupo.

----------------------------------------------------------------------------------------------------------
### Instruções para executar o projeto

-   clonar este repositório

    
-   Entrar na pasta do projeto, e copiar o conteúdo de .env.example para .env  `cp .env.example .env`

-   `docker-compose up -d`
    Para criar os containers dev_php, dev_nginx, dev_postgres.

-   Entre no container dev_php
    `docker exec -it dev_php bash`

-   Dentro do container dev_php, rode os seguintes comandos:
    -   `composer install` Para instalar as dependências do projeto

    -   `php artisan key:generate` Para gerar a APP_KEY

    -   `php artisan migrate` ou `php artisan migrate:fresh` Para rodar as migrations de criação das tabelas do banco de dados

    -   `php artisan db:seed` Para rodar as seeders, e popular as tabelas Grupos, Clientes, Perfis, Permissões e Usuários.

#### Pré requisitos:
-   Docker


### Considerações do projeto

-   Um cliente deve pertencer a apenas um grupo, porém não ficou explícito qual seria a mínima da relação, ou seja, se um cliente poderia não pertencer a grupo nenhum (mínimo 0, máximo 1). 
    Considerei que um cliente pode não estar vinculado a nenhum grupo, pensando nos endpoints de adicionar e remover cliente a um grupo. 

-   Apesar de o teste falar em modelo Gerente, com atributo nível, eu tratei o gerente como um usuário que possui certo perfil (papel). Portanto a API possui os modelos: Usuário, Perfil, Permissão, PerfilPermissão, Cliente e Grupo.

-   Os usuários possuem perfil (papel). Neste caso, já deixei previamente cadastrado via seeder os perfis 'Gerente nível 1' e 'Gerente nível 2'. 

-   Cada perfil possui suas permissões. Também já cadastrei via seeder as permissões para os perfis. Sendo que o Gerente nível 2 tem acesso a todos os endpoints, e o Gerente nível 1 não tem acesso aos endpoints 'cadastrar novo grupo', 'alterar grupo' e 'deletar grupo'.

-  No UsersSeeder será criado um usuário para o perfil 'Gerente nível 1' e outro para o perfil 'Gerente nível 2'. Você pode utilizar estes usuários para autenticar e operar os endpoints, mas, caso queira, também pode criar novo usuário no endpoint 'auth/register'

- Também serão cadastrados os grupos "Cliente VIP" e "Cliente Comum", e dois clientes via seeder. Os clientes serão cadastrados sem grupo. 

- Para autenticar com um usuário, acesse o endpoint 'auth/login', enviando o email e o password do usuário. O endpoint retornará um access_token com a autenticação e permissões do usuário. 
Este access_token deverá ser enviado em todas as chamadas (inclusive no logout), no formato 'Bearer Token'. 
O access_token tem duração de 1 dia, e pode ser revogado fazendo logout no endpoint 'logout'.

- Você pode usar a coleção drugovich-collection.json no insomnia para testar. 


### Endpoints
### Auth

-   POST /api/auth/register -> criar novo usuário
    -   enviar os campos name, email, password, password_confirmation, role_id

-   POST /api/auth/login -> autenticar usuário 
    -   enviar os campos email e senha

-   DELETE /api/logout -> deslogar usuário

### Groups
-   GET /api/groups -> lista todos os grupos 
    - query params: page e per_page

-   GET /api/groups/{id} -> lista um grupo 

-   GET /api/groups/search/{name} -> pesquisa pelo nome 

-   POST /api/groups -> cadastra novo grupo (só gerente nível 2)
    - enviar o campo name.

-   PUT /api/groups/{id} -> atualiza um grupo (só gerente nível 2)
    - enviar o campo name.

-   DELETE /api/groups/{id} -> deleta um grupo (só gerente nível 2)

-   GET /api/groups/{groupId}/clients -> lista clientes de um grupo

-   POST /api/groups/{groupId}/clients/{clientId} -> adiciona cliente a um grupo 

-   DELETE /api/groups/{groupId}/clients/{clientId} -> remove cliente de um grupo

### Clients
-   GET /api/clients -> lista todos os clientes 
    - query params: page e per_page

-   GET /api/clients/{id} -> lista um cliente 

-   GET /api/clients/search/{name} -> pesquisa pelo nome 

-   POST /api/clients -> cadastra novo cliente 
    -   enviar os campos name (string), cnpj (string de 14 caracteres), foundation (date), group_id (inteiro, opcional)

-   PUT /api/clients/{id} -> atualiza um cliente 
    - enviar os campos que deseja atualizar.

-   DELETE /api/clients/{id} -> deleta um cliente