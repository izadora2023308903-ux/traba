<?php
require_once 'config.php';

$search = $_GET['q'] ?? '';
$q = "%$search%";

$stmt = $pdo->prepare("SELECT * FROM pets 
    WHERE nome LIKE :q OR raca LIKE :q OR animal LIKE :q 
    ORDER BY id DESC");
$stmt->execute(['q' => $q]);
$dados = $stmt->fetchAll();
?>
<!doctype html>
<html>

<head>
  <meta charset='utf-8'>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>PetShop</title>

  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="styleCards.css">
  <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

</head>

<body>

  <div class="container">

    <div class="header">
      <div class="brand">
        <div class="logo">PS</div>
        <div>
          <h1 class="site-title">PetShop - Adoção Consciente</h1>
          <div class="small">Encontre seu novo melhor amigo</div>
        </div>
      </div>

      <div class="nav">
        <?php if (isset($_SESSION['user_id'])): ?>
          <div class="small">Olá, <?= htmlspecialchars($_SESSION['user_nome']) ?></div>

          <a class="button" href="minhas_solicitacoes.php">Minhas Solicitações</a>

          <a class="button ghost" href="logout.php">Sair</a>

        <?php elseif (isset($_SESSION['admin_id'])): ?>
          <div class="small">Admin: <?= htmlspecialchars($_SESSION['admin_nome']) ?></div>
          <a class="button ghost" href="logout.php">Sair</a>

        <?php else: ?>
          <a class="button ghost" href="login.php">Entrar</a>
          <a class="button" href="cadastro.php">Cadastrar</a>
        <?php endif; ?>
      </div>
    </div>

    <div class="card">

      <form method="GET" class="search-box">
        <input name="q" placeholder="buscar por nome, raça, animal" value="<?= htmlspecialchars($search) ?>">
        <button class="button" type="submit">Buscar</button>
      </form>

      <?php if (isset($_SESSION['admin_id'])): ?>
        <a class="button" href="lista_editar.php">Gerenciar Pets</a>
      <?php endif; ?>

      <div class="pets-grid">

        <?php foreach ($dados as $pet): ?>

          <?php
            // gera a imagem correta usando PHP
            $img = imagemPet($pet['animal'], $pet['raca'], $pet['nome']);
          ?>

          <div class="pet-card">

            <!-- IMAGEM DO PET -->
            <div class="foto">
              <img src="<?= $img ?>" alt="<?= htmlspecialchars($pet['nome']) ?>">
            </div>

            <div class="pet-body">
              <h3><?= htmlspecialchars($pet['nome']) ?></h3>
              <p><?= htmlspecialchars($pet['animal']) ?> — <?= htmlspecialchars($pet['raca']) ?></p>
              <p class="small">
                Idade: <?= htmlspecialchars($pet['idade']) ?> ·
                Castrado: <?= htmlspecialchars($pet['castrado']) ?>
              </p>

              <div class="actions">
                <?php if (isset($_SESSION['user_id'])): ?>
                  <form method="POST" action="solicitar_adocao.php" style="margin:0">
                    <input type="hidden" name="pet_id" value="<?= $pet['id'] ?>">
                    <button class="button" type="submit">Solicitar adoção</button>
                  </form>
                <?php else: ?>
                  <a class="button ghost" href="login.php">Login para adotar</a>
                <?php endif; ?>

                <?php if (isset($_SESSION['admin_id'])): ?>
                  <a class="button ghost" href="editar.php?id=<?= $pet['id'] ?>">Editar</a>
                <?php endif; ?>
              </div>
            </div>

          </div>
        <?php endforeach; ?>

      </div>
    </div>

    <div class="footer card small">
      Desenvolvido por Iza, Lilo e Maria — sistema de adoção
    </div>
  </div>

<?php
function imagemPet($animal, $raca, $nome)
{
    $nome = trim($nome);

    $links = [
        "Nina" => "https://cdn.pixabay.com/photo/2023/03/02/14/46/pit-bull-7825554_1280.jpg",
        "Godzilla" => "https://www.morenopetblog.com.br/wp-content/uploads/2025/07/13b3280fe87efa0f4d2980fcdd59343c-1-1024x1024.jpg",
        "Shakira" => "https://www.shutterstock.com/image-photo/closeup-shot-cachorro-preto-dog-600nw-2158443965.jpg",
        "Dora Alice" => "https://i.pinimg.com/474x/b9/eb/d6/b9ebd6fb44012b3d7f2d1a343479da74.jpg",
        "Mel" => "https://img.freepik.com/fotos-gratis/close-vertical-de-um-gato-cinza-olhando-para-a-camera-com-seus-olhos-verdes_181624-45908.jpg?semt=ais_hybrid&w=740&q=80",
        "Teresa Cristina" => "https://cdn0.umcomo.com.br/pt/posts/0/0/7/como_cuidar_de_um_yorkshire_terrier_12700_600.jpg",
      ];

    if (isset($links[$nome])) {
        return $links[$nome];
    }

    return "uploads/sem_imagem.jpeg";
}

?>

</body>
</html>
