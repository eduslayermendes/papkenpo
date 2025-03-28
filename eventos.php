<?php
include 'conexao.php';

// Buscar eventos na base de dados
$sql = "SELECT * FROM evento ORDER BY data_inicio ASC";
$result = mysqli_query($liga, $sql);

if (mysqli_num_rows($result) > 0) {
    $events = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $events[] = [
            'id' => $row['id_evento'],
            'title' => $row['titulo'],
            'start' => $row['data_inicio'],
            'end' => $row['data_fim'],
            'organizador' => $row['organizador'],
            'local' => $row['local'],
            'descricao' => $row['descricao'],
            'preco' => $row['preco']
        ];
    }
    echo json_encode($events); // Retorna os eventos em formato JSON para o FullCalendar
} else {
    echo json_encode([]); // Caso não haja eventos
}
?>
