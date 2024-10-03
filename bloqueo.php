<?php 
session_start(); // Asegúrate de iniciar la sesión

echo "Sesión bloqueada: {$_SESSION['user']['name']} <br>";

echo "Si desea desbloquear su sesión, ingrese la contraseña";

?>

<form action="welcome.php" method="POST">
    <input type="password" name="password" placeholder="contraseña">
    <input type="submit" value="Iniciar sesión">
</form>
