<?php
// Resposta JSON
header('Content-Type: application/json');

// Inclui o arquivo de configuraçao para conexao com a base de dados
include '../config.php';
session_start();

$response = ['success' => false, 'message' => 'Erro desconhecido.'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Recebe os dados do formulário
  $username = htmlspecialchars(trim($_POST['username']));
  $email = htmlspecialchars(trim($_POST['email']));
  $password = $_POST['password'];
  $confirmPassword = $_POST['confirm_password'];
  $userType = $_POST['user_type'];

  // Valida o nome do utilizador
  if (strlen($username) < 3) {
    $response['message'] = 'O nome de utilizador deve ter pelo menos 3 caracteres.';
    echo json_encode($response);
    exit;
  }

  // Valida o e-mail dado pelo utilizador
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $response['message'] = 'Por favor, insira um e-mail válido.';
    echo json_encode($response);
    exit;
  }

  // Valida a senha dada pelo utilizador
  if (strlen($password) < 6) {
    $response['message'] = 'A senha deve ter pelo menos 6 caracteres.';
    echo json_encode($response);
    exit;
  }

  // Verifica se a senha e a confirmaçao da senha sao iguais
  if ($password !== $confirmPassword) {
    $response['message'] = 'As senhas não correspondem.';
    echo json_encode($response);
    exit;
  }

  // Verificar se o nome do usuário ou o e-mail já existem na base de dados
  $stmt = $pdo->prepare('SELECT COUNT(*) FROM users WHERE username = ? OR email = ?');
  $stmt->execute([$username, $email]);
  $userExists = $stmt->fetchColumn() > 0;

  // Em caso de o nome do usuário já existir
  if ($userExists) {
    $response['message'] = 'Nome de utilizador ou email já está em uso.';
    echo json_encode($response);
    exit;
  }

  // Faz o upload da foto de perfil
  $profilePicPath = null;
  if (!empty($_FILES['profile_pic']['name'])) {
    $file = $_FILES['profile_pic'];
    $uploadDir = __DIR__ . '/../uploads';

    // Validar tipo de arquivo carregado
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
    if (!in_array($file['type'], $allowedTypes)) {
      $response['message'] = 'Tipo de arquivo inválido.';
      echo json_encode($response);
      exit;
    }

    // Verifica se o diretório de uploads existe, caso nao exista, cria um
    if (!is_dir($uploadDir)) {
      mkdir($uploadDir, 0755, true);
    }

    // Gerar nome único para cada arquivo adicionado evitando subscreever os já existentes
    $newFileName = uniqid() . '-' . basename($file['name']);
    $uploadFile = $uploadDir . '/' . $newFileName;

    // Verifica se o arquivo foi movido corretamente para o diretório de uploads
    if (move_uploaded_file($file['tmp_name'], $uploadFile)) {
      $profilePicPath = 'uploads/' . $newFileName;
    } else {
      $response['message'] = 'Erro ao fazer upload da foto de perfil.';
      echo json_encode($response);
      exit;
    }
  }
  // Criptografa a senha
  $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

  // Insere o novo usuário na base de dados
  $stmt = $pdo->prepare('INSERT INTO users (username, email, password_hash, profile_pic, user_type) VALUES (?, ?, ?, ?, ?)');
  $success = $stmt->execute([$username, $email, $hashedPassword, $profilePicPath, $userType]);

  // Em caso de o usuário for inserido corretamente na base de dados
  if ($success) {
    $response['success'] = true;
    $response['message'] = 'Registo realizado com sucesso.';
  } else {
    $response['message'] = 'Erro ao registar o utilizador.';
  }

  echo json_encode($response);
  exit;
}
