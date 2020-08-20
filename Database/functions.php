    
<?php

try{
    //$Cn = new PDO("pgsql:host=127.0.0.1;port=5432;dbname=services;user=postgres;password=do0malan102030");
    $Cn = new PDO('mysql:host=localhost; dbname=services','root','');
    $Cn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $Cn->exec("SET CHARACTER SET utf8");
   // $Cn->exec("SET CLIENT_ENCODING TO 'UTF8';");
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
//Función para mandar ejecutar un INSERT,UPDATE o DELETE
function Ejecuta($sentencia){
    global $Cn;
        try{
            $result =$Cn->query($sentencia);
            $result->closeCursor();
            return 1;
        }catch(Exception $e){
            die("Error en la LIN: " . $e->getLine() . ", MSG: " . $e->GetMessage());
        }        
return $insert;
}
//Función que manda ejecutar un INSERT regresando el consucutivo
function EjecutaConsecutivo($sentencia){
    global $Cn;
        try{
            $result =$Cn->query($sentencia);
            $resultado = $result->fetchAll(PDO::FETCH_ASSOC);
            $result->closeCursor();
            return $resultado[0]["id"];
        }catch(Exception $e){
            //die("Error en la LIN: " . $e->getLine() . ", MSG: " . $e->GetMessage());
            return 0;
        }        
return $insert;
}
//-------------------------------------------------------------------
function addStudent($data)
{
    $idL = $post['idL'];
    $nom = $post['nombre'];
    $edit = $post['editorial'];
    $autor= $post['autor'];
    $sentencia = 'INSERT INTO libros(idL,nombre,editorial,autor)' . 
                 "values('$idL','$nom','$edit','$autor')";
     
    return Ejecuta($sentencia);
}
function selectStudent(){
    $query="SELECT * from libros";
    return Consulta($query);
}