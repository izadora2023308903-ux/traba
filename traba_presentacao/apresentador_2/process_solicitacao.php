<?php
/*
  Arquivo: process_solicitacao.php
  Atribuído para: Apresentador 2
  Descrição geral: Este arquivo processa o envio de uma solicitação de adoção.
  Ele valida os dados, verifica se o pet existe, identifica se o usuário está logado e
  salva o pedido no banco de dados.
*/

require_once 'config.php'; // Importa conexão com o banco e sessão

try {
    // Garante que o envio do formulário seja via POST
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Método inválido.');
    }

    // Captura o ID do usuário logado (se houver)
    $usuario_id = isset($_SESSION['user_id']) ? intval($_SESSION['user_id']) : null;

    // Recebe os dados enviados pelo formulário
    $pet_id = intval($_POST['pet_id'] ?? 0);
    $nome = trim($_POST['nome'] ?? '');
    $endereco = trim($_POST['endereco'] ?? '');
    $telefone = trim($_POST['telefone'] ?? '');

    // Verifica se todos os campos obrigatórios foram preenchidos
    if (!$pet_id || !$nome || !$endereco || !$telefone) {
        throw new Exception('Preencha todos os campos obrigatórios.');
    }

    // Verifica se o pet existe no banco
    $s = $pdo->prepare('SELECT id FROM pets WHERE id = :id');
    $s->execute(['id' => $pet_id]);
    if (!$s->fetch()) {
        throw new Exception('Pet não encontrado.');
    }

    // Verifica se o usuário logado realmente existe no banco
    $usuario_existe = false;
    if ($usuario_id) {
        $c = $pdo->prepare('SELECT id FROM usuarios WHERE id = :id');
        $c->execute(['id' => $usuario_id]);
        $usuario_existe = $c->fetch() ? true : false;
    }

    // Se o usuário estiver logado, salva com usuario_id
    if ($usuario_existe) {
        $stmt = $pdo->prepare('INSERT INTO pedidos (usuario_id, pet_id, status, nome, endereco, telefone, criado_em)
                               VALUES (:u, :p, :s, :n, :e, :t, NOW())');
        $stmt->execute([
            'u' => $usuario_id,
            'p' => $pet_id,
            's' => 'pendente',
            'n' => $nome,
            'e' => $endereco,
            't' => $telefone
        ]);
    } else {
        // Caso contrário, visitante envia sem usuario_id
        $stmt = $pdo->prepare('INSERT INTO pedidos (pet_id, status, nome, endereco, telefone, criado_em)
                               VALUES (:p, :s, :n, :e, :t, NOW())');
        $stmt->execute([
            'p' => $pet_id,
            's' => 'pendente',
            'n' => $nome,
            'e' => $endereco,
            't' => $telefone
        ]);
    }

    // Redireciona após sucesso
    header('Location: index.php?msg=solicitacao_ok');
    exit;

} catch (PDOException $ex) {
    // Registra erro no log e mostra mensagem genérica
    error_log('DB Error in process_solicitacao.php: ' . $ex->getMessage());
    die('Erro ao salvar solicitação (DB).');

} catch (Exception $e) {
    // Mostra mensagens específicas (validação, pet não encontrado, etc.)
    die($e->getMessage());
}
?>
