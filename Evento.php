<?php


//include 'BDConn.php';
class Evento {
        public $ID = 0;
        public $desc = "";
        public $tipo = "";
        public $timestamp = "";
        public $pos = "";
        public $profundidad = 0;
        public $temp_agua = 0;
        public $sal = 0;
        public $fluor = 0;
        public $conductividad  = 0;
        public $temp_aire = 0;
        public $humedad = 0;
        public $pres_atmos = 0;
        public $vel_med_viento = 0;
        
        

        private $sadoConn;
        
        
        
        
        
     //GETTERS Y SETTERS   
        function getID() {
            return $this->ID;
        }

        function getDesc() {
            return $this->desc;
        }

        function getTipo() {
            return $this->tipo;
        }

        function getTimestamp() {
            return $this->timestamp;
        }

        function getPos() {
            return $this->pos;
        }

        function getProfundidad() {
            return $this->profundidad;
        }

        function getTemp_agua() {
            return $this->temp_agua;
        }

        function getSal() {
            return $this->sal;
        }

        function getFluor() {
            return $this->fluor;
        }

        function getConductividad() {
            return $this->conductividad;
        }

        function getTemp_aire() {
            return $this->temp_aire;
        }

        function getHumedad() {
            return $this->humedad;
        }

        function getPres_atmos() {
            return $this->pres_atmos;
        }

        function getVel_med_viento() {
            return $this->vel_med_viento;
        }

        function setID($ID): void {
            $this->ID = $ID;
        }

        function setDesc($desc): void {
            $this->desc = $desc;
        }

        function setTipo($tipo): void {
            $this->tipo = $tipo;
        }

        function setTimestamp($timestamp): void {
            $this->timestamp = $timestamp;
        }

        function setPos($pos): void {
            $this->pos = $pos;
        }

        function setProfundidad($profundidad): void {
            $this->profundidad = $profundidad;
        }

        function setTemp_agua($temp_agua): void {
            $this->temp_agua = $temp_agua;
        }

        function setSal($sal): void {
            $this->sal = $sal;
        }

        function setFluor($fluor): void {
            $this->fluor = $fluor;
        }

        function setConductividad($conductividad): void {
            $this->conductividad = $conductividad;
        }

        function setTemp_aire($temp_aire): void {
            $this->temp_aire = $temp_aire;
        }

        function setHumedad($humedad): void {
            $this->humedad = $humedad;
        }

        function setPres_atmos($pres_atmos): void {
            $this->pres_atmos = $pres_atmos;
        }

        function setVel_med_viento($vel_med_viento): void {
            $this->vel_med_viento = $vel_med_viento;
        }
        
        function LlenarDatosSado() {
            $momento = $this->timestamp;
            $hora = substr($momento,11,2 );
            $hora=$hora-4;
            if(strlen($hora) == 1){$hora = "0".$hora-2;}
            $intervalo = substr_replace($momento, $hora,11,2);
            $this->sadoConn->connect();
            $this->pos= $this->sadoConn->getSadoPos($momento,$intervalo);
            $this->profundidad=$this->sadoConn->getSadoProf($momento, $intervalo);
            $termosal=$this->sadoConn->getSadoTermosalData($momento, $intervalo);
            $this->temp_agua=$termosal['temperatura'];
            $this->sal=$termosal['salinidad'];
            $this->conductividad=$termosal['conductividad'];
            $this->fluor=$termosal['fluor'];
            $meteo= $this->sadoConn->getSadoMeteoData($momento, $intervalo);
            $this->vel_med_viento=$meteo['velocidad_media_viento'];
            $this->humedad=$meteo['humedad'];
            $this->pres_atmos=$meteo['presion_atm'];
            $this->temp_aire=$meteo['temperatura_aire'];
        }

                
        
    //SOBRECARGA DE CONSTRUCTORES CASERA CHAPUCERA            
        function __construct() {
            $this->sadoConn = new BDConn("sadodb", "sado", "sado", "SADO_SDG_RT");
            $params = func_get_args();
            $num_params = func_num_args();
            //uso el constructor cuyo nombre incluya el numero de parametros introducidos
            $funcion_constructor ='__construct'.$num_params;
            if (method_exists($this,$funcion_constructor)) {
			//si existía esa función, la invoco, reenviando los parámetros que recibí en el constructor original
			call_user_func_array(array($this,$funcion_constructor),$params);
		}

        }
        
        
        function __construct0() {
            
        }
        //PARA ADQUIRIR EVENTO PARA POSTERIORMENTE ACTUALIZAR
        function __construct1($rawEv){
            $this->__construct14($rawEv['ID'],$rawEv['Descripcion'],$rawEv['Tipo'],$rawEv['Timestamp'],$rawEv['Pos'],$rawEv['Profundidad'],$rawEv['Temp_agua'],$rawEv['Sal'],$rawEv['Fluor'],$rawEv['Conductividad'],$rawEv['Temp_aire'],$rawEv['Humedad'],$rawEv['Pres_atmos'],$rawEv['Vel_med_viento']);
            switch ($this->tipo){
                case "Equipo al Agua":
                    $this->tipo=1; break;
                case "Equipo a bordo":
                    $this->tipo=2; break;
                case "Inicio de Linea":
                    $this->tipo=3; break;
                case "Fin de Linea":
                    $this->tipo=4; break;
                case "Estación":
                    $this->tipo=5;  break;
                case "Incidencia":
                    $this->tipo=6; break;
            }
        }

        //PARA LA CREACION Y ACTUALIZACIÓN DE EVENTOS
        function __construct3($desc, $tipo, $timestamp) {
            $this->desc = $desc;
            $this->tipo = $tipo;
            $this->timestamp = $timestamp;
            switch ($this->tipo){
                case 1:
                    $this->tipo="Equipo al Agua"; break;
                case 2:
                    $this->tipo="Equipo a bordo"; break;
                case 3:
                    $this->tipo="Inicio de Linea"; break;
                case 4:
                    $this->tipo="Fin de Linea"; break;
                case 5:
                    $this->tipo="Estación";  break;
                case 6:
                    $this->tipo="Incidencia"; break;
            }
            $this->LlenarDatosSado();
        }
  
        //PARA LA LECTURA DE LA BD DE EVENTOS
        function __construct14($ID, $desc, $tipo, $timestamp, $pos, $profundidad, $temp_agua, $sal, $fluor, $conductividad, $temp_aire, $humedad, $pres_atmos, $vel_med_viento) {
            $this->ID = $ID;
            $this->desc = $desc;
            $this->tipo = $tipo;
            $this->timestamp = $timestamp;
            $this->pos = $pos;
            $this->profundidad = $profundidad;
            $this->temp_agua = $temp_agua;
            $this->sal = $sal;
            $this->fluor = $fluor;
            $this->conductividad = $conductividad;
            $this->temp_aire = $temp_aire;
            $this->humedad = $humedad;
            $this->pres_atmos = $pres_atmos;
            $this->vel_med_viento = $vel_med_viento;
        }
        
        
        

}
