<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculo de Notas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 0;
            background-color: #f4f4f9;
        }
        form {
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            margin: auto;
        }
        input[type="number"] {
            width: calc(100% - 22px);
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        input[type="submit"] {
            background-color: #007BFF;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
        .result {
            background: #e9ecef;
            padding: 10px;
            border-radius: 5px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <h1>Calculo de Notas</h1>
    <form method="POST">
        <label for="nota1">Nota 1:</label>
        <input type="number" id="nota1" name="nota1" required>

        <label for="nota2">Nota 2:</label>
        <input type="number" id="nota2" name="nota2" required>

        <label for="nota3">Nota 3:</label>
        <input type="number" id="nota3" name="nota3" required>

        <label for="nota4">Nota 4:</label>
        <input type="number" id="nota4" name="nota4" required>

        <input type="submit" value="Calcular">
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nota1 = (int)$_POST['nota1'];
        $nota2 = (int)$_POST['nota2'];
        $nota3 = (int)$_POST['nota3'];
        $nota4 = (int)$_POST['nota4'];

        $suma = $nota1 + $nota2 + $nota3 + $nota4;
        $promedio = $suma / 4;

        $mayorNota = max($nota1, $nota2, $nota3, $nota4);
        $menorNota = min($nota1, $nota2, $nota3, $nota4);

        echo "<div class='result'>";
        echo "<p>La nota mayor es: " . $mayorNota . "</p>";
        echo "<p>La nota menor es: " . $menorNota . "</p>";
        echo "<p>El promedio es: " . $promedio . "</p>";
        echo "</div>";
    }
    ?>
</body>
</html>