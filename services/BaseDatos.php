<?php
try{
        //$Cn = new PDO('pgsql:host=localhost;port=5432;dbname=ProyectoX;user=postgres;password=hola');
        $Cn = new PDO('mysql:host=localhost; dbname=services','root','');
        $Cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $Cn->exec("SET CHARACTER SET utf8");
        //$Cn->exec("SET CLIENT_ENCODING TO 'UTF8';");
}catch(Exception $e){
    die("Error: " . $e->GetMessage());
}

// Función para ejecutar consultas SELECT
function Consulta($query)
{
    global $Cn;
    try{    
        $result =$Cn->query($query);
        $resultado = $result->fetchAll(PDO::FETCH_ASSOC); 
        $result->closeCursor();
        return $resultado;
    }catch(Exception $e){
        die("Error en la LIN: " . $e->getLine() . ", MSG: " . $e->GetMessage());
    }
}

// Función que recibe un insert y regresa el consecutivo que le genero
function EjecutaConsecutivo($sentencia){
    global $Cn;
    try {
        $result = $Cn->query($sentencia);
        $resultado = $result->fetchAll(PDO::FETCH_ASSOC);
        $result->closeCursor();
        return $resultado[0]['idcurso'];
    } catch (Exception $e) {
        die("Error en la linea: " + $e->getLine() + 
        " MSG: " + $e->GetMessage());
        return 0;
    }
}

function Ejecuta ($sentencia){
    global $Cn;
    try {
        $result = $Cn->query($sentencia);
        $result->closeCursor();
        return 1; // Exito  
    } catch (Exception $e) {
        //die("Error en la linea: " + $e->getLine() + " MSG: " + $e->GetMessage());
        return 0; // Fallo
    }
}

function consultaAlumnos(){
    $query = 'SELECT idL,nombre,editorial,autor FROM libros ORDER BY nombre';   
    return Consulta($query);
}

function consultaAlumno($idL){
    $query = 'SELECT idL,nombre,editorial,autor  FROM libros WHERE ' . " idL = '$idL' ORDER BY idL";
    return Consulta($query);
}

function insertaAlumno($post){
    $idL = $post['idL'];
    $nom = $post['nombre'];
    $edit = $post['editorial'];
    $autor= $post['autor'];
    $sentencia = 'INSERT INTO libros(idL,nombre,editorial,autor)' . 
                 "values('$idL','$nom','$edit','$autor')";
     
    return Ejecuta($sentencia);
}

function actualizarAlumno($post){
    $idL = $post['idL'];
    $nom = $post['nombre'];
    $edit = $post['editorial'];
    $autor= $post['autor'];
    $sentencia = 'UPDATE  SET ' . 
                 "editorial='$edit',nombre='$nom',
                 autor='$autor' WHERE idL='$idL'"; 
    
    return Ejecuta($sentencia);
}

function borrarAlumno($post){
    $idL = $post['idL'];

    $sentencia = 'DELETE FROM libros ' . 
                 " WHERE idL='$idL'"; 
    
    return Ejecuta($sentencia);
}

function InsActAlumno($post){
    if (insertaAlumno($post)!=1)
        return actualizarAlumno($post);
    else
    return 1;
}

function obj2array($obj) {
    $out = array();
    foreach ($obj as $key => $val) {
      switch(true) {
          case is_object($val):
           $out[$key] = obj2array($val);
           break;
        case is_array($val):
           $out[$key] = obj2array($val);
           break;
        default:
          $out[$key] = $val;
      }
    }
    return $out;
  } 