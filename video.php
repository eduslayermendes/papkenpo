<?php
session_start();
if (!isset($_SESSION['email'])) {
    die("Acesso negado.");
}

$video = $_GET['video'];
$caminho = "media/" . basename($video);

if (!file_exists($caminho)) {
    die("Vídeo não encontrado.");
}

// Definir cabeçalhos para streaming
header("Content-Type: video/mp4");
header("Accept-Ranges: bytes");
header("Content-Length: " . filesize($caminho));
readfile($caminho);
exit;
?>
