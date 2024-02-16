<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrar Eventos</title>
</head>
<body>
    <h1>Administrar Eventos</h1>

    <!-- Formulario para añadir/modificar/eliminar eventos -->
    <form action="process.php" method="post">
        <label for="eventName">Nombre del Evento:</label>
        <input type="text" id="eventName" name="eventName" required>

        <label for="eventDate">Fecha del Evento:</label>
        <input type="date" id="eventDate" name="eventDate" required>

        <label for="eventLocation">Lugar del Evento:</label>
        <input type="text" id="eventLocation" name="eventLocation" required>

        <select name="action" required>
            <option value="add">Añadir</option>
            <option value="update">Modificar</option>
            <option value="delete">Eliminar</option>
        </select>

        <button type="submit">Enviar</button>
    </form>

    <?php
        // Mostrar la lista actual de eventos
        $events = json_decode(file_get_contents('events.json'), true);

        echo '<h2>Lista Actual de Eventos</h2>';
        echo '<ul>';
        foreach ($events as $event) {
            echo '<li><strong>' . $event['nombre'] . '</strong>: ' . $event['fecha'] . ', ' . $event['lugar'] . '</li>';
        }
        echo '</ul>';
    ?>
</body>
</html>
