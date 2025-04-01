<?php
session_start();
if (!isset($_SESSION['email'])) {
    die("Acesso negado.");
}
//ver qual e a graduacao depois


$imagem = $_GET['img'];
$caminho = "media/" . basename($imagem);

if (file_exists($caminho)) {
    header("Content-Type: image/jpeg"); // Ajusta conforme o tipo de imagem
    readfile($caminho);
} else {
    die("Imagem não encontrada.");
}
?>
