<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrar Eventos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #7D71BF;
        }

        h1,h2,img {
            text-align: center;
        }

        form {
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid black;
        }

        th, td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: black;
            color: white;
        }

        form {
            text-align: center;
        }

        form button {
            margin-left: 10px;
            padding: 8px 12px;
            cursor: pointer;
        }

        .action-buttons button {
            margin-left: 10px;
            padding: 8px 12px;
            cursor: pointer;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.4);
            padding-top: 60px;
        }

        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <img src="https://charangaponteunamilnoh.com/images/1800/7705591/LogoPonteUnaMilnoh.png" alt="Logo" width="200" style="display: block; margin: auto;">

    <h1>Administrar Eventos</h1>

    <!-- Formulario para añadir eventos -->
    <form action="process.php" method="post">
        <label for="eventName">Nombre del Evento:</label>
        <input type="text" id="eventName" name="eventName" required>
        <br><br>
        <label for="eventDate">Fecha del Evento:</label>
        <input type="date" id="eventDate" name="eventDate" required>
        <br><br>
        <label for="eventLocation">Lugar del Evento:</label>
        <input type="text" id="eventLocation" name="eventLocation" required>
        <br><br>
        <input type="hidden" id="action" name="action" value="add">

        <button type="submit">Añadir</button>
    </form>
        <hr>
    <!-- Lista actual de eventos en forma de tabla -->
    <?php
        $events = json_decode(file_get_contents('events.json'), true);

        if (!empty($events)) {
            echo '<h2>Lista Actual de Eventos</h2>';
            echo '<table>';
            echo '<tr><th>Nombre del Evento</th><th>Fecha del Evento</th><th>Lugar del Evento</th><th>Acciones</th></tr>';
        
            foreach ($events as $event) {
                echo '<tr>';
                echo '<td>' . $event['nombre'] . '</td>';
                
                // Formatear la fecha al formato deseado (DD/MM/YYYY)
                $fechaFormateada = date('d/m/Y', strtotime($event['fecha']));
        
                echo '<td>' . $fechaFormateada . '</td>';
                echo '<td>' . $event['lugar'] . '</td>';
                echo '<td class="action-buttons">';
                echo '<button type="button" onclick="openModal(\'' . $event['nombre'] . '\', \'' . $event['fecha'] . '\', \'' . $event['lugar'] . '\')">Modificar</button>';
                echo '<button type="button" onclick="deleteEvent(\'' . $event['nombre'] . '\')">Eliminar</button>';
                echo '</td>';
                echo '</tr>';
            }
        
            echo '</table>';
        } else {
            echo '<p>No hay eventos disponibles.</p>';
        }
    ?>

    <!-- Modal para modificar eventos -->
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2>Modificar Evento</h2>
            <form id="modifyForm" action="process.php" method="post">
                <label for="modifyEventName">Nombre del Evento:</label>
                <input type="text" id="modifyEventName" name="eventName" required>

                <label for="modifyEventDate">Fecha del Evento:</label>
                <input type="date" id="modifyEventDate" name="eventDate" required>

                <label for="modifyEventLocation">Lugar del Evento:</label>
                <input type="text" id="modifyEventLocation" name="eventLocation" required>

                <input type="hidden" id="modifyAction" name="action" value="update">
                <button type="submit">Guardar</button>
            </form>
        </div>
    </div>

    <script>
        function openModal(eventName, eventDate, eventLocation) {
            document.getElementById('modifyEventName').value = eventName;
            document.getElementById('modifyEventDate').value = eventDate;
            document.getElementById('modifyEventLocation').value = eventLocation;
            document.getElementById('modifyAction').value = 'update';
            document.getElementById('myModal').style.display = 'block';
        }

        function closeModal() {
            document.getElementById('myModal').style.display = 'none';
        }

        function deleteEvent(eventName) {
            if (confirm('¿Estás seguro de que deseas eliminar el evento: ' + eventName + '?')) {
                document.getElementById('eventName').value = eventName;
                document.getElementById('action').value = 'delete';
                document.querySelector('form').submit();
            }
        }
    </script>
</body>
</html>
