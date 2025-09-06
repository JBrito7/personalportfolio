<?php
    $host = 'localhost';
    $db = 'portfolio';
    $user = 'root';
    $pass = '';

    $conn = new mysqli($host, $user, $pass, $db);

    // Verificar se existe erro na ligaçao ao MySQL
    if ($conn->connect_error) {
        die("Erro de conexão: " . $conn->connect_error);
    }
?>