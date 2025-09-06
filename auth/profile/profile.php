<?php
// Inicar sessão para usar os dados do usuário após o Login
session_start();

// Verificar se o usuário efectuou o Login
if (!isset($_SESSION['user_id'])) {
  // Se o Login nao foi feito correctamente redireciona para a página de Login
  header('Location: ../login/login.php');
  exit();
}

// Ficheiro de configuraçao da base de dados
require_once('../config.php');

// Recolher os dados do usuário na base de dados
$user_id = $_SESSION['user_id'];

$sql = 'SELECT username, email, user_type, profile_pic FROM users WHERE id = ?';
$stmt = $pdo->prepare($sql);
$stmt->execute([$user_id]);
$user = $stmt->fetch();

if (!$user) {
  echo "Erro ao procurar as informações do usuário!";
  exit();
}
?>

<!DOCTYPE html>
<html lang="pt-PT">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="description" content="Portfólio de Jéssica Brito, uma desenvolvedora web apaixonada por criar experiências digitais envolventes e intuitivas. Conheça meus projetos e serviços.">
  <meta name="keywords" content="Jéssica Brito, desenvolvedora web, web developer, frontend, back-end, UX/UI, portfólio, projetos web, serviços de desenvolvimento web">
  <meta name="author" content="Jéssica Brito">

  <!-- Bootstrap File -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

  <!-- CSS File -->
  <link rel="stylesheet" href="../../css/profile.css">

  <!-- Favicon -->
  <link rel="icon" type="image/png" href="../../img/favicon-32x32.png" sizes="32x32">

  <!-- Font Awesome -->
  <script src="https://kit.fontawesome.com/a0444fec76.js" crossorigin="anonymous"></script>

  <!-- Type Script -->
  <script src="https://cdn.jsdelivr.net/npm/typed.js@2.0.12"></script>

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100..900&family=Syne+Mono&display=swap" rel="stylesheet">

  <!-- Title -->
  <title>Login | Jéssica Brito | Web Developer</title>

  <!-- JQuery Script -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</head>

<body>
  <main>
    <section id="profile-section">
      <div class="container">
        <div class="row">
          <div class="profile-title">
            <h1>
              <span class="typed-text-register"></span>
              <span class="cursor-profile"></span>
            </h1>
          </div>

          <div class="form-container col-md-8 col-lg-6 mx-auto">
            <div class="profile-info mb-3">

              <!-- Foto de Perfil -->
              <img src="../<?php echo htmlspecialchars($user['profile_pic']); ?>" alt="Foto de Perfil">

              <!-- Dados do utilizador -->
              <h2><?php echo htmlspecialchars($user['username']); ?></h2>
              <p><strong>E-mail:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
              <p><strong>Tipo de utilizador:</strong> <?php echo htmlspecialchars($user['user_type']); ?></p>
            </div>

            <!-- Button Logout -->
            <a href="../logout.php" class="neon-btn mt-4 d-inline-block">Logout</a>

          </div>
        </div>
      </div>
    </section>
  </main>

  <!-- TypeScript -->
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      // Typed.js
      const typed = new Typed(".typed-text-register", {
        strings: ["Meu Perfil"],
        typeSpeed: 80,
        backSpeed: 50,
        loop: true,
        backDelay: 2000,
        startDelay: 500,
      });
    });
  </script>
</body>

</html>