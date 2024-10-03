<?php
session_start();
if(
    isset($_SESSION['user']) &&
    !empty($_SESSION['user'])
) {
    echo "BIENVENID@: {$_SESSION['user']} desde la página 2<br>";
} else {
    header('Location: index2.php');
}
include './footer.php';