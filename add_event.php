<?php
include 'conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = $_POST['titulo'];
    $organizador = $_POST['organizador'];
    $local = $_POST['local'];
    $descricao = $_POST['descricao'];
    $preco = $_POST['preco'];
    $data_inicio = $_POST['data_inicio'];
    $data_fim = $_POST['data_fim'];

    $sql = "INSERT INTO evento (titulo, organizador, local, descricao, preco, data_inicio, data_fim) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($liga, $sql);
    mysqli_stmt_bind_param($stmt, "sssssss", $titulo, $organizador, $local, $descricao, $preco, $data_inicio, $data_fim);
    
    if (mysqli_stmt_execute($stmt)) {
        echo "Evento adicionado!";
    } else {
        echo "Erro ao adicionar evento.";
    }
}
?>
