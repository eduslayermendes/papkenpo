<?php
include 'conexao.php';
session_start();

// Função para verificar se o utilizador está autenticado
function estadosessao() {
    return isset($_SESSION["email"]);
}

// Função para obter o email do utilizador autenticado
function buscaremail() {
    return $_SESSION["email"] ?? '';
}
?>
