<?php
/*
  Arquivo: minhas_solicitaçoes.php
  Atribuído para: codigo 2
  Descrição geral: Este arquivo faz parte do site. Abaixo há comentários detalhados sobre as responsabilidades e o que cada bloco de código faz.
*/

require_once 'config.php';

// só entra se estiver logado como usuário
if (!isset($_SESSION['user_id'])) { 
    header("Location: login.php");
    exit; 
}

$user_id = $_SESSION['user_id'];

// busca as solicitações do usuario
$stmt = $pdo->prepare("
    SELECT pedidos.*, pets.nome AS pet_nome 
    FROM pedidos
    LEFT JOIN pets ON pets.id = pedidos.pet_id
    WHERE pedidos.user_id = :uid
    ORDER BY pedidos.data_solicitacao DESC
");
$stmt->execute(['uid' => $user_id]);
$dados = $stmt->fetchAll();
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Minhas Solicitações</title>
<link rel="stylesheet" href="style.css">
</head>

<body>
<div class="container">
    <div class="card">
        <h2>Minhas Solicitações de Adoção</h2>
        <p class="small">Bem-vindo(a), <?= htmlspecialchars($_SESSION['user_nome']) ?> | 
            <a class="button ghost" href="index.php">Voltar</a>
        </p>

        <table class="table">
            <tr>
                <th>ID</th>
                <th>Pet</th>
                <th>Data</th>
                <th>Status</th>
            </tr>

            <?php foreach ($dados as $d): ?>
            <tr>
                <td><?= $d['id'] ?></td>
                <td><?= htmlspecialchars($d['pet_nome']) ?></td>
                <td><?= htmlspecialchars($d['data_solicitacao']) ?></td>

                <!-- indicador de status -->
                <td>
                    <?php if ($d['status'] == "pendente"): ?>
                        <span style="color: orange; font-weight:bold;">Pendente</span>
                    <?php elseif ($d['status'] == "aprovado"): ?>
                        <span style="color: green; font-weight:bold;">Aprovado ✔</span>
                    <?php else: ?>
                        <span style="color: red; font-weight:bold;">Recusado ✖</span>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>

        </table>
    </div>
</div>
</body>
</html>
