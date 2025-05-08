Projeto Estágio - Sistema de Cadastro de Produtos

Este projeto foi desenvolvido como parte de um teste técnico para estágio em Desenvolvimento Web, no qual tinha que fazer um CRUD em PHP

 Tecnologias Utilizadas
   PHP 8.0: Backend
   MySQL: Banco de dados
   Bootstrap 5.x: Estilização 
   JavaScript: Validação no front-end
   HTML5 & CSS3: Estrutura e design

 Funcionalidades

1. Login de Usuário:
Login com usuário "admin" e senha `1234`ou login com usuario "Geraldo" e senha "abc".
     
   
2. Cadastro de Produtos:
     Cadastro de produtos com campos como código, nome, descrição, valor, quantidade e status.
     Validação de código único (não pode ser duplicado).
    
3. Edição de Produtos:
     Permite editar todos os campos do produto, exceto o código.

4. Exclusão de Produtos:
   Não permite excluir produtos "ativos" ou com quantidade > 0.
   
5. Listagem de Produtos:
     Exibe todos os produtos cadastrados em uma tabela.
     Permite filtros por nome e status.
     Paginação para navegar entre os produtos.

 Como Rodar o Projeto

1. Instale o XAMPP e inicie o Apache e MySQL.
2. No phpMyAdmin, crie um banco de dados chamado `projeto_estagio`.
3. Importe o arquivo `estrutura.sql` para criar as tabelas no banco de dados.
4. Coloque os arquivos do projeto na pasta `C:\xampp\htdocs\projeto_estagio\`.
5. Acesse o projeto no navegador em: `http://localhost/projeto_estagio/`.

Banco de Dados

O banco de dados utilizado é o MySQL. O arquivo `estrutura.sql` contém a criação do banco e das tabelas necessárias.

 Demonstração do Projeto

Veja o vídeo abaixo para ver o sistema em funcionamento:

https://www.youtube.com/watch?v=MJJZ0W8IqeQ

Referências

Base do projeto: Utilizei como base um CRUD feito em Python+Django que fiz recentemente, o projeto foi inspirado no seguinte tutorial
https://www.youtube.com/watch?v=-vrXnewHrwA&list=PLbnAsJ6zlidvszSXnxplfYgtB6KQ-fZ-N
segue o link de um video demonstração do sistema feito em python+django funcionando
https://drive.google.com/file/d/1M0o1uw5RvqGPsFL8fHa9bqcVmjSRQ7ye/view?usp=sharing

Também utilizei esta sequência de vídeos para o desenvolvimento do projeto em PHP
https://www.youtube.com/watch?v=lP-XV2wXXQM&list=PLSHNk_yA5fNjoIRNHV-3FprsN3NWPcnnK

Utilizei também inteligencia artificial para revisar o código, revisar funções e sugerir melhorias

