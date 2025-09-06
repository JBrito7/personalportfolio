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
  <link rel="stylesheet" href="../../css/register.css">

  <!-- Favicon -->
  <link rel="icon" type="image/png" href="../../img/favicon-32x32.png" sizes="32x32">

  <!-- Font Awesome -->
  <script src="https://kit.fontawesome.com/a0444fec76.js" crossorigin="anonymous"></script>

  <!-- Type Script -->
  <script src="https://cdn.jsdelivr.net/npm/typed.js@2.0.12"></script>

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100..900&family=Syne+Mono&display=swap" rel="stylesheet">

  <!-- Title -->
  <title>Registo | Jéssica Brito | Web Developer</title>

  <!-- JQuery Script -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</head>

<body>
  <main>
    <section id="register-section">
      <div class="container">
        <div class="row">
          <div class="register-title">
            <h1>
              <span class="typed-text-register"></span>
              <span class="cursor-register"></span>
            </h1>
          </div>

          <!-- Div que mostra mensagem em caso de erros -->
          <div id="error-message" class="alert alert-danger text-center d-none"></div>

          <div class="form-container col-md-8 col-lg-6 mx-auto">
            <form action="process_register.php" method="post" enctype="multipart/form-data" id="register-form" class="mb-4">
              <div class="mb-3">
                <label for="username" class="form-label">Username:</label>
                <input type="text" name="username" id="username" class="form-control" required autocomplete="username">
              </div>

              <div class="mb-3">
                <label for="email" class="form-label">E-mail:</label>
                <input type="email" name="email" id="email" class="form-control" required autocomplete="email">
              </div>

              <div class="mb-3">
                <label for="password" class="form-label">Password:</label>
                <input type="password" name="password" id="password" class="form-control" required autocomplete="new-password">
              </div>

              <div class="mb-3">
                <label for="confirm_password" class="form-label">Confirmar Password:</label>
                <input type="password" name="confirm_password" id="confirm_password" class="form-control" required autocomplete="new-password">
              </div>

              <div class="mb-3">
                <label for="user_type" class="form-label">Tipo de Utilizador:</label>
                <select name="user_type" id="user_type" class="form-select" required>
                  <option value="user">User</option>
                  <option value="admin">Admin</option>
                </select>
              </div>

              <div class="mb-3">
                <label for="profile_pic" class="form-label">Escolha uma imagem:</label>
                <input type="file" id="profile_pic" name="profile_pic" class="form-control" accept="image/*">
              </div>

              <input type="submit" class="neon-btn" value="Registar">
            </form>
          </div>
        </div>
      </div>
    </section>
  </main>

  <!-- JavaScript Script -->
  <script>
    // Garante que o script só roda quando o HTML estiver completamente carregado
    $(document).ready(function() {

      // Impede o recarregamento da página após envio do form, uso do AJAX
      $('#register-form').submit(function(event) {
        event.preventDefault(); // Evita o envio padrao do form

        // Coleta e validacao dos dados digitados nos campos do form usando JS
        let username = $('#username').val();
        let email = $('#email').val();
        let password = $('#password').val();
        let confirmPassword = $('#confirm_password').val();
        let userType = $('#user_type').val();
        let profilePic = $('#profile_pic')[0].files.length;
        let errorMessage = [];

        // Validaçao do nome de usuário
        if (username.length < 3) {
          errorMessage.push('O nome do utilizador deve ter pelo menos 3 caracteres.');
        }

        // Validaçao do e-mail
        let emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailPattern.test(email)) {
          errorMessage.push('Por favor, insira um e-mail válido.');
        }

        // Validaçao da senha
        if (password.length < 6) {
          errorMessage.push('A senha deve ter pelo menos 6 caracteres.');
        }

        // Verifica se a senha e a confirmaçao sao iguais
        if (password !== confirmPassword) {
          errorMessage.push('As senhas não correspondem.');
        }

        // Validaçao do campo de imagem
        if (profilePic === 0) {
          errorMessage.push('Por favor, carregue uma foto de perfil.');
        }

        // Exibe mensagem de erro (se mais de uma msg de erro todas serao mostradas em array)
        if (errorMessage.length > 0) {
          $('#error-message').removeClass('d-none').html(errorMessage.join('<br>'));
          return;
        }

        // Envia o formulário usando AJAX
        const formData = new FormData(document.getElementById('register-form'));
        $.ajax({
          url: 'process_register.php',
          type: 'POST',
          data: formData,
          contentType: false,
          processData: false,
          dataType: 'json',
          success: function(response) {
            if (response.success) {
              window.location.href = '../login/login.php';
            } else {
              $('#error-message').removeClass('d-none').html(response.message);
            }
          },
          error: function() {
            $('#error-message').text('Erro ao processar o registro.');
          }
        });
      });
    });
  </script>

  <!-- TypeScript -->
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      // Typed.js
      const typed = new Typed(".typed-text-register", {
        strings: ["Registe-se"],
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