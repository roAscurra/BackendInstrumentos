<?php
include_once("conn.php");
include_once("insertarDatos.php");
ini_set('display_errors','Off');

if (isset($_SERVER['HTTP_ORIGIN'])) {
	// Decide if the origin in $_SERVER['HTTP_ORIGIN'] is one
	// you want to allow, and if so:
	header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
	header('Access-Control-Allow-Credentials: true');
	header('Access-Control-Max-Age: 86400');    // cache for 1 day
}

// Access-Control headers are received during OPTIONS requests
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
	
	if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
		header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");         
	
	if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
		header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

	exit(0);
}


$query = "SELECT * FROM instrumento";
$filtro = false;
if($_REQUEST["id"]){
	$filtro = true;
	$query .= " WHERE id = ".$_REQUEST["id"]."";
}
$query .= " ORDER BY id ASC";

$result = mysqli_query($conn, $query) or die(mysqli_error($conn));

$myarray = array();
while($row = mysqli_fetch_assoc($result)){
	$myObj = new stdClass();
	$myObj->id = intval($row['id']);
	$myObj->instrumento = $row['instrumento'];
    $myObj->marca = $row['marca'];
    $myObj->modelo = $row['modelo'];
    $myObj->imagen = $row['imagen'];
    $myObj->precio = round((float)$row['precio'], 2);
    $myObj->costoEnvio = $row['costoEnvio'];
    $myObj->cantidadVendida = $row['cantidadVendida'];
	$myObj->descripcion = $row['descripcion'];
	
	$query2 = "SELECT * FROM instrumento WHERE id = ".$row['id']."";
	$result2 = mysqli_query($conn, $query2) or die(mysqli_error($conn));
	$myarray2 = array();
	while($row2 = mysqli_fetch_assoc($result2)){
		$myObj2 = new stdClass();
        $myObj2->id = intval($row['id']);
        $myObj2->instrumento = $row['instrumento'];
        $myObj2->marca = $row['marca'];
        $myObj2->modelo = $row['modelo'];
        $myObj2->imagen = $row['imagen'];
        $myObj2->precio = round((float)$row['precio'], 2);
        $myObj2->costoEnvio = $row['costoEnvio'];
        $myObj2->cantidadVendida = $row['cantidadVendida'];
        $myObj2->descripcion = $row['descripcion'];
		array_push($myarray2,$myObj2);
	}
	$myObj->ingredientes = $myarray2;
	array_push($myarray,$myObj); 
}
header('Content-Type: application/json; charset=utf-8');
if($filtro){
	echo json_encode($myObj);	
}else{
	echo json_encode($myarray);		
}

?>