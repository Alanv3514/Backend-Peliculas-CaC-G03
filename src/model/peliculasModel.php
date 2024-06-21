<?php



class PeliculasModel{
    public $conexion;
    public function __construct(){
        //$this->conexion = new mysqli('localhost','root','master4','db_peliculas_PHP');
        // Datos de conexión
        $servername = $_ENV['DB_HOST'];                        // o la dirección del servidor MySQL
        $username = $_ENV['DB_USERNAME'];                // nombre de usuario de MySQL
        $password = $_ENV['DB_PASSWORD']; // contraseña del usuario de MySQL
        $dbname = $_ENV['DB_DATABASE'];                  // nombre de la base de datos a la que te quieres conectar

        // Crear conexión
        $this->conexion = new mysqli($servername, $username, $password, $dbname);
      
        // Verificar conexión
        if ($this->conexion->connect_error) {
            die("Conexión fallida: " . $this->conexion->connect_error);
        }
        // Establecer el conjunto de caracteres a utf8
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

    public function savePeliculas($titulo, $descripcion, $genero, $calificacion, $anio, $estrellas, $duracion, $img_url) {
        // Validar si la película ya existe
        $valida = $this->validatePeliculas($titulo, $descripcion, $genero, $calificacion, $anio, $estrellas, $duracion, $img_url);

        if (!empty($valida)) {
            // Si la validación devuelve resultados, significa que la película ya existe
           
            $resultado = ['error', 'Ya existe una película con las mismas características'];
            return $resultado;
        }

      
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

   
    public function updatePeliculas($id, $titulo,$descripcion,$genero,$calificacion,$anio,$estrellas,$duracion,$img_url){
        $existe= $this->getPeliculas($id);
        $resultado=['error','No existe la película con ID '.$id];
        if(count($existe)>0){
            //$valida = $this->validatePeliculas($id,$titulo, $descripcion,$genero,$calificacion,$anio,$estrellas,$duracion,$img_url);
            //$resultado=['error','Ya existe una película igual'];
            //if(count($valida)==0){
                $sql="UPDATE peliculas SET titulo='$titulo', descripcion='$descripcion',genero='$genero',calificacion='$calificacion',anio='$anio',estrellas='$estrellas'
                             ,duracion='$duracion',img_url='$img_url' WHERE id='$id' ";
                mysqli_query($this->conexion,$sql);
                $resultado=['success','Pelicula actualizada'];
          //  }
        
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

}

?>