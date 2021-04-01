<?php 
    include 'Funks.php';
    if (!empty(filter_input_array(INPUT_POST))){
                $opt = filter_input_array(INPUT_POST);
    }else{
        $opt = null;
    }
    
    if(!is_null($opt)){
        $fileDesc = $opt['fileDesc'];
        $filename = "Eventos-$fileDesc.csv";
        $filepath = "Exports/$filename";
        unset($opt['fileDesc']);
        //La idea es recorrer el array de eventos, por cada evento recorrer sus atributos, por cada atributo recorrer el array de opciones para ver si alguna de las opciones escogidas coincide con el.
        $eventos = leerEventos();
        $archivo = fopen($filepath, 'w');
        $delim=",";
        fputcsv($archivo, $opt,$delim);
        foreach ($eventos as $e) {
            $linea=array();
            foreach ($e as $dato => $val) {
               if(in_array($dato, $opt)){
                   array_push($linea,$val);
               }              
            }
            fputcsv($archivo, $linea,$delim);
        }
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="'.$filename.'";');
        readfile($filepath);
        //header("Location: index.php");
        exit();
    }else{
            
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <script src="js/jquery-3.6.0.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <title>Exportar CSV</title>
    </head>
    <body>
        <div class="container  my-5">
            <div class="row ">
                <p class="alert-secondary rounded-2 h1 text-center my-5"> Exportar eventos a fichero CSV</p>
            </div>      
        </div>
        <div class=" my-5  container justify-content-center">
            <div class="row mb-3">
                <h3 class="text-center">¿Qué datos deseas incluir en el archivo?</h3>
            </div> 
            <form name="csvopt" action="ExportCSV.php" method="post" >
                <div class="form-check form-check-inline col-2">
                    <input class="form-check-input" type="checkbox" name="ID" id="ID" value="ID" checked>
                    <label class="form-check-label" for="ID">ID</label>
                </div>
                <div class="form-check form-check-inline col-2">
                    <input class="form-check-input" type="checkbox" name="Descripcion" id="Descripcion" value="desc" checked >
                    <label class="form-check-label" for="Descripcion">Descripcion</label>
                </div>
                <div class="form-check form-check-inline col-2">
                    <input class="form-check-input" type="checkbox" name="Tipo" id="Tipo" value="tipo" checked >
                    <label class="form-check-label" for="Tipo">Tipo</label>
                </div>
                  <div class="form-check form-check-inline col-2">
                    <input class="form-check-input" type="checkbox" name="Timestamp" id="Timestamp" value="timestamp" checked >
                    <label class="form-check-label" for="Timestamp">Timestamp</label>
                </div>
                <div class="form-check form-check-inline col-2">
                    <input class="form-check-input" type="checkbox" name="Pos" id="Pos" value="pos" checked>
                    <label class="form-check-label" for="Pos">Pos</label>
                </div>
                <div class="form-check form-check-inline col-2">
                    <input class="form-check-input" type="checkbox" name="Profundidad" id="Profundidad" value="profundidad">
                    <label class="form-check-label" for="Profundidad">Profundidad</label>
                </div>
                  <div class="form-check form-check-inline col-2">
                    <input class="form-check-input" type="checkbox" name="Temp_agua" id="Temp_agua" value="temp_agua">
                    <label class="form-check-label" for="Temp_agua">Temp_agua</label>
                </div>
                <div class="form-check form-check-inline col-2">
                    <input class="form-check-input" type="checkbox" name="Sal" id="Sal" value="sal">
                    <label class="form-check-label" for="Sal">Sal</label>
                </div>
                <div class="form-check form-check-inline col-2">
                    <input class="form-check-input" type="checkbox" name="Fluor" id="Fluor" value="fluor">
                    <label class="form-check-label" for="Fluor">Fluor</label>
                </div>
                <div class="form-check form-check-inline col-2">
                    <input class="form-check-input" type="checkbox" name="Conductividad" id="Conductividad" value="conductividad">
                    <label class="form-check-label" for="Conductividad">Conductividad</label>
                </div>
                <div class="form-check form-check-inline col-2">
                    <input class="form-check-input" type="checkbox" name="Temp_aire" id="Temp_aire" value="temp_aire">
                    <label class="form-check-label" for="Temp_aire">Temp_aire</label>
                </div>
                <div class="form-check form-check-inline col-2">
                    <input class="form-check-input" type="checkbox" name="Humedad" id="Humedad" value="humedad">
                    <label class="form-check-label" for="Humedad">Humedad</label>
                </div>
                <div class="form-check form-check-inline col-2">
                    <input class="form-check-input" type="checkbox" name="Pres_atmos" id="Pres_atmos" value="pres_atmos">
                    <label class="form-check-label" for="Pres_atmos">Pres_atmos</label>
                </div>
                <div class="form-check form-check-inline col-2">
                    <input class="form-check-input" type="checkbox" name="Vel_med_viento" id="Vel_med_viento" value="vel_med_viento">
                    <label class="form-check-label" for="Vel_med_viento">Vel_med_viento</label>
                </div>
                <div class="my-5">
                    <label for="fileDesc" class="form-label"><b>Introduce un identificador para el archivo</b></label>
                    <input type="text" class="form-control" name="fileDesc" id="fileDesc" aria-describedby="fileDescHelp" />
                    <div id="fileDescHelp" class="form-text">El nombre de la campaña, nombre del IP, tu nombre, el tipo de instrumentos...</div> 
                </div>
                
                <div class="container">
                    <div class="row justify-content-around form-actions mt-5 ">
                        <div class="col-4 " >
                            <button type="submit" class="btn btn-primary btn-lg" style="display:block; width: 100%; ">Exportar</button>
                        </div>
                        <div class="col-4" >
                            <a class="btn btn-lg btn-secondary " href="index.php" style="display:block; width: 100%; ">Volver</a>
                         </div>
                    </div>
                </div>                
            </form>           
        </div>
    </body>
</html>

    <?php } ?>

