<?php
// Verificar si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener datos del formulario
    $eventName = htmlspecialchars($_POST['eventName']);
    $eventDate = htmlspecialchars($_POST['eventDate']);
    $eventLocation = htmlspecialchars($_POST['eventLocation']);
    $action = htmlspecialchars($_POST['action']);

    // Cargar eventos existentes desde el archivo JSON
    $events = json_decode(file_get_contents('events.json'), true);

    // Realizar la acción seleccionada
    switch ($action) {
        case 'add':
            // Añadir nuevo evento
            $newEvent = array('nombre' => $eventName, 'fecha' => $eventDate, 'lugar' => $eventLocation);
            $events[] = $newEvent;
            break;

        case 'update':
            // Modificar evento existente
            // Aquí asumimos que el nombre del evento se utiliza como identificador único
            foreach ($events as &$event) {
                if ($event['nombre'] === $eventName) {
                    $event['nombre'] = $eventName; // Necesario para mantener el mismo nombre
                    $event['fecha'] = $eventDate;
                    $event['lugar'] = $eventLocation;
                    break;
                }
            }
            break;

        case 'delete':
            // Eliminar evento existente
            // Aquí asumimos que el nombre del evento se utiliza como identificador único
            $events = array_filter($events, function ($event) use ($eventName) {
                return $event['nombre'] !== $eventName;
            });
            break;
    }

    // Guardar los eventos actualizados en el archivo JSON
    file_put_contents('events.json', json_encode($events, JSON_PRETTY_PRINT));

    // Redirigir de nuevo a la página principal
    header('Location: index.php');
    exit();
}
?>
