<?php


//require_once "./config/database.php";


class PeliculasModel{
    public $conexion;
    public function __construct(){
        $this->conexion = new mysqli('localhost','root','master4','db_peliculas_PHP');
        mysqli_set_charset($this->conexion,'utf8');
    }

    public function getPeliculas($id=null){
        $where = ($id == null) ? "" : " WHERE id='$id'";
        $Peliculas=[];
        $sql="SELECT * FROM peliculas ".$where;
        $registros = mysqli_query($this->conexion,$sql);
        while($row = mysqli_fetch_assoc($registros)){
            array_push($Peliculas,$row);
        }
        return $Peliculas;
    }


/*
public function validatePeliculas($titulo, $descripcion, $genero, $calificacion, $anio, $estrellas, $duracion, $img_url){
    $Peliculas = [];
    $sql = "SELECT * FROM peliculas WHERE titulo = ? AND descripcion = ? AND genero = ? AND calificacion = ? AND anio = ? AND estrellas = ? AND duracion = ? AND img_url = ?";
    $stmt = mysqli_prepare($this->conexion, $sql);
    mysqli_stmt_bind_param($stmt, "ssssssss", $titulo, $descripcion, $genero, $calificacion, $anio, $estrellas, $duracion, $img_url);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    while ($row = mysqli_fetch_assoc($result)) {
        array_push($Peliculas, $row);
    }
    mysqli_stmt_close($stmt);
    return $Peliculas;
}
*/


// -----old version

public function validatePeliculas($titulo, $descripcion, $genero, $calificacion, $anio, $estrellas, $duracion, $img_url) {
    $Peliculas = [];

    // Preparar la consulta
    $sql = "SELECT * FROM peliculas WHERE titulo = ? AND descripcion = ? AND genero = ? AND calificacion = ? AND anio = ? AND estrellas = ? AND duracion = ? AND img_url = ?";
    $stmt = $this->conexion->prepare($sql);
    
    if ($stmt === false) {
        // Manejo del error de preparación de la consulta
        die('Error en la preparación de la consulta: ' . $this->conexion->error);
    }

    // Vincular parámetros
    $stmt->bind_param('ssssssss', $titulo, $descripcion, $genero, $calificacion, $anio, $estrellas, $duracion, $img_url);

    // Ejecutar la consulta
    $stmt->execute();

    // Obtener el resultado
    $result = $stmt->get_result();

    // Verificar si hay registros encontrados
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            array_push($Peliculas, $row);
        }
    }

    // Cerrar la declaración
    $stmt->close();

    return $Peliculas;
}




/*

public function savePeliculas($titulo, $descripcion, $genero, $calificacion, $anio, $estrellas, $duracion, $img_url){
    $valida = $this->validatePeliculas($titulo, $descripcion, $genero, $calificacion, $anio, $estrellas, $duracion, $img_url);
    $resultado = ['error', 'Ya existe una película con las mismas características'];

    if (empty($valida)) { // Si la validación devuelve un array vacío, la película no existe y podemos guardarla
        $sql = "INSERT INTO peliculas (titulo, descripcion, genero, calificacion, anio, estrellas, duracion, img_url) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = mysqli_prepare($this->conexion, $sql);
        mysqli_stmt_bind_param($stmt, "ssssssss", $titulo, $descripcion, $genero, $calificacion, $anio, $estrellas, $duracion, $img_url);
        
        if (mysqli_stmt_execute($stmt)) {
            $resultado = ['success', 'Película guardada'];
        } else {
            $resultado = ['error', 'Error al guardar la película'];
        }
        
        mysqli_stmt_close($stmt);
    }
    
    return $resultado;
}
*/
/*
public function validatePeliculas($titulo, $descripcion, $genero, $calificacion, $anio, $estrellas, $duracion, $img_url) {
    $sql = "SELECT * FROM peliculas WHERE titulo=? AND descripcion=? AND genero=? AND calificacion=? AND anio=? AND estrellas=? AND duracion=? AND img_url=?";
    $stmt = mysqli_prepare($this->conexion, $sql);
    mysqli_stmt_bind_param($stmt, "ssssssss", $titulo, $descripcion, $genero, $calificacion, $anio, $estrellas, $duracion, $img_url);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    $peliculas = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $peliculas[] = $row;
    }
    mysqli_stmt_close($stmt);
    
    return $peliculas;
}

public function savePeliculas($titulo, $descripcion, $genero, $calificacion, $anio, $estrellas, $duracion, $img_url) {
    // Primero, valida si la película ya existe
    $valida = $this->validatePeliculas($titulo, $descripcion, $genero, $calificacion, $anio, $estrellas, $duracion, $img_url);
    
    if (!empty($valida)) {
        // Si la validación devuelve resultados, significa que la película ya existe
        return ['error', 'Ya existe una película con las mismas características'];
    }
    
    // Si la película no existe, proceder con la inserción
    $sql = "INSERT INTO peliculas (titulo, descripcion, genero, calificacion, anio, estrellas, duracion, img_url) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($this->conexion, $sql);
    mysqli_stmt_bind_param($stmt, "ssssssss", $titulo, $descripcion, $genero, $calificacion, $anio, $estrellas, $duracion, $img_url);
    
    if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);
        return ['success', 'Película guardada'];
    } else {
        mysqli_stmt_close($stmt);
        return ['error', 'Error al guardar la película'];
    }
}

*/


    
    
