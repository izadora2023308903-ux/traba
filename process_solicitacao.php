<?php
require_once 'config.php';

/*
 ------------------------------------------------------
  INÍCIO DA SESSÃO (evita erro caso ainda não exista)
 ------------------------------------------------------
*/
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

try {

    /*
     ------------------------------------------------------
      SOMENTE PERMITE MÉTODO POST
     ------------------------------------------------------
    */
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Método inválido.');
    }

    /*
     ------------------------------------------------------
      CAPTURA DOS DADOS DO FORMULÁRIO
     ------------------------------------------------------
    */
    $usuario_id = $_SESSION['user_id'] ?? null;

    $pet_id   = intval($_POST['pet_id'] ?? 0);
    $nome     = trim($_POST['nome'] ?? '');
    $endereco = trim($_POST['endereco'] ?? '');
    $telefone = trim($_POST['telefone'] ?? '');

    /*
     ------------------------------------------------------
      VALIDAÇÃO DE CAMPOS OBRIGATÓRIOS
     ------------------------------------------------------
    */
    if (!$pet_id || !$nome || !$endereco || !$telefone) {
        throw new Exception('Preencha todos os campos obrigatórios.');
    }

    /*
     ------------------------------------------------------
      VERIFICA SE O PET EXISTE
     ------------------------------------------------------
    */
    $s = $pdo->prepare("SELECT id FROM pets WHERE id = :id");
    $s->execute(['id' => $pet_id]);
    if (!$s->fetch()) {
        throw new Exception("Pet não encontrado.");
    }

    /*
     ------------------------------------------------------
      VERIFICA SE O USUÁRIO ESTÁ LOGADO
     ------------------------------------------------------
    */
    $usuario_existe = false;

    if ($usuario_id) {
        $c = $pdo->prepare("SELECT id FROM usuarios WHERE id = :id");
        $c->execute(['id' => $usuario_id]);
        $usuario_existe = $c->fetch() ? true : false;
    }

    /*
     ------------------------------------------------------
      INSERÇÃO DO PEDIDO DE ADOÇÃO
     ------------------------------------------------------
      Corrigido:
      - 'data_solicitacao' → 'criado_em'
      - status → 'Pendente'
    */
    if ($usuario_existe) {

        // Usuário logado
        $stmt = $pdo->prepare("
            INSERT INTO pedidos (usuario_id, pet_id, status, nome, endereco, telefone, criado_em)
            VALUES (:u, :p, 'Pendente', :n, :e, :t, NOW())
        ");

        $stmt->execute([
            'u' => $usuario_id,
            'p' => $pet_id,
            'n' => $nome,
            'e' => $endereco,
            't' => $telefone
        ]);

    } else {

        // Visitante — sem usuário vinculado
        $stmt = $pdo->prepare("
            INSERT INTO pedidos (pet_id, status, nome, endereco, telefone, criado_em)
            VALUES (:p, 'Pendente', :n, :e, :t, NOW())
        ");

        $stmt->execute([
            'p' => $pet_id,
            'n' => $nome,
            'e' => $endereco,
            't' => $telefone
        ]);
    }

    /*
     ------------------------------------------------------
      REDIRECIONA APÓS SUCESSO
     ------------------------------------------------------
    */
    header("Location: index.php?msg=solicitacao_ok");
    exit;

} catch (Exception $e) {
    die($e->getMessage());
}
