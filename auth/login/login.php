<?php
// Inicar sessão para usar as mensagens de erro
session_start();
?>
<!DOCTYPE html>
<html lang="pt-PT">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="description" content="Portfólio de Jéssica Brito, uma desenvolvedora web apaixonada por criar experiências digitais envolventes e intuitivas. Conheça meus projetos e serviços.">
  <meta name="keywords" content="Jéssica Brito, desenvolvedora web, web developer, frontend, back-end, UX/UI, portfólio, projetos web, serviços de desenvolvimento web">
  <meta name="author" content="Jéssica Brito">

  <!-- Bootstrap File -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

  <!-- CSS File -->
  <link rel="stylesheet" href="../../css/login.css">

  <!-- Favicon -->
  <link rel="icon" type="image/png" href="img/favicon-32x32.png" sizes="32x32">

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
    <section id="login-section">
      <div class="container">
        <div class="row">
          <div class="login-title">
            <h1>
              <span class="typed-text-register"></span>
              <span class="cursor-login"></span>
            </h1>
          </div>

          <div class="form-container col-md-8 col-lg-6 mx-auto">

            <!-- Exibe aqui uma mensagem de erro em caso de falha no Login -->
            <?php
            if (isset($_SESSION['error'])) {
              echo '<div class="alert alert-danger">' . htmlspecialchars($_SESSION['error']) . '</div>';
              // Limpar a mesagem após a sua exibição
              unset($_SESSION['error']);
            }
            ?>

            <form action="process_login.php" method="post" id="login-form" class="mb-4">
              <div class="mb-3">
                <label for="username" class="form-label">Username:</label>
                <input type="text" name="username" id="username" class="form-control" required autocomplete="username">
              </div>

              <div class="mb-3">
                <label for="password" class="form-label">Password:</label>
                <input type="password" name="password" id="password" class="form-control" required autocomplete="current-password">
              </div>

              <div class="mb-3">
                <p class="register-link">Ainda não tem uma conta? <a href="../register/register.php">Registe-se</a></p>
              </div>

              <input type="submit" class="neon-btn" value="Login">
            </form>
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
        strings: ["Login"],
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