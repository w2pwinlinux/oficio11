<?php 

if (!isset($_SESSION)) {session_start();}

require_once 'autoload_q.php';

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script  language="javascript" src="js/login.js?<?php echo rv_()?>"></script>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Sistema </title>
    <!-- <link rel="stylesheet" href="styles.css">-->
    <style>
        /* Reset General */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: Arial, sans-serif;
}

/* Fondo y contenedor */
body {
    background-color: #001f3f; /* Azul oscuro */
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

/* Caja del login */
.login-container {
    width: 100%;
    max-width: 600px;
    background: #002b5c; /* Azul más claro */
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
    text-align: center;
}

.login-box h2 {
    color: #ffffff;
    margin-bottom: 20px;
}

/* Inputs */
.input-group {
    text-align: left;
    margin-bottom: 15px;
}

.input-group label {
    display: block;
    color: #ffffff;
    font-size: 14px;
    margin-bottom: 5px;
}

.input-group input {
    width: 100%;
    padding: 10px;
    font-size: 16px;
    border: 1px solid #0074cc;
    border-radius: 5px;
    background-color: #ffffff;
    color: #333;
}

/* Animación cuando el input está enfocado */
.input-group input:focus {
    border-color: #0056b3;
    outline: none;
    box-shadow: 0 0 5px rgba(0, 116, 204, 0.7);
}

/* Botón */
.btn-login {
    width: 100%;
    padding: 10px;
    font-size: 16px;
    color: #ffffff;
    background-color: #0056b3; /* Azul oscuro */
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-weight: bold;
    text-transform: uppercase;
    transition: background 0.3s ease;
}

.btn-login:hover {
    background-color: #003f7f; /* Azul más oscuro */
}

/* Responsividad */
@media (max-width: 480px) {
    .login-container {
        width: 90%;
        padding: 15px;
    }

    .input-group input {
        font-size: 14px;
        padding: 8px;
    }

    .btn-login {
        font-size: 14px;
        padding: 8px;
    }
}

    </style>
</head>
<body>


    <div class="login-container">
        <div class="login-box">
            <h2>Oficio11Denim</h2>
            <form>
                <div class="input-group">
                    <label for="usuario">Usuario</label>
                    <input type="text" id="usuario" name="usuario" placeholder="Ingrese su usuario" required>
                </div>

                <div class="input-group">
                    <label for="clave">Contraseña</label>
                    <input type="password" id="clave" name="clave" placeholder="Ingrese su contraseña" required>
                </div>

                <button type="submit" id = "Aceptar" class="btn-login Aceptar">Ingresar</button>
            </form>
        </div>
    </div>

</body>
</html>
