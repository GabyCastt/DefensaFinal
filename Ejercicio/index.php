<?php
//ESTE ES EL DISEÑO DE UN LOGIN
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background: linear-gradient(to right, #9a8c98, #9a8c98);
            /* Gradient background */
            font-family: 'Montserrat', sans-serif;
            /* Font family */
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }

        .container {
            background-color: rgba(255, 255, 255, 0.8);
            /* Transparent background */
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
            padding: 30px;
            text-align: center;
            width: 350px;
        }

        h2 {
            font-size: 24px;
            font-weight: bold;
            color: #333;
            margin-bottom: 20px;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #9d8189;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 18px;
            font-family: 'Montserrat', sans-serif;
        }

        input[type="submit"] {
            background-color: #9d8189;
            /* Purple button */
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 18px;
            font-weight: bold;
        }

        a {
            color: #cb997e;
            /* Purple link */
            text-decoration: none;
            font-size: 16px;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Login</h2>
        <form action="index.php" method="post">
            <input type="text" name="correo_electronico" placeholder="Correo Electrónico" required>
            <input type="password" name="contrasena" placeholder="Contraseña" required>
            <input type="submit" name="login" value="Entrar">
            <div>
                <input type="checkbox" id="rememberMe">
                <label for="rememberMe">Recordarme</label>
            </div>
            <a href="#">¿Olvidaste tu contraseña?</a><br><br>
            <p>¿No tienes una cuenta? <a href="views/registro.php">Regístrate</a></p>
        </form>
        <?php
        if (isset($_GET['error'])) {
            if ($_GET['error'] == 1) {
                echo '<div class="alert alert-danger mt-3">Credenciales incorrectas.</div>';
            } elseif ($_GET['error'] == 2) {
                echo '<div class="alert alert-danger mt-3">Error al registrar usuario.</div>';
            }
        }
        if (isset($_GET['registro']) && $_GET['registro'] == 1) {
            echo '<div class="alert alert-success mt-3">Registro exitoso. Por favor, inicia sesión.</div>';
        }
        ?>
    </div>
</body>

</html>