<?php
    include_once("conexion_postgres.php");

    session_start();
    $usuario = $_POST['user'];
    $contraseña = $_POST['password'];

    $query = "SELECT * FROM profesores WHERE cod_profesor='$usuario' AND contraseña='$contraseña'";
    $consulta2 =pg_query("SELECT * FROM profesores WHERE cod_profesor='$usuario' AND contraseña='$contraseña'");
    $obj = pg_fetch_object($consulta2);
    $consulta = pg_query($conexion, $query);
    $cantidad = pg_numrows($consulta);

    if($cantidad > 0){
        $_SESSION['user_name'] = $obj->nombre;
        $_SESSION['user_code'] = $obj->cod_profesor;
        header("location: menu.php");
    }
    else{
        header("location: index.php");
    }
?>