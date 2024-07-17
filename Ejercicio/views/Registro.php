<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #9a8c98;
        }

        .container {
            background-color: rgba(255, 255, 255, 0.8);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
            text-align: center;
            width: 350px;
        }

        h2 {
            font-size: 24px;
            font-weight: bold;
            color: #333;
            margin-bottom: 20px;
        }

        input[type="text"], input[type="password"], input[type="email"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 18px;
            font-family: 'Montserrat', sans-serif;
        }

        input[type="submit"], input[type="reset"] {
            background-color: #9d8189; /* Purple button */
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 18px;
            font-weight: bold;
            margin-top: 10px;
        }

        input[type="submit"]:hover, input[type="reset"]:hover {
            background-color: #7e5daa; /* Darker purple on hover */
        }

        a {
            color: #9B73D8; /* Purple link */
            text-decoration: none;
            font-size: 16px;
            font-weight: bold;
        }

        a:hover {
            text-decoration: underline;
        }

        .success-message {
            margin-top: 20px;
            color: #4CAF50;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Registro de Usuario</h2>
        <form id="form-registro">
            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" required>
            </div>
            <div class="form-group">
                <label for="apellido">Apellido:</label>
                <input type="text" id="apellido" name="apellido" required>
            </div>
            <div class="form-group">
                <label for="correo">Correo electrónico:</label>
                <input type="email" id="correo" name="correo" required>
            </div>
            <div class="form-group">
                <label for="contrasena">Contraseña:</label>
                <input type="password" id="contrasena" name="contrasena" required>
            </div>
            <div class="form-group">
                <label for="confirmar_contrasena">Confirmar contraseña:</label>
                <input type="password" id="confirmar_contrasena" name="confirmar_contrasena" required>
            </div>
            <div class="form-group">
                <input type="submit" value="Registrar">
                <input type="reset" value="Cancelar">
            </div>
            <div class="success-message" id="success-message" style="display:none;">Usuario registrado exitosamente.</div>
            <div class="error" id="error-message"></div>
        </form>
    </div>

    <script src="Registro.js"></script>
    <script>
        // Simulación de registro exitoso para propósitos de demostración
        document.getElementById('form-registro').addEventListener('submit', function(event) {
            event.preventDefault(); // Evita el envío real del formulario
            // Aquí se simula la respuesta exitosa del servidor
            document.getElementById('success-message').style.display = 'block';
        });
    </script>
</body>
</html>
