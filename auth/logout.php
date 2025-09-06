<?php
  // Inicío da sessão
  session_start();
  // Limpa todas as variáveis de sessão
  session_unset();
  // Destroi a sessão
  session_destroy();

  // Redireciona para a página inicial
  header('Location: ../index.html');
  exit;
?>