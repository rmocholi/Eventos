<?php


/**
 * Description of BDConn
 *
 * @author Roger
 */
class BDConn {
    private $usuario;
    private $contraseña;
    private $server;
    private $dbName;
    
    private $conexion;
    private $db;
    


    //Conecta la base de datos
    public function connect(){
        $this->conexion = mysqli_connect($this->server, $this->usuario, $this->contraseña) or die(mysqli_error($this->conexion));;
        $this->db = mysqli_select_db($this->conexion, $this->dbName) or die(mysqli_error($this->conexion));
    }
    
    //Lee la base de datos y devuelve una variable con todos los datos en bruto.
    public function rDBEventos() {
        $datos = mysqli_query($this->conexion,"SELECT * FROM eventos;") or die(mysqli_error($this->conexion));
        return $datos;       
    }
    
    
    public function insertDBEvent($desc,$tipo,$timestamp,$pos,$profundidad,$temp_agua,$sal,$fluor,$conductividad,$temp_aire,$humedad,$pres_atmos,$vel_med_viento) {
        $sql = "INSERT INTO eventos (Descripcion, Tipo, Timestamp, Pos, Profundidad, Temp_agua, Sal, Fluor, Conductividad, Temp_aire, Humedad, Pres_atmos, Vel_med_viento)"
                . "VALUES ('$desc','$tipo','$timestamp','$pos','$profundidad','$temp_agua','$sal','$fluor','$conductividad','$temp_aire','$humedad','$pres_atmos','$vel_med_viento')";
        echo $sql;
        mysqli_query($this->conexion, $sql) or die(mysqli_error($this->conexion));
    }
    
    public function searchByID($id) {
        $sql = "select * from eventos where ID = $id";
        $datos = mysqli_query($this->conexion,$sql);
        $rawEv = mysqli_fetch_array($datos, MYSQLI_ASSOC);
        return $rawEv;             
    }
    
    public function updateEvent($id,$desc,$tipo,$timestamp,$pos,$profundidad,$temp_agua,$sal,$fluor,$conductividad,$temp_aire,$humedad,$pres_atmos,$vel_med_viento) {
        $sql= "UPDATE eventos SET Descripcion='$desc', Tipo='$tipo', Timestamp='$timestamp', Pos='$pos', Profundidad=$profundidad, Temp_agua=$temp_agua, Sal=$sal, Fluor=$fluor, Conductividad=$conductividad, Temp_aire=$temp_aire, Humedad=$humedad, Pres_atmos=$pres_atmos, Vel_med_viento=$vel_med_viento "
                . "WHERE ID = $id";
        mysqli_query($this->conexion, $sql) or die(mysqli_error($this->conexion));
    }
    
       public function deleteByID($id) {
        $sql = "delete from eventos where ID = $id";
        mysqli_query($this->conexion, $sql) or die(mysqli_error($this->conexion));
        
    }
    
    public function deleteAllEvents() {
        $sql = "delete from eventos";
        mysqli_query($this->conexion, $sql) or die(mysqli_error($this->conexion));
        $sql = "ALTER TABLE eventos AUTO_INCREMENT = 0";
        mysqli_query($this->conexion, $sql) or die(mysqli_error($this->conexion));
    }
    
    //SECCION SADO
    
   public function getSadoLastPos(){
       $sql = "select longitud, latitud from posicion order by fecha desc limit 1";
       $query =  mysqli_query($this->conexion, $sql) or die(mysqli_error($this->conexion));
       $arQu = mysqli_fetch_array($query,MYSQLI_ASSOC);
       $lat = $arQu['latitud'];
       $long = $arQu['longitud'];
       $istlat= substr($lat, 0, 1);    
       $istlong= substr($long, 0, 1);
       if($istlat == "-"){ $lat=$lat."S";}else{$lat=$lat."N";}
       if($istlong == "-"){$long=$long."W";}else{$long=$long."E";}
       $pos = $lat."/".$long;        
       return $pos;
   }
   
   
   function __construct($usuario, $contraseña, $server, $dbName) {
        $this->usuario = $usuario;
        $this->contraseña = $contraseña;
        $this->server = $server;
        $this->dbName = $dbName;
    }
   
    
}
