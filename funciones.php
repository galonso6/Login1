<?php

include_once "base_de_datos.php";

function login($correo, $palabraSecreta)
{
   
    $posibleUsuarioRegistrado = obtenerUsuarioPorCorreo($correo);
    if ($posibleUsuarioRegistrado === false) {
        
        return false;
    }
  
    $palabraSecretaDeBaseDeDatos = $posibleUsuarioRegistrado->palabra_secreta;
    $coinciden = coincidenPalabrasSecretas($palabraSecreta, $palabraSecretaDeBaseDeDatos);
    
    if (!$coinciden) {
        return false;
    }
    iniciarSesion($posibleUsuarioRegistrado); 
    return true;
}
function obtenerUsuarioPorCorreo($correo)
{
    $base_de_datos = obtenerBaseDeDatos();
    $sentencia = $base_de_datos->prepare("SELECT correo, palabra_secreta FROM usuarios WHERE correo = ? LIMIT 1;");
    $sentencia->execute([$correo]);
    return $sentencia->fetchObject();
}

function iniciarSesion($usuario)
{
        session_start();
  
    $_SESSION["correo"] = $usuario->correo;
}


function coincidenPalabrasSecretas($palabraSecreta, $palabraSecretaDeBaseDeDatos)
{
    return password_verify($palabraSecreta, $palabraSecretaDeBaseDeDatos);
}

function hashearPalabraSecreta($palabraSecreta)
{
    return password_hash($palabraSecreta, PASSWORD_BCRYPT);
}
