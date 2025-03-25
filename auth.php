<?php
include 'conexao.php';
session_start();

// Função para verificar se o utilizador está autenticado
function sessionstatus() {
    return isset($_SESSION["email"]);
}

// Função para obter o email do utilizador autenticado
function getemail() {
    return $_SESSION["email"] ?? '';
}
function getnome() {
    global $liga;
    
    
    
    $email = getemail();
    $sql = "SELECT nome FROM utilizador WHERE email = ?";
    $stmt = $liga->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($row = $result->fetch_assoc()) {
        return $row['nome'];
    }
    
    return '';
}
// Função para verificar se o utilizador é administrador
function isAdmin() {
    global $liga;
    
    if (!sessionstatus()) {
        return false;
    }

    $email = getemail();
    $sql = "SELECT admin FROM utilizador WHERE email = ?";
    $stmt = $liga->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($row = $result->fetch_assoc()) {
        return $row['admin'] == 1;
    }

    return false;
}

?>
