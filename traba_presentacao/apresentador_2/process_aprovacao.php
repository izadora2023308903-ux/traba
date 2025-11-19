<?php
/*
  Arquivo: process_aprovacao.php
  Atribuído para: Apresentador 2
  Descrição geral:
  Este arquivo é responsável por processar a aprovação ou recusa
  de uma solicitação de adoção feita por um usuário. Apenas administradores
  podem acessar esta funcionalidade. Ele recebe parâmetros via GET,
  atualiza o status no banco e redireciona de volta à lista de solicitações.
*/

require_once 'config.php';
// Carrega o arquivo de configuração, que inclui a conexão com o banco de dados
// e geralmente abre a sessão (session_start).

// Verifica se o administrador está logado
if (!isset($_SESSION['admin_id'])) {
    // Se não estiver logado, redireciona para a página de login e interrompe a execução
    header('Location: login.php');
    exit;
}

// Captura a ação enviada pela URL (aprovar ou recusar)
// Caso não exista o parâmetro, a variável recebe uma string vazia
$action = $_GET['action'] ?? '';

// Captura o ID da solicitação e converte para inteiro por segurança
$id = intval($_GET['id'] ?? 0);

// Se o ID não for válido (0 ou ausente), volta para a página de solicitações
if (!$id) {
    header('Location: solicitacoes.php');
    exit;
}

// Se a ação for "aprovar", atualiza o status no banco para "aprovado"
if ($action == 'aprovar') {
    $stmt = $pdo->prepare('UPDATE pedidos SET status = :s WHERE id = :id');
    $stmt->execute([
        's' => 'aprovado',
        'id' => $id
    ]);

// Se a ação for "recusar", atualiza o status no banco para "recusado"
} elseif ($action == 'recusar') {
    $stmt = $pdo->prepare('UPDATE pedidos SET status = :s WHERE id = :id');
    $stmt->execute([
        's' => 'recusado',
        'id' => $id
    ]);
}

// Após atualizar o status, o sistema retorna para a página de solicitações
header('Location: solicitacoes.php');
exit;

?>
