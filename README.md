Sistema de Veterinária e Petshop Amigos de Quatro Patas

Alunos:  Izadora Bernardes Fogliato, Murilo Posser e Maria Guidetti

Descrição:
Este projeto é um sistema de veterinária e petshop desenvolvido como trabalho para a disciplina de Programação III.
 O sistema foi implementado utilizando PHP, HTML, CSS e MySQL, com estrutura simples e recarregamento completo das páginas (sem uso de AJAX ou JavaScript dinâmico até o momento).
O objetivo é gerenciar informações de clientes e pets, com foco em usabilidade, clareza e estruturação correta do banco de dados.

Funcionalidades

Autenticação de Usuário
Tela de login e logout
Validação de credenciais diretamente no banco de dados


Cadastros (CRUD)
Módulos de cadastro para duas entidades principais (ex.: clientes e produtos/pets)
Funções de criar, editar, excluir e listar registros


Consultas
Listagem com filtro por campo
Relatórios simples com dados filtrados
Exibição de informações resumidas, como total de registros e listagens por data


Interface e Usabilidade
Layout organizado, responsivo e agradável
Navegação clara entre as páginas
Design simples e funcional, com uso básico de CSS 

Estrutura do Projeto:
atualizar.php → Responsável por atualizar os dados existentes no banco (edição de registros).
cadastro.php → Página usada para cadastrar novos clientes, pets ou usuários, conforme o módulo.
config.php → Arquivo de configuração da conexão com o banco de dados MySQL (host, usuário, senha e nome do BD).
deletar.php → Executa a exclusão de um registro específico no banco (por ID).
editar.php → Carrega os dados de um registro para edição no formulário.
formulario.php → Formulário base utilizado para inserir ou editar dados no sistema.
index.php → Página inicial do sistema (geralmente redireciona para login ou menu).
inserir.php → Processa o envio do formulário para inserir um novo registro no banco de dados.
lista_editar.php → Lista os registros cadastrados com a opção de editar ou excluir.
login.php → Tela de autenticação, responsável por validar o usuário no banco de dados.
logout.php → Finaliza a sessão e desconecta o usuário do sistema.
minhas_solicitacoes.php → Página onde o cliente visualiza as solicitações que ele enviou (ex.: adoção ou serviços).


petshop.sql → Script SQL contendo as tabelas, estrutura do banco e dados iniciais.
process_aprovacao.php → Arquivo que o administrador usa para aprovar ou rejeitar solicitações enviadas pelos clientes.
process_solicitacao.php → Recebe a solicitação enviada pelo cliente (ex.: adoção) e registra no banco.
setup_admin.php → Script que cria ou configura um administrador inicial no sistema (usuário padrão).
solicitacoes.php → Página onde o administrador visualiza todas as solicitações enviadas pelos clientes.
solicitar_adocao.php → Página onde o cliente pode enviar uma solicitação de adoção de um animal.
style.css → Folha de estilo principal do projeto (layout, cores, fontes, espaçamentos).
styleCards.css → Estilo específico para os cards dos animais exibidos na interface.

Banco de Dados
Utiliza o MySQL como sistema gerenciador.
O script petshop.sql contém a criação das tabelas e dados iniciais.


Tecnologias Utilizadas:
PHP 
HTML / CSS
MySQL
Visual Studio Code (ambiente de desenvolvimento)
phpMyAdmin (administração do banco de dados)
GitHub (versionamento e armazenamento do código)


Versionamento:
O código-fonte foi versionado e publicado em repositório no GitHub, contendo:
Todo o código-fonte completo
Script SQL de criação das tabelas e dados iniciais
Arquivo README.md com descrição, tecnologias e instruções de execução


Como Executar o Projeto:
Copie a pasta do projeto para o diretório htdocs do XAMPP.
Inicie os serviçoas Apache e MySQL.
Acesse no navegador: http://localhost/trab.php
 
