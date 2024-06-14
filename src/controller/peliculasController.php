<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");
header('content-type: application/json; charset=utf-8');

require './src/model/peliculasModel.php';


$PeliculasModel= new peliculasModel();

switch($_SERVER['REQUEST_METHOD']){
    case 'GET':
        $respuesta = (!isset($_GET['id'])) ? $PeliculasModel->getPeliculas() : $PeliculasModel->getPeliculas($_GET['id']);
        echo json_encode($respuesta);
    break;

    case 'POST':
        // Decodificar la entrada JSON
        $_POST = json_decode(file_get_contents('php://input'), true);
        
        // Inicializar una variable de respuesta
        $respuesta = [];
    
        // Validar el campo titulo
        if(!isset($_POST['titulo']) || is_null($_POST['titulo']) || empty(trim($_POST['titulo'])) || strlen($_POST['titulo']) > 100){
            $respuesta = ['error', 'El nombre del pelicula no debe estar vacío y no debe de tener más de 80 caracteres'];
        }
        // Validar el campo descripcion
        else if(!isset($_POST['descripcion']) || is_null($_POST['descripcion']) || empty(trim($_POST['descripcion'])) || strlen($_POST['descripcion']) > 150){
            $respuesta = ['error', 'La descripción del pelicula no debe estar vacía y no debe de tener más de 150 caracteres'];
        }
        // Validar el campo genero
        else if(!isset($_POST['genero']) || is_null($_POST['genero']) || empty(trim($_POST['genero'])) || strlen((string)$_POST['genero']) > 50){
            $respuesta = ['error', 'El precio del pelicula no debe estar vacío, debe ser de tipo numérico y no tener más de 20 caracteres'];
        }
        // Si todas las validaciones pasan
        else {
            // Asumimos que $PeliculasModel->savePeliculas es el método para guardar el pelicula en la base de datos
            $respuesta = $PeliculasModel->savePeliculas($_POST['titulo'], $_POST['descripcion'], $_POST['genero']
                                                 ,$_POST['calificacion'], $_POST['anio'], $_POST['estrellas']
                                                 , $_POST['duracion'], $_POST['id_director'], $POST['img_url']);
        }
        
        // Devolver la respuesta en formato JSON
        echo json_encode($respuesta);
        break;
    

    case 'PUT':
        $_PUT= json_decode(file_get_contents('php://input',true));
        if(!isset($_PUT->id) || is_null($_PUT->id) || empty(trim($_PUT->id))){
            $respuesta= ['error','El ID del pelicula no debe estar vacío'];
        }
        else if(!isset($_PUT->titulo) || is_null($_PUT->titulo) || empty(trim($_PUT->titulo)) || strlen($_PUT->titulo) > 80){
            $respuesta= ['error','El nombre de la pelicula no debe estar vacío y no debe de tener más de 80 caracteres'];
        }
        else if(!isset($_PUT->descripcion) || is_null($_PUT->descripcion) || empty(trim($_PUT->descripcion)) || strlen($_PUT->descripcion) > 150){
            $respuesta= ['error','La descripción del pelicula no debe estar vacía y no debe de tener más de 150 caracteres'];
        }
        else if(!isset($_PUT->genero) || is_null($_PUT->genero) || empty(trim($_PUT->genero)) || !is_numeric($_PUT->genero) || strlen($_PUT->genero) > 20){
            $respuesta= ['error','El precio de la pelicula no debe estar vacío , debe ser de tipo numérico y no tener más de 20 caracteres'];
        }
        else{
            $respuesta = $PeliculasModel->updatePeliculas($_PUT->id, $_PUT->titulo, $_PUT->descripcion, $_PUT->genero
                                                      , $_PUT->calificacion, $_PUT->anio, $_PUT->estrellas  
                                                      , $_PUT->duracion, $_PUT->id_director, $_PUT->img_url);
        }
        echo json_encode($respuesta);
    break;

    case 'DELETE';
        $_DELETE= json_decode(file_get_contents('php://input',true));
        if(!isset($_DELETE->id) || is_null($_DELETE->id) || empty(trim($_DELETE->id))){
            $respuesta= ['error','El ID del pelicula no debe estar vacío'];
        }
        else{
            $respuesta = $PeliculasModel->deletePeliculas($_DELETE->id);
        }
        echo json_encode($respuesta);
    break;
}

?>