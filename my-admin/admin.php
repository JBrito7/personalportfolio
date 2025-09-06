<?php

include 'db.php';
$projects = [];
$message = '';

// Processa o formulário de adição de projeto
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['project_name']) && isset($_POST['project_description'])) {

  // Processa o upload da imagem
  $image = '';
  if (isset($_FILES['project_image']) && $_FILES['project_image']['error'] == UPLOAD_ERR_OK) {
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];

    if (in_array($_FILES['project_image']['type'], $allowedTypes)) {
      $imageName = uniqid() . '_' . basename($_FILES['project_image']['name']);
      $image = 'uploads/' . $imageName;
      move_uploaded_file($_FILES['project_image']['tmp_name'], $image);
    }
  }

  $name = htmlspecialchars($_POST['project_name']);
  $description = htmlspecialchars($_POST['project_description']);

  // Insere os novos projetos adicionados no banco de dados
  $sql = "INSERT INTO projects (name, description, image) VALUES (?, ?, ?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("sss", $name, $description, $image);
  $stmt->execute();
  $stmt->close();

  // Evitar o reenvio do formulário ao fazer refresh
  header("Location: admin.php#projects-table");
  exit();
}

// Verifica se foi feita uma pesquisa
if (isset($_GET['search'])) {
  $search = htmlspecialchars($_GET['search']);
  $sql = "SELECT * FROM projects WHERE name LIKE ? OR description LIKE ?";

  $stmt = $conn->prepare($sql);
  $likeSearch = "%$search%";
  $stmt->bind_param("ss", $likeSearch, $likeSearch);
  $stmt->execute();
  $result = $stmt->get_result();

  while ($row = $result->fetch_assoc()) {
    $projects[] = $row;
  }

  $stmt->close();
} else {

  // Se nao for realizada uma pesquisa seleciona todos os projetos add
  $sql = "SELECT * FROM projects";
  $result = $conn->query($sql);

  // Pega os dados que estao na base e armazena no array PHP
  while ($row = $result->fetch_assoc()) {
    $projects[] = $row;
  }
}

$conn->close();
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
  <link rel="stylesheet" href="../css/my-admin.css">

  <!-- Favicon -->
  <link rel="icon" type="image/png" href="../img/favicon-32x32.png" sizes="32x32">

  <!-- Font Awesome -->
  <script src="https://kit.fontawesome.com/a0444fec76.js" crossorigin="anonymous"></script>

  <!-- Typed.js -->
  <script src="https://cdn.jsdelivr.net/npm/typed.js@2.0.12"></script>

  <!-- Particles.js -->
  <script src="https://cdn.jsdelivr.net/npm/tsparticles@1.37.0/tsparticles.min.js"></script>

  <!-- Lottie Files -->
  <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>

  <!-- Title -->
  <title>Jéssica Brito | Web Developer</title>

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100..900&family=Syne+Mono&display=swap" rel="stylesheet">

</head>

