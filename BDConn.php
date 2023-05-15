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
    
    
    public function insertDBEvent($desc,$tipo,$timestamp,$pos,$profundidad,$temp_agua,$sal,$fluor,$conductividad,$temp_aire,$humedad,$pres_atmos,$vel_med_viento,$fecha_fin) {
        $sql = "INSERT INTO eventos (Descripcion, Tipo, Timestamp, Pos, Profundidad, Temp_agua, Sal, Fluor, Conductividad, Temp_aire, Humedad, Pres_atmos, Vel_med_viento, Fecha_fin)"
                . "VALUES ('$desc','$tipo','$timestamp','$pos','$profundidad','$temp_agua','$sal','$fluor','$conductividad','$temp_aire','$humedad','$pres_atmos','$vel_med_viento','$fecha_fin')";
        //DESCOMENTA ESTO PARA VER LA QUERY EN LA APP
        //echo $sql;
        mysqli_query($this->conexion, $sql) or die(mysqli_error($this->conexion));
        return mysqli_insert_id($this->conexion);
    }
    
    public function searchByID($id) {
        $sql = "select * from eventos where ID = $id";
        $datos = mysqli_query($this->conexion,$sql);
        $rawEv = mysqli_fetch_array($datos, MYSQLI_ASSOC);
        return $rawEv;             
    }
    
    public function updateEvent($id,$desc,$tipo,$timestamp,$pos,$profundidad,$temp_agua,$sal,$fluor,$conductividad,$temp_aire,$humedad,$pres_atmos,$vel_med_viento,$fecha_fin) {
        $sql= "UPDATE eventos SET Descripcion='$desc', Tipo='$tipo', Timestamp='$timestamp', Pos='$pos', Profundidad=$profundidad, Temp_agua=$temp_agua, Sal=$sal, Fluor=$fluor, Conductividad=$conductividad, Temp_aire=$temp_aire, Humedad=$humedad, Pres_atmos=$pres_atmos, Vel_med_viento=$vel_med_viento, Fecha_fin='$fecha_fin' "
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
    
   public function getSadoPos($momento, $intervalo){
       //$sql = "select longitud, latitud from posicion order by fecha desc limit 1";
       $sql = "select longitud, latitud from posicion where fecha between '$intervalo' and '$momento' order by fecha desc limit 1;";
       $query =  mysqli_query($this->conexion, $sql) or die(mysqli_error($this->conexion));
       $arQu = mysqli_fetch_array($query,MYSQLI_ASSOC);
       $lat = $arQu['latitud'];
       $long = $arQu['longitud'];
       if($lat == ""){
           $lat = "null";
       }else{
           $istlat= substr($lat, 0, 1);
           if($istlat == "-"){ $lat=$lat."S"; $lat=substr($lat, 1);}
           else{$lat=$lat."N";}
       }
       
       if ($long == ""){
           $long="null";
       }else{
           $istlong= substr($long, 0, 1);
           if($istlong == "-"){$long=$long."W"; $long=substr($long, 1);}
           else{$long=$long."E";}
       }
                 
       $pos = $lat." ".$long;        
       return $pos;
   }
   
   public function getSadoProf($momento, $intervalo){
       $sql = "select profundidad from posicion where fecha between '$intervalo' and '$momento' order by fecha desc limit 1;";
       $query =  mysqli_query($this->conexion, $sql) or die(mysqli_error($this->conexion));
       $arQu = mysqli_fetch_array($query,MYSQLI_ASSOC);
       $prof = $arQu['profundidad'];
       if($prof == ""){$prof="0";}
       return $prof;
   }
   
   public function getSadoTermosalData($momento, $intervalo){
       $sql = "select salinidad,temperatura,fluor,conductividad from termosal where fecha between '$intervalo' and '$momento' order by fecha desc limit 1;";
       $query =  mysqli_query($this->conexion, $sql) or die(mysqli_error($this->conexion));
       $arQu = mysqli_fetch_array($query,MYSQLI_ASSOC);
       return $arQu;
   }
   
   public function getSadoMeteoData($momento, $intervalo) {
       $sql = "select velocidad_media_viento,temperatura_aire,humedad,presion_atm from meteo where fecha between '$intervalo' and '$momento' order by fecha desc limit 1;";
       $query =  mysqli_query($this->conexion, $sql) or die(mysqli_error($this->conexion));
       $arQu = mysqli_fetch_array($query,MYSQLI_ASSOC);
       return $arQu;
   }
   
   
   function __construct($usuario, $contraseña, $server, $dbName) {
        $this->usuario = $usuario;
        $this->contraseña = $contraseña;
        $this->server = $server;
        $this->dbName = $dbName;
    }
   
    
}
