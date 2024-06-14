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
        $registos = mysqli_query($this->conexion,$sql);
        while($row = mysqli_fetch_assoc($registos)){
            array_push($Peliculas,$row);
        }
        return $Peliculas;
    }

    public function savePeliculas($titulo,$img_url,$descripcion,$genero,$calificacion,$anio,$estrellas,$duracion,$id_director){
        $valida = $this->validatePeliculas($titulo,$img_url,$descripcion,$genero,$calificacion,$anio,$estrellas,$duracion,$id_director);
        $resultado=['error','Ya existe una pelicula las mismas características'];
        if(count($valida)==0){

            $sql = "INSERT INTO peliculas
                    (titulo, img_url, descripcion, genero, calificacion, anio, estrellas, duracion, id_director)
                    VALUES
                    (:titulo, :img_url, :descripcion, :genero, :calificacion, :anio,:estrellas, :duracion,:id_director)";
            //$sql="INSERT INTO Peliculas(name,description,price) VALUES('$name','$description','$price')";
            mysqli_query($this->conexion,$sql);
            $resultado=['success','Pelicula guardada'];
        }
        return $resultado;
    }

    public function updatePeliculas($id,$img_url, $titulo,$descripcion,$genero,$calificacion,$anio,$estrellas,$duracion,$id_director){
        $existe= $this->getPeliculas($id);
        $resultado=['error','No existe la película con ID '.$id];
        if(count($existe)>0){
            $valida = $this->validatePeliculas($titulo,$img_url, $descripcion,$genero,$calificacion,$anio,$estrellas,$duracion,$id_director);
            $resultado=['error','Ya existe una película igual'];
            if(count($valida)==0){
                $sql="UPDATE Peliculas SET titulo='$titulo',img_url='$img_url', descripcion='$descripcion',genero='$genero',calificacion='$calificacion',anio='$anio',estrellas='$estrellas'
                             ,duracion='$duracion',id_director='$id_director', WHERE id='$id' ";
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
    
    public function validatePeliculas($titulo, $img_url, $descripcion,$genero,$calificacion,$anio,$estrellas,$duracion,$id_director){
        $Peliculas=[];
        $sql="SELECT * FROM Peliculas WHERE titulo='$titulo' AND img_url='$img_url' AND descripcion='$descripcion' AND genero='$genero' AND  calificacion='$calificacion'AND 
                           anio='$anio' AND estrellas='$estrellas' AND duracion='$duracion' AND id_director='$id_director' ";
        $registos = mysqli_query($this->conexion,$sql);
        while($row = mysqli_fetch_assoc($registos)){
            array_push($Peliculas,$row);
        }
        return $Peliculas;
    }
}

?>