<?php
// Inclui o arquivo de configuração para conexão com o banco de dados
include '../config.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = trim($_POST['username']);
  $password = $_POST['password'];

  // Verifica campos obrigatórios
  if (empty($username) || empty($password)) {
    $_SESSION['error'] = 'Username e password são obrigatórios!';

    // Redireciona para login em caso de erro
    header('Location: login.php');
    exit;
  }

  // Verifica se o utilizador existe e a senha está correta
  $stmt = $pdo->prepare('SELECT id, password_hash, user_type FROM users WHERE username = ?');
  $stmt->execute([$username]);
  $user = $stmt->fetch();

  // Verifica se o username foi encontrado e a password está correta
  if ($user && password_verify($password, $user['password_hash'])) {
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['user_role'] = $user['user_type'];

    // Redireciona para a página de perfil
    header('Location: ../profile/profile.php');
    exit;
  } else {
    // Em caso do username e password erradas redireciona para a pág de Login com o erro
    $_SESSION['error'] = 'Username ou password inválidos.';
    header('Location: login.php');
    exit;
  }
}
