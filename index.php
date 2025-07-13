<?php
// Leer los datos del archivo JSON
$resultado = null;
$archivoJson = 'datos_resultados.json';

if (!file_exists($archivoJson)) {
    die('No se encuentra el archivo de resultados.');
}

$datos = json_decode(file_get_contents($archivoJson), true);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dniIngresado = trim($_POST['dni']);

    foreach ($datos as $fila) {
        if ($fila['dni'] == $dniIngresado) {
            $resultado = $fila;
            break;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultados Simulacro CEPREUNA</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(to right, #ffe0b2, #fff3e0);
            color: #333;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 60px auto;
            background-color: #ffffffcc;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }
        .logo {
            text-align: center;
            margin-bottom: 20px;
        }
        .logo img {
            max-width: 180px;
        }
        h1 {
            text-align: center;
            color: #e65100;
            margin-bottom: 30px;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            margin-bottom: 8px;
            font-weight: bold;
        }
        input[type="text"] {
            padding: 12px;
            font-size: 16px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
        }
        input[type="submit"] {
            padding: 12px;
            font-size: 16px;
            background-color: #fb8c00;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        input[type="submit"]:hover {
            background-color: #ef6c00;
        }
        .resultado {
            background-color: #fff3e0;
            padding: 20px;
            border-radius: 10px;
            margin-top: 30px;
            box-shadow: inset 0 0 10px rgba(0,0,0,0.05);
        }
        .resultado p {
            margin: 10px 0;
            font-size: 16px;
        }
        .error {
            color: red;
            margin-top: 20px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>EXÁMEN DE SIMULACRO CEPREUNA 2025-I</h1>
        <div class="logo">
            <img src="logo.png" alt="Logo CEPREUNA">
        </div>
        <h1>Consulta de Resultados</h1>
        <form method="post">
            <label for="dni">Ingrese su DNI:</label>
            <input type="text" name="dni" id="dni" required>
            <input type="submit" value="Consultar">
        </form>

        <?php if ($resultado): ?>
            <div class="resultado">
                <p><strong>DNI:</strong> <?= htmlspecialchars($resultado['dni']) ?></p>
                <p><strong>Nombres:</strong> <?= htmlspecialchars($resultado['nombre_completo']) ?></p>
                <p><strong>Área:</strong> <?= htmlspecialchars($resultado['area']) ?></p>
                <p><strong>Puntaje:</strong> <?= htmlspecialchars($resultado['puntaje']) ?></p>
            </div>
        <?php elseif ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
            <div class="error">
                No se encontraron resultados para el DNI ingresado.
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
