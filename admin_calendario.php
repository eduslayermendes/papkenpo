<?php
include 'auth.php';

// Verifica se o utilizador está autenticado e é administrador
if (!sessionstatus() || !isAdmin()) {
    header("Location: index.php"); // Redireciona para a página inicial se não for admin
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Calendário</title>
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.js"></script>
</head>
<body>
    <h1>Gestão de Eventos</h1>
    <div id="calendar"></div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let calendarEl = document.getElementById('calendar');
            let calendar = new FullCalendar.Calendar(calendarEl, {
                locale: 'pt',
                initialView: 'dayGridMonth',
                editable: true, 
                selectable: true, 
                events: 'eventos.php', 
                
                eventClick: function(info) {
                    let confirmDelete = confirm("Queres apagar este evento?");
                    if (confirmDelete) {
                        fetch('delete_event.php', {
                            method: 'POST',
                            headers: { "Content-Type": "application/x-www-form-urlencoded" },
                            body: "id=" + info.event.id
                        }).then(response => response.text())
                        .then(data => {
                            alert(data);
                            calendar.refetchEvents();
                        });
                    }
                },
                
                select: function(info) {
                    let titulo = prompt("Título do evento:");
                    let organizador = prompt("Organizador:");
                    let local = prompt("Local:");
                    let descricao = prompt("Descrição:");
                    let preco = prompt("Preço:");
                    
                    // Converte datas para formato compatível com MySQL (YYYY-MM-DD HH:MM:SS)
                    let dataInicio = info.startStr;
                    let dataFim = info.endStr ? info.endStr : dataInicio;

                    console.log("Data Início: ", dataInicio);  // Depuração
                    console.log("Data Fim: ", dataFim);  // Depuração
                    
                    if (titulo && organizador && local && descricao && preco) {
                        fetch('add_event.php', {
                            method: 'POST',
                            headers: { "Content-Type": "application/x-www-form-urlencoded" },
                            body: "titulo=" + encodeURIComponent(titulo) + 
                                  "&organizador=" + encodeURIComponent(organizador) + 
                                  "&local=" + encodeURIComponent(local) + 
                                  "&descricao=" + encodeURIComponent(descricao) + 
                                  "&preco=" + encodeURIComponent(preco) + 
                                  "&data_inicio=" + encodeURIComponent(dataInicio) + 
                                  "&data_fim=" + encodeURIComponent(dataFim)
                        }).then(response => response.text())
                        .then(data => {
                            alert(data);
                            calendar.refetchEvents();
                        });
                    }
                }
            });
            calendar.render();
        });
    </script>
</body>
</html>
