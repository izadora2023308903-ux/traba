Sistema de Veterinária e Petshop Amigos de Quatro Patas – Programação III
Alunos: Izadora Bernardes Fogliato, Murilo Posser e Maria Guidetti — Turma 30

Descrição
Este projeto é um sistema de veterinária e petshop desenvolvido como trabalho para a disciplina de Programação III. O sistema foi implementado utilizando PHP, HTML, CSS e MySQL, com estrutura simples e recarregamento completo das páginas (sem uso de AJAX ou JavaScript dinâmico até o momento).

O objetivo é gerenciar informações de clientes e pets, com foco em usabilidade, clareza e organização do banco de dados.

Funcionalidades
Autenticação de Usuário
Tela de login e logout
Validação de credenciais diretamente no banco de dados
Cadastros (CRUD)
Módulos de cadastro para duas entidades principais (clientes e produtos/pets)
Funções de criar, editar, excluir e listar registros
Consultas
Listagem com filtro por campo
Relatórios simples com dados filtrados
Exibição de informações resumidas, como total de registros e listagens por data
Interface e Usabilidade
Layout organizado, responsivo e agradável
Navegação clara entre as páginas
Design simples e funcional, com uso básico de CSS
Estrutura do Projeto
Principais arquivos e diretórios:

index.php          -> Página inicial / login
login.php          -> Tela de autenticação
logout.php         -> Encerramento de sessão
Inserir.php        -> Cadastro de novos registros
editar.php         -> Edição de dados existentes
deletar.php        -> Exclusão de registros
formulario.php     -> Formulário de entrada de dados
lista_editar.php   -> Listagem com opção de edição
config.php         -> Configuração de conexão com o banco
petshop.sql        -> Script de criação e povoamento do banco de dados
style.css          -> Folha de estilos do sistema
Banco de Dados
Utiliza o MySQL como sistema gerenciador.
O script petshop.sql contém a criação das tabelas e dados iniciais.
Importação
Abra o phpMyAdmin (ou outro gerenciador MySQL).
Crie um banco de dados chamado petshop.
Importe o arquivo petshop.sql localizado na raiz do projeto.
Tecnologias Utilizadas
PHP
HTML / CSS
MySQL
Visual Studio Code (ambiente de desenvolvimento)
phpMyAdmin (administração do banco de dados)
GitHub (versionamento e armazenamento do código)
Versionamento
O código-fonte foi versionado e publicado em repositório no GitHub, contendo:

Todo o código-fonte completo
Script SQL de criação das tabelas e dados iniciais
Arquivo README.md com descrição, tecnologias e instruções de execução
▶️ Como Executar o Projeto
Copie a pasta do projeto para o diretório htdocs do XAMPP.

Inicie os serviços Apache e MySQL.

Acesse no navegador:

http://localhost/trabalhoprogramaçao