// old version


    public function savePeliculas($titulo, $descripcion, $genero, $calificacion, $anio, $estrellas, $duracion, $img_url) {
        // Validar si la película ya existe
        $valida = $this->validatePeliculas($titulo, $descripcion, $genero, $calificacion, $anio, $estrellas, $duracion, $img_url);

        if (!empty($valida)) {
            // Si la validación devuelve resultados, significa que la película ya existe
           
            $resultado = ['error', 'Ya existe una película con las mismas características'];
            return $resultado;
        }


        //$resultado = ['error', 'Ya existe una película con las mismas características'];
      
        if (empty($valida)) { // Si la validación devuelve un array vacío, la película no existe y podemos guardarla
            $sql = "INSERT INTO peliculas (titulo, descripcion, genero, calificacion, anio, estrellas, duracion, img_url) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            
            $stmt = mysqli_prepare($this->conexion, $sql);
            mysqli_stmt_bind_param($stmt, "ssssssss", $titulo, $descripcion, $genero, $calificacion, $anio, $estrellas, $duracion, $img_url);
            
            if (mysqli_stmt_execute($stmt)) {
                $resultado = ['success', 'Película guardada'];
            

            } else {
                $resultado = ['error', 'Error al guardar la película'];
               
            }
            
            mysqli_stmt_close($stmt);
        }
        
        return $resultado;
    }
    
/*------------------------------
    public function savePeliculas($titulo, $descripcion, $genero, $calificacion, $anio, $estrellas, $duracion, $img_url){
        $valida = $this->validatePeliculas($titulo, $descripcion, $genero, $calificacion, $anio, $estrellas, $duracion, $img_url);
        $resultado = ['error', 'Ya existe una película con las mismas características'];
    
        if (count($valida) == 0) {
            $sql = "INSERT INTO peliculas (titulo, descripcion, genero, calificacion, anio, estrellas, duracion, img_url) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            
            $stmt = mysqli_prepare($this->conexion, $sql);
            mysqli_stmt_bind_param($stmt, "ssssssss", $titulo, $descripcion, $genero, $calificacion, $anio, $estrellas, $duracion, $img_url);
            
            if (mysqli_stmt_execute($stmt)) {
                $resultado = ['success', 'Película guardada'];
            } else {
                $resultado = ['error', 'Error al guardar la película'];
            }
            
            mysqli_stmt_close($stmt);
        }
        
        return $resultado;
    }
*/

    /*
    public function savePeliculas($titulo,$img_url,$descripcion,$genero,$calificacion,$anio,$estrellas,$duracion){
        $valida = $this->validatePeliculas($titulo,$img_url,$descripcion,$genero,$calificacion,$anio,$estrellas,$duracion);
        $resultado=['error','Ya existe una pelicula las mismas características'];
        if(count($valida)==0){

            $sql = "INSERT INTO peliculas
                    (titulo, descripcion, genero, calificacion, anio, estrellas, duracion, img_url )                 
                    VALUES 
                    (?, ?, ?, ?, ?, ?, ?, ?)";
                    //(:titulo, :descripcion, :genero, :calificacion, :anio,:estrellas, :duracion), :img_url";
            //$sql="INSERT INTO Peliculas(name,description,price) VALUES('$name','$description','$price')";
            mysqli_query($this->conexion,$sql);

             
         

            $resultado=['success','Pelicula guardada'];
        }
        return $resultado;
    }
    */
    public function updatePeliculas($id, $titulo,$descripcion,$genero,$calificacion,$anio,$estrellas,$duracion,$img_url){
        $existe= $this->getPeliculas($id);
        $resultado=['error','No existe la película con ID '.$id];
        if(count($existe)>0){
            $valida = $this->validatePeliculas($id,$titulo, $descripcion,$genero,$calificacion,$anio,$estrellas,$duracion,$img_url);
            $resultado=['error','Ya existe una película igual'];
            if(count($valida)==0){
                $sql="UPDATE Peliculas SET titulo='$titulo', descripcion='$descripcion',genero='$genero',calificacion='$calificacion',anio='$anio',estrellas='$estrellas'
                             ,duracion='$duracion',img_url='$img_url', WHERE id='$id' ";
                mysqli_query($this->conexion,$sql);
                $resultado=['success','Pelicula actualizada'];
            }
        }
        return $resultado;
    }
    
    public function deletePeliculas($id){
        $valida = $this->getPeliculas($id);
        $resultado=['error','No existe la película con ID '.$id];
        if(count($valida)>0){
            $sql="DELETE FROM peliculas WHERE id='$id' ";
            mysqli_query($this->conexion,$sql);
            $resultado=['success','Pelicula eliminada'];
        }
        return $resultado;
    }

    
    


    /*
    public function validatePeliculas($titulo, $descripcion,$genero,$calificacion,$anio,$estrellas,$duracion, $img_url){
        $Peliculas=[];
        $sql="SELECT * FROM peliculas WHERE titulo='$titulo' AND img_url='$img_url' AND descripcion='$descripcion' AND genero='$genero' AND  calificacion='$calificacion'AND 
                           anio='$anio' AND estrellas='$estrellas' AND duracion='$duracion' ";
        $registros = mysqli_query($this->conexion,$sql);
        while($row = mysqli_fetch_assoc($registros)){
            array_push($Peliculas,$row);
        }
        return $Peliculas;
    }
    */
}

?>