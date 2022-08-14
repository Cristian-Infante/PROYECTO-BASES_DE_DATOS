<?php
    session_start();
    $usuario = $_SESSION['user_name'];
    include_once("conexion_postgres.php");
    if(!empty($usuario)){
        header("location: menu.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Login</title>

        <link rel="stylesheet" type="text/css" href="login.css">
        <script src="login.js"></script>
    </head>
    <body>
        <div class="container" id="container">
            <div class="form-container sign-up-container">
                <form action="home.php" method="post">
                    <h1>Create Account</h1>
                    <input type="text" placeholder="Name" maxlength="20" autocomplete="off" value=""/>
                    <input type="text" placeholder="Last Name" maxlength="20" autocomplete="off" value=""/>
                    <input type="text" placeholder="User" autocomplete="off" value=""/>
                    <input type="password" placeholder="Password" autocomplete="off" value=""/>
                    <button class="signup">Sign Up</button>
                </form>
            </div>
            <div class="form-container sign-in-container">
                <form action="login1.php" method="post">
                    <h1>Sign in</h1>
                    <input type="text" name="user" placeholder="User" maxlength="5" autocomplete="off" value=""/>
                    <input type="password" name="password" placeholder="Password" maxlength="5" autocomplete="off" value=""/>
                    <nav class="wrong"></nav>
                    <a href="#">Forgot your password?</a>
                    <button class="signin" type="submit">Sign In</button>
                </form>
            </div>
            <div class="overlay-container">
                <div class="overlay">
                    <div class="overlay-panel overlay-left">
                        <h1>Hello, Friend!</h1>
                        <p>Complete the required fields to create an account</p>
                        <p>If you have an account created, click on the following button</p>
                        <button class="ghost" id="signIn">Sign In</button>
                    </div>
                    <div class="overlay-panel overlay-right">
                        <h1>Welcome Back!</h1>
                        <p>Enter your username and password to continue</p>
                        <p>If you do not have an account created, click on the following button</p>
                        <button class="ghost" id="signUp">Sign Up</button>
                    </div>
                </div>
            </div>
        </div>
        <script src="login.js"></script>
    </body>
</html>