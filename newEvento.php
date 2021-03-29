<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <script src="js/jquery-3.6.0.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <title>Nuevo Evento</title>
    </head>
    <body>
                <div class="container">
                    <div class="row">
                        <h1>Nuevo Evento</h1>
                    </div>
                    <div class="row">
                        <hr>
                    </div>
                </div>
                <div class="container">
                    <div class="row">
                        <form name="newevent" action="newEvento.php" method="post">
                        <div class="mb-3" <?php echo !empty($descError)?'error':'';?>>
                            <label for="edesc" class="form-label">Descripción</label>
                            <input type="text" class="form-control" name="edesc" id="edesc" aria-describedby="descHelp" value="<?php echo !empty($desc)?$desc:'';?>">
                            <div id="descHelp" class="form-text">Describe el evento(instrumento, razon, etc.)</div>
                        </div>
                        <div class="mb-3">
                            <label for="etipo" class="form-label">Tipo de evento</label>
                            <select id="etipo" name="etipo" class="form-select">
                                <option value="0">Selecciona un tipo</option>
                                <option value="1" >Equipo al Agua</option>
                                <option value="2" >Equipo a bordo</option>
                                <option value="3">Inicio de Linea</option>
                                <option value="4">Fin de Linea</option>
                                <option value="5">Estación</option>
                                <option value="6">Incidencia</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="etime" class="form-label">Fecha y hora</label>
                            <input type="datetime-local" class="form-control" name="etime" id="etime" aria-describedby="etimeHelp" value="">
                            <div id="etimeHelp" class="form-text">Si presionas enter al abrir el calendario se introducirá automaticamente el momento actual.</div>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                      </form>
                    </div>
                </div>
        
        
        
        <script src="js/popper.min.js"></script>
        

    </body>
</html>

<?php
    include 'Funks.php';
    
    if(!empty(filter_input_array(INPUT_POST))){
        $descError= null;
        $tipoError = null;
        $dateError = null;
        
        $desc = filter_input(INPUT_POST, "edesc");
        $tipo = filter_input(INPUT_POST, "etipo");
        $date = filter_input(INPUT_POST, "etime");
        
        $valid = true;
    
    
        if (empty($desc)) {
                $descError = 'Por favor, introduce una descripcion';
                echo "<div class='container'><p>$descError</p></div>";
                $valid = false;
            }

            if ($tipo == "0") {
                $tipoError = 'Por favor, escoge un tipo de evento';
                echo "<div class='container'><p>$tipoError</p></div>";
                $valid = false;
            }

            if (empty($date)) {
                $dateError = 'Por favor, introduce una fecha y hora';
                echo "<div class='container'><p>$dateError</p></div>";
                $valid = false;
            }
            
            if($valid){
                $format_date = date_create($date);
                $good_date = date_format($format_date, 'Y-m-d H:i:s');
                insertarEvento($desc, $tipo, $good_date);
                header("Location: index.php");
            }
    }

?>

