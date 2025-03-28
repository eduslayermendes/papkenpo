<?php
include 'auth.php';
if (!sessionstatus()) {
    header("Location: index.php");
    exit();
}
// Verifica se o ID do evento foi passado na URL
if (isset($_GET['id'])) {
    $evento_id = $_GET['id'];

    // Recupera os detalhes do evento
    $sql = "SELECT * FROM evento WHERE id_evento = ?";
    $stmt = mysqli_prepare($liga, $sql);
    mysqli_stmt_bind_param($stmt, "i", $evento_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        // Detalhes do evento
        $titulo = $row['titulo'];
        $organizador = $row['organizador'];
        $local = $row['local'];
        $descricao = $row['descricao'];
        $preco = $row['preco'];
        $data_inicio = $row['data_inicio'];
        $data_fim = $row['data_fim'];
    } else {
        echo "Evento não encontrado.";
        exit();
    }
} else {
    echo "ID do evento não especificado.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset='utf-8'>
    <title>Detalhes do Evento</title>
</head>
<body>

    <h1>Detalhes do Evento: <?php echo htmlspecialchars($titulo); ?></h1>
    <p><strong>Organizador:</strong> <?php echo htmlspecialchars($organizador); ?></p>
    <p><strong>Local:</strong> <?php echo htmlspecialchars($local); ?></p>
    <p><strong>Descrição:</strong> <?php echo nl2br(htmlspecialchars($descricao)); ?></p>
    <p><strong>Preço:</strong> <?php echo number_format($preco, 2, ',', '.') . "€"; ?></p>
    <p><strong>Data de Início:</strong> <?php echo date('d/m/Y', strtotime($data_inicio)); ?></p>
    <p><strong>Data de Fim:</strong> <?php echo date('d/m/Y', strtotime($data_fim)); ?></p>

    <form method="POST" action="participar_evento.php">
        <input type="hidden" name="evento_id" value="<?php echo $evento_id; ?>">
        <button type="submit">Confirmar participação</button>
    </form>

</body>
</html>
