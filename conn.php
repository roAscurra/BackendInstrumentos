<?php

$servername = "localhost";
$username = "root";
$password = "";

// Crear conexión
$conn = new mysqli($servername, $username, $password);

// Verificar conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Nombre de la base de datos
$database = "InstrumentosDB";

// Crear la base de datos si no existe
$sql_create_db = "CREATE DATABASE IF NOT EXISTS $database";
if ($conn->query($sql_create_db) === TRUE) {
    // echo "Base de datos '$database' creada correctamente.<br>";
} else {
    echo "Error al crear la base de datos '$database': " . $conn->error . "<br>";
}

// Cerrar la conexión temporal a la base de datos
$conn->close();

// Establecer conexión a la base de datos creada
$conn = new mysqli($servername, $username, $password, $database);

// Verificar conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Función para crear la tabla si no existe
function crearTabla($conn) {
    $sql = "CREATE TABLE IF NOT EXISTS Instrumento (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `instrumento` varchar(250) NOT NULL,
        `marca` varchar(250) NOT NULL,
        `modelo` varchar(250) NOT NULL,
        `imagen` varchar(250) NOT NULL,
        `precio` double NOT NULL,
        `costoEnvio` varchar(50) NOT NULL,
        `cantidadVendida` int(11) NOT NULL,
        `descripcion` varchar(250) NOT NULL,
        PRIMARY KEY (`id`)
    )";
    
    if ($conn->query($sql) === TRUE) {
        // echo "Tabla creada correctamente.<br>";
    } else {
        echo "Error al crear la tabla: " . $conn->error . "<br>";
    }
}


// Llamar a la función para crear la tabla
crearTabla($conn);


?>
