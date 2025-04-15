<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculadora de Consumo de Energía</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            color: #333;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }
        h1 {
            font-size: 1.5em;
            margin-bottom: 20px;
            text-align: center;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            margin-bottom: 10px;
            font-weight: bold;
        }
        input {
            padding: 10px;
            font-size: 1em;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            padding: 10px;
            font-size: 1em;
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
        .result {
            margin-top: 20px;
            padding: 10px;
            background: #e9ecef;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Calculadora de Consumo de Energía</h1>
        <form method="POST">
            <label for="kwh">Ingrese la cantidad de kWh consumidos:</label>
            <input type="number" id="kwh" name="kwh" step="0.01" required>
            <button type="submit">Calcular</button>
        </form>

        <?php
        define('TARIFA', 17.5);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $cantidad_kwh = isset($_POST['kwh']) ? (float)$_POST['kwh'] : 0;
            $total = TARIFA * $cantidad_kwh;

            echo "<div class='result'>";
            echo "<h2>Detalles del cálculo</h2>";
            echo "<p>Tarifa base por kWh: " . TARIFA . "</p>";
            echo "<p>Cantidad de kWh consumidos: $cantidad_kwh</p>";
            echo "<p>Total a pagar: $total</p>";
            echo "</div>";
        }
        ?>
    </div>
</body>
</html>
