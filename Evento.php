<?php


/**
 * Description of Evento
 *
 * @author Roger
 */
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

                
        
    //SOBRECARGA DE CONSTRUCTORES CASERA CHAPUCERA            
        function __construct() {
            $params = func_get_args();
            $num_params = func_num_args();
            $funcion_constructor ='__construct'.$num_params;
            if (method_exists($this,$funcion_constructor)) {
			//si existía esa función, la invoco, reenviando los parámetros que recibí en el constructor original
			call_user_func_array(array($this,$funcion_constructor),$params);
		}

        }
        
        
        function __construct0() {
            
        }

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
        }
  
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
