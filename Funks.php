<?php
    require("BDConn.php");
    require("Evento.php");
    
    $eventosDBc = new BDConn("root", "Aqnep2020", "localhost", "eventos");
    $eventosDBc->connect();
    
    function leerEventos(){
        global $eventosDBc;
        $evArray = [];
        $evs = $eventosDBc->rDBEventos();
        while($fila= mysqli_fetch_array($evs)){
            $evento= new Evento($fila['ID'],$fila['Descripcion'], 
                    $fila['Tipo'], 
                    $fila['Timestamp'], 
                    $fila['Pos'], 
                    $fila['Profundidad'], 
                    $fila['Temp_agua'], 
                    $fila['Sal'], 
                    $fila['Fluor'], 
                    $fila['Conductividad'], 
                    $fila['Temp_aire'], 
                    $fila['Humedad'], 
                    $fila['Pres_atmos'], 
                    $fila['Vel_med_viento']);
            array_push($evArray, $evento);
        }
        return $evArray;   
    }
    
    function insertarEvento($desc,$tipo,$date){
        $ev = new Evento($desc,$tipo,$date);
        //Cuando se utiliza este constructor, el propio evento se autorellena
        global $eventosDBc;
        $eventosDBc->insertDBEvent($ev->getDesc(), $ev->getTipo(), $ev->getTimestamp(), $ev->getPos(), $ev->getProfundidad(), $ev->getTemp_agua(), $ev->getSal(), $ev->getFluor(), $ev->getConductividad(), $ev->getTemp_aire(), $ev->getHumedad(), $ev->getPres_atmos(), $ev->getVel_med_viento());
    }
    
    function adquireEv2Update($id) {
    global $eventosDBc;
    $rawEvs = $eventosDBc->searchByID($id);
    $event = new Evento($rawEvs);
    return $event;
    }
    
    function ActualizarEvento($id,$desc,$tipo,$date) {
        global $eventosDBc;
        $ev = new Evento($desc,$tipo,$date);
        $eventosDBc->updateEvent($id, $ev->getDesc(), $ev->getTipo(), $ev->getTimestamp(), $ev->getPos(), $ev->getProfundidad(), $ev->getTemp_agua(), $ev->getSal(), $ev->getFluor(), $ev->getConductividad(), $ev->getTemp_aire(), $ev->getHumedad(), $ev->getPres_atmos(), $ev->getVel_med_viento());
       
    }
    
    
    function mostrarEvento($id) {
        global $eventosDBc;
        $rawEv = $eventosDBc->searchByID($id);
        echo "<div class='container-sm'>";
        echo "<div class='span10 offset1' >";
        echo "<div class='row mb-2'><h3> Información sobre el Evento</h3></div>";
        echo "<div class='row'><table class='table table-stripped'>";
        foreach ($rawEv as $dato => $valor) {
            echo "<tr><th>$dato</th><td>$valor</td></tr>";
        }
        echo "</table></div>";
        echo "</div></div></div></div>";
    
    }
    
    function borrarEvento($id){
        global $eventosDBc;
        $eventosDBc->deleteByID($id);
    }
    
    function borrarTodo() {
    global $eventosDBc;
    $eventosDBc->deleteAllEvents();
    }

