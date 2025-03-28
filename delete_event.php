<?php
include 'conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $event_id = intval($_POST['id']);

    $sql = "DELETE FROM evento WHERE id_evento = ?";
    $stmt = mysqli_prepare($liga, $sql);
    mysqli_stmt_bind_param($stmt, "i", $event_id);

    if (mysqli_stmt_execute($stmt)) {
        echo "Evento apagado!";
    } else {
        echo "Erro ao apagar evento.";
    }
}
?>
