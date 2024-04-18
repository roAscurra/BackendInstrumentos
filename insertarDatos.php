<?php
include_once("conn.php");

$sql = "SELECT * FROM `Instrumento`"; // Usar comillas invertidas (`) en lugar de comillas simples (')

$result = $conn->query($sql);

if ($result && mysqli_num_rows($result) === 0) {
    // La tabla no existe, se deben insertar los datos
    // Leer el contenido del archivo JSON
    $json_data = file_get_contents('instrumentos.json');

    // Decodificar el contenido JSON a un array PHP
    $data = json_decode($json_data, true);

    // Preparar la consulta SQL para insertar los datos
    $sql_insert = "INSERT INTO Instrumento (id, instrumento, marca, modelo, imagen, precio, costoEnvio, cantidadVendida, descripcion) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

    // Preparar la sentencia
    $stmt = $conn->prepare($sql_insert);

    // Recorrer los datos y ejecutar la consulta para cada registro
    foreach ($data['instrumentos'] as $item) {
        $stmt->bind_param("isssssdis", $item['id'], $item['instrumento'], $item['marca'], $item['modelo'], $item['imagen'], $item['precio'], $item['costoEnvio'], $item['cantidadVendida'], $item['descripcion']);
        $stmt->execute();
    }
}

?>
