<?php 
    include_once("./BaseDatos.php");
    header('Content-type: application/json; charset=utf-8');
    $method=$_SERVER['REQUEST_METHOD'];

    $obj = json_decode( file_get_contents('php://input') );   
    $objArr = (array)$obj;
	if (empty($objArr))
    {
		$response["success"] = 422;  //No encontro información 
        $response["message"] = "Error: checar json entrada";
        header($_SERVER['SERVER_PROTOCOL']." 422  Error: faltan parametros de entrada json ");		
    }
    else
    {
	    $response = array();
        $result = actualizarAlumno($objArr);
        if ($result) {
            $response["success"] = "201";
            $response["message"] = "Se Actualizo Alumno";
        }
        else{
            $response["success"] = "409";
            $response["message"] = "Alumnos no se Actualizo";
            header($_SERVER['SERVER_PROTOCOL'] . " 411  Conflicto al Actualizar ");
        }
    }
    echo json_encode($response);
?>