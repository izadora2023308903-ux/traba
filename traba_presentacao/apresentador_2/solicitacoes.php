<?php
/*
  Arquivo: solicitacoes.php
  Atribuído para: Apresentador 2
  Descrição geral: Página do painel administrativo onde o administrador visualiza
  todas as solicitações de adoção registradas no sistema. Permite aprovar ou recusar pedidos.
*/

require_once 'config.php'; // Importa conexão e sessão

// Verifica se o admin está logado
if (!isset($_SESSION['admin_id'])) { 
    header('Location: login.php'); // Redireciona se não estiver autenticado
    exit;
}

// Consulta todas as solicitações, incluindo o nome do pet via LEFT JOIN
$stmt = $pdo->query("
    SELECT pedidos.*, pets.nome AS pet_nome 
    FROM pedidos 
    LEFT JOIN pets ON pets.id = pedidos.pet_id 
    ORDER BY pedidos.criado_em DESC
");

// Converte resultado para array
$dados = $stmt->fetchAll();
?>
<?php require_once 'config.php'; ?> <!-- (Desnecessário, mas presente no original) -->

<!doctype html>
<html>
<head>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width,initial-scale=1'>
    <title>Solicitações</title>

    <!-- Arquivo de estilo -->
    <link rel='stylesheet' href='style.css'>
</head>

<body>
<div class="container">
<div class="card">

    <!-- Título -->
    <h2>Solicitações de Adoção</h2>

    <!-- Exibe nome do admin logado + botão de voltar -->
    <p class="small">
        Admin: <?= htmlspecialchars($_SESSION['admin_nome']) ?> 
        | 
        <a class="button ghost" href="lista_editar.php">Voltar</a>
    </p>

    <!-- Tabela com todos os pedidos -->
    <table class="table">

        <tr>
            <th>ID</th>
            <th>Pet</th>
            <th>Solicitante</th>
            <th>Contato</th>
            <th>Endereço</th>
            <th>Data</th>
            <th>Status</th>
            <th>Ações</th>
        </tr>

        <!-- Loop para exibir cada solicitação -->
        <?php foreach($dados as $d): ?>
        <tr>

            <!-- ID do pedido -->
            <td><?= $d['id'] ?></td>

            <!-- Nome do pet -->
            <td><?= htmlspecialchars($d['pet_nome']) ?></td>

            <!-- Nome do solicitante ou — -->
            <td><?= htmlspecialchars($d['nome'] ?? '—') ?></td>

            <!-- Telefone -->
            <td><?= htmlspecialchars($d['telefone'] ?? '—') ?></td>

            <!-- Endereço -->
            <td><?= htmlspecialchars($d['endereco'] ?? '—') ?></td>

            <!-- Data de criação -->
            <td><?= htmlspecialchars($d['criado_em']) ?></td>

            <!-- Status (pendente, aprovado, recusado) -->
            <td><?= htmlspecialchars($d['status']) ?></td>

            <!-- Botões de ação (somente se estiver pendente) -->
            <td>
                <?php if($d['status']=='pendente'): ?>

                    <!-- Aprovar -->
                    <a class="button" 
                       href="process_aprovacao.php?action=aprovar&id=<?= $d['id'] ?>">
                       Aprovar
                    </a>

                    <!-- Recusar -->
                    <a class="button ghost" 
                       href="process_aprovacao.php?action=recusar&id=<?= $d['id'] ?>">
                       Recusar
                    </a>

                <?php else: ?>
                    <!-- Se já foi aprovado/recusado -->
                    —
                <?php endif; ?>
            </td>
        </tr>
        <?php endforeach; ?>

    </table>
</div>
</div>
</body>
</html>