<body>
  <header>
    <!-- Navbar -->
    <nav class="navbar navbar-dark fixed-top">
      <div class="container-fluid">
        <a class="navbar-brand" href="../index.html">
          <span class="brand-main">Jéssica Brito <img src="../img/code.png" alt="coding logo" /></span>
          <span class="brand-subtitle">Web Developer</span>
        </a>
        <ul class="navbar-nav ms-auto flex-row gap-3">
          <li class="nav-item">
            <a class="nav-link" href="../index.html">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../my-admin/admin.php">My Admin</a>
          </li>
        </ul>
      </div>
    </nav>

    <!-- NavBar para versão mobile -->
    <div class="mobile-topbar">
      <button class="openbtn" onclick="openNav()">☰</button>
      <a class="navbar-brand" href="../index.html">
        <span class="brand-main">Jéssica Brito <img src="../img/code.png" alt="coding logo" /></span>
        <span class="brand-subtitle">Web Developer</span>
      </a>
    </div>

    <!-- Sidebar -->
    <div id="mySidebar" class="sidebar-glass">
      <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">x</a>
      <a href="../index.html">Home</a>
      <a href="../my-admin/admin.php">My Admin</a>
    </div>

    <!-- Banner Section -->
    <section class="banner container-fluid">
      <div id="tsparticles"></div>
      <div class="row align-items-center">
        <div class="banner-img col-md-4 text-center">
          <lottie-player src="../json/lottieflies-anime/admin-anime.json"
            class="lottie-animation"
            background="transparent"
            speed="1"
            loop
            autoplay></lottie-player>
        </div>

        <div class="banner-title col-md-8 text-center">
          <h1>
            <span class="typed-text"></span>
            <span class="cursor"></span>
          </h1>
          <p>Faça a gestão dos seus projetos aqui!</p>
        </div>
    </section>
  </header>

  <hr class="neon-hr">

  <main>
    <!-- Section Meus projetos -->
    <section>
      <div class="container">
        <div class="row">
          <div class="projects-title col-12">
            <h2>Meus Projetos</h2>
          </div>

          <!-- Formulario de pesquisa -->
          <div class="col-12 search-form">
            <form action="admin.php#projects-table" method="get">
              <div class="search-bar">
                <label for="search">Procurar por Projetos:</label>
                <input type="text" id="search" name="search" placeholder="Nome ou Descrição do Projeto">
                <input type="submit" value="Procurar" class="neon-btn">
              </div>
            </form>
          </div>

          <!-- Tabela com os Projetos adicionados -->
          <div class="projects-table">
            <?php
            if ($projects):
            ?>
              <table id="projects-table" class="table table-striped table-bordered align-middle">
                <thead>
                  <tr>
                    <th>Imagem</th>
                    <th>Nome</th>
                    <th>Descrição</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  foreach ($projects as $project):
                  ?>
                    <tr>
                      <td>
                        <?php
                        if (!empty($project['image'])):
                        ?>
                          <img src="<?php
                                    echo $project['image'];
                                    ?>"
                            alt="Imagem do Projeto" class="img-fluid rounded">
                        <?php
                        else:
                        ?>
                          Sem Imagem
                        <?php
                        endif;
                        ?>
                      </td>
                      <td>
                        <?php
                        echo htmlspecialchars($project['name']);
                        ?>
                      </td>
                      <td class="description">
                        <?php
                        echo htmlspecialchars($project['description']);
                        ?>
                      </td>
                    </tr>
                  <?php
                  endforeach;
                  ?>
                </tbody>
              </table>
            <?php
            else:
            ?>
              <p>Nenhum projeto adicionado ainda.</p>
            <?php
            endif;
            ?>
          </div>
        </div>
      </div>
    </section>

    <hr class="neon-hr">

    <!-- Add New Projects Section -->
    <section class="new-projects">
      <?php
      if (!empty($message)) echo $message;
      ?>
      <div class="container">
        <div class="row">
          <div class="projects-title col-12">
            <h2>Adicionar Novo Projeto</h2>
          </div>

          <form action="admin.php" method="post" enctype="multipart/form-data" class="mb-4">
            <div class="mb-3">
              <label for="project_name" class="form-label">Nome do Projecto:</label>
              <input type="text" name="project_name" id="project_name" class="form-control" required>
            </div>

            <div class="mb-3">
              <label for="project_description" class="form-label">Descrição do Projecto:</label>
              <textarea name="project_description" id="project_description" class="form-control" placeholder="Descreva o seu projeto" required></textarea>
            </div>

            <div class="mb-3">
              <label for="project_image" class="form-label">Escolha uma imagem:</label>
              <input type="file" id="project_image" name="project_image" class="form-control" accept="image/*">
            </div>

            <button type="submit" class="neon-btn">Adicionar Projecto</button>
          </form>
        </div>
      </div>
    </section>
  </main>

  <footer>
    <div class="social-media">
      <a
        href="https://www.instagram.com/jessbr7/?hl=pt"
        target="_blank"
        rel="noopener"
        title="Instagram de Jéssica Brito"><i class="fa-brands fa-instagram"></i></a>
      <a
        href="https://www.facebook.com/jessieb7393"
        target="_blank"
        rel="noopener"
        title="Facebook de Jéssica Brito"><i class="fa-brands fa-facebook"></i></a>
      <a
        href="https://web.whatsapp.com/"
        target="_blank"
        rel="noopener"
        title="WhatsApp de Jéssica Brito"><i class="fa-brands fa-whatsapp"></i></a>
      <a
        href="https://www.linkedin.com/in/j%C3%A9ssica-brito-66b882281/"
        target="_blank"
        rel="noopener"
        title="LinkedIn de Jéssica Brito"><i class="fa-brands fa-linkedin"></i></a>
    </div>

    <div class="copyright">
      <p>&copy; <span id="year"></span> <a href="https://jessicabrito.lu" target="_blank" rel="noopener noreferrer" class="footer-link">Jéssica Brito</a> - Todos os direitos reservados.</p>
    </div>
  </footer>

  <!-- Bootstrap JS -->
  <script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>

  <script>
    document.addEventListener("DOMContentLoaded", function() {
      // Typed.js
      const typed = new Typed(".typed-text", {
        strings: ["My Admin"],
        typeSpeed: 80,
        backSpeed: 50,
        loop: true,
        backDelay: 2000,
        startDelay: 500,
      });

      // tsParticles
      tsParticles.load("tsparticles", {
        fullScreen: {
          enable: false
        },
        particles: {
          number: {
            value: 60
          },
          color: {
            value: "#00FFFF"
          },
          shape: {
            type: "circle"
          },
          opacity: {
            value: 0.3,
            random: true,
          },

          size: {
            value: 4,
            random: {
              enable: true,
              minimumValue: 1
            },
          },

          move: {
            enable: true,
            speed: 1.2,
            direction: "none",
            random: false,
            straight: false,
            outModes: "bounce",
          },

          links: {
            enable: true,
            distance: 150,
            color: "#00FFFF",
            opacity: 0.2,
            width: 1,
          },
        },

        interactivity: {
          events: {
            onhover: {
              enable: true,
              mode: "grab"
            },
            onclick: {
              enable: true,
              mode: "push"
            },
          },
          modes: {
            grab: {
              distance: 140,
              links: {
                opacity: 0.4
              },
            },
            push: {
              quantity: 4
            },
          },
        },

        detectRetina: true,
        background: {
          color: "transparent"
        },
      });
    });
    // Sidebar JavaScript

    function openNav() {
      document.getElementById("mySidebar").style.width = "260px";
    }

    function closeNav() {
      document.getElementById("mySidebar").style.width = "0";
    }

    // Actualizar o ano do Copyright automaticamente
    document.getElementById("year").textContent = new Date().getFullYear();
  </script>
</body>

</html>