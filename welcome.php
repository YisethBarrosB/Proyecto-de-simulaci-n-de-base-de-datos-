<?php
session_start();
// Verificar si el usuario ha iniciado sesión
if (isset($_SESSION['user']) && !empty($_SESSION['user'])) {
    echo "BIENVENID@: {$_SESSION['user']['name']} <br>";
} else {
    // Redirigir a la página de inicio si no está autenticado
    header('Location: index2.php');
    exit;
}
// Verificar si ya existen posts en la cookie
$posts = isset($_COOKIE['posts']) ? json_decode($_COOKIE['posts'], true) : [];


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['titulo']) && isset($_POST['descripcion'])) {
    $nuevo_post = [
        'titulo' => $_POST['titulo'],
        'descripcion' => $_POST['descripcion'],
        

    $posts[] = $nuevo_post;


    setcookie('posts', json_encode($posts), time() + (365 * 24 * 60 * 60), "/"); 
}

$posts = isset($_SESSION['posts']) ? $_SESSION['posts'] : []; 

// Verificar si se envió el formulario de creación de post
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['titulo']) && isset($_POST['descripcion'])) {
    // Validar el contenido del post
    $titulo = trim($_POST['titulo']);
    $descripcion = trim($_POST['descripcion']);
    
    if (!empty($titulo) && !empty($descripcion)) {
        // Crear un nuevo post
        $nuevo_post = [
            'titulo' => htmlspecialchars($titulo),
            'descripcion' => htmlspecialchars($descripcion),
            
        ];

        // Añadir el nuevo post al arreglo y guardarlo en la sesión
        $posts[] = $nuevo_post;
        $_SESSION['posts'] = $posts;
    } else {
        echo "Por favor, completa todos los campos.";
    }
}

// Verificar si se ha solicitado eliminar un post
if (isset($_POST['eliminar_post'])) {
    $indice = intval($_POST['eliminar_post']); // Convertir el índice a entero
    if (isset($posts[$indice])) {
        // Eliminar el post del arreglo
        array_splice($posts, $indice, 1);
        $_SESSION['posts'] = $posts; // Actualizar la sesión con los posts restantes
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido</title>
    <link rel="stylesheet" href="./estilos.css"> 
</head>
<body>

<div class="container">

    <!-- Formulario para crear un nuevo post -->
    <form action="welcome.php" method="post">
        <label for="titulo">Título:</label>
        <input type="text" id="titulo" name="titulo" placeholder="Ingresa el título" required>

        <label for="descripcion">Descripción:</label>
        <textarea id="descripcion" name="descripcion" placeholder="Escriba la descripción" required></textarea>

        <input type="submit" value="Enviar">
    </form>

    <h2>Posts Recientes</h2>
    <ul>
        <?php
        if (!empty($posts)) {
            foreach ($posts as $index => $post) {
                echo "<li>";
                echo "<h3>" . htmlspecialchars($post['titulo']) . "</h3>";
                echo "<p>" . htmlspecialchars($post['descripcion']) . "</p>";

                // Formulario para eliminar el post
                echo '<form action="welcome.php" method="post" style="display:inline;">
                    <input type="hidden" name="eliminar_post" value="' . $index . '">
                    <input type="submit" value="Eliminar">
                     </form>';
                echo "</li>";
            }
        } else {
            echo "<p>No hay posts aún.</p>";
        }
        ?>
    </ul>

    <!-- Botones para cerrar sesión -->
    <form action="logout.php" method="post">
        <input type="submit" value="Cerrar sesión">
    </form>

    <!-- Bloquear la sesión -->
    <form action="bloqueo.php" method="post">
            <input type="submit" value="bloquear">
    </form>

</div>

<?php include './footer.php'; ?>


</body>
</html>
