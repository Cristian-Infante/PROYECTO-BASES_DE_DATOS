<?php
    session_start();
    $usuario = $_SESSION['user_name'];
    echo "<h1> Bienvenido $usuario</h1>";
?>