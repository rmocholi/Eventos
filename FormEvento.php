<!DOCTYPE html>
<?php 
    include 'Funks.php';
    $route = "../CDI_prueba/";
    $clean = [$route, ".xml"];
    if (!empty(filter_input(INPUT_GET, "id"))) {
        $id = filter_input(INPUT_GET, "id");
        $ev = adquireEv2Update($id);
        $updTime = $ev->getTimestamp();
        $updformat_date = date_create($updTime);
        $updTime = date_format($updformat_date, 'Y-m-d\TH:i');

        $updFin = $ev->getFin();
        if($updFin == "0000-00-00 00:00:00"){
            $updFin = null;
        }else{
            $updformat_date = date_create($updFin);
            $updFin = date_format($updformat_date, 'Y-m-d\TH:i');
        }

        
    }else{
        $id = null;
        $typ = 0;
        $inst= "selec";
    }?>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <script src="js/jquery-3.6.0.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <title><?php echo ($id==null ? 'Nuevo Evento' : 'Editar Evento');?></title>
    </head>
    <body>
                <div class="container">
                    <div class="row">
                        <h1><?php echo ($id==null ? 'Nuevo Evento' : 'Editar Evento');?></h1>
                    </div>
                    <div class="row">
                        <hr>
                    </div>
                </div>
                <div class="container">
                    <div class="row">
                        <form name="newevent" action="FormEvento.php" method="post">
                            <input type="hidden" name="id" value="<?php echo $id;?>"/>
                            <div class="mb-3">
                                <label for="edesc" class="form-label">Descripción</label>
                                <input type="text" class="form-control" name="edesc" id="edesc" aria-describedby="descHelp" value="<?php if($id !=null){ echo $ev->getDesc();} ?>"/>
                                <div id="descHelp" class="form-text">Describe el evento(instrumento, razon, etc.)</div> 
                            </div>
                            <div class="mb-3">
                                <label for="etipo" class="form-label">Tipo de evento</label>
                                <select id="etipo" name="etipo" class="form-select">
                                    <?php 
                                        if($id!=null){
                                            $typ=$ev->getTipo();
                                        }?>
                                    <option value="0" <?php echo ($typ == 0 ? 'selected' : ''); ?>>Selecciona un tipo</option>
                                    <option value="1" <?php echo ($typ == 1 ? 'selected' : ''); ?>>Equipo al Agua</option>
                                    <option value="2" <?php echo ($typ == 2 ? 'selected' : ''); ?>>Equipo a bordo</option>
                                    <option value="3" <?php echo ($typ == 3 ? 'selected' : ''); ?>>Estación</option>
                                    <option value="4" <?php echo ($typ == 4 ? 'selected' : ''); ?>>Línea</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="einst" class="form-label">Instrumento</label>
                                <select id="einst" name="einst" class="form-select">
                                    <?php 
                                        if($id!=null){
                                            $inst=$ev->getInstrument();
                                        }?>
                                        <option value="selec" <?php echo ($inst == "selec" ? 'selected' : ''); ?>>Selecciona un instrumento</option>
                                    <?php
                                        if ($handler = opendir($route)) {
                                            foreach (str_replace($clean, '', glob($route."*.xml")) as $file){
                                                ?><option value="<?php echo $file ;?>" <?php echo ($inst == $file ? 'selected' : ''); ?>><?php echo $file ;?></option><?php
                                            }
                                        }
                                        closedir($handler);?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="etime" class="form-label">Fecha y hora de inicio (introducir en hora UTC)</label>
                                <input type="datetime-local" class="form-control" name="etime" id="etime" aria-describedby="etimeHelp" <?php if($id !=null){ echo "value='$updTime'";}else{echo "value='TZD'";}?>>
                                <div id="etimeHelp" class="form-text"><?php if($id ==null){ echo "Si presionas enter al abrir el calendario se introducirá automaticamente el momento actual.";}?></div>
                            </div>
                    </div>
                    <div class="row">
                            <div class="mb-3 col-8">
                                <label for="efin" class="form-label">Fecha y hora final (introducir en hora UTC)</label>
                                <input type="datetime-local" class="form-control" name="efin" id="efin" aria-describedby="efinHelp" <?php if($id !=null){ if(!is_null($updFin)){echo "value='$updFin'";}else{echo "disabled";}}else{echo "disabled";}?>>
                                <div id="efinHelp" class="form-text"><?php if($id ==null){ echo "Si presionas enter al abrir el calendario se introducirá automaticamente el momento actual.";}?></div>
                            </div>
                            <div class="mt-5 col-4">    
                                <input class="form-check-input" type="checkbox" name="nofin" id="nofin" value="nofin" value="true"
                                <?php if($id !=null){ if(!is_null($updFin)){}else{echo "checked ";}}else{echo "checked ";}?>onclick="document.getElementById('efin').disabled=this.checked;document.getElementById('efin').value='';">
                                <label class="form-check-label" for="nofin">Por determinar</label>
                            </div>
                    
                    </div>
                    <button type="submit" class="btn btn-primary"><?php echo ($id==null ? 'Añadir' : 'Editar');?></button>
                    <a class="btn btn-secondary " href="index.php" >Volver</a>    
                    </form>
                </div>
        
        
        
        <script src="js/popper.min.js"></script>
        

    </body>
</html>
<?php
    
    
    if(!empty(filter_input_array(INPUT_POST))){
        $descError= null;
        $tipoError = null;
        $instError = null;
        $dateError = null;
        
        $desc = filter_input(INPUT_POST, "edesc");
        $tipo = filter_input(INPUT_POST, "etipo");
        $instrument = filter_input(INPUT_POST, "einst");
        $date = filter_input(INPUT_POST, "etime");
        $id = filter_input(INPUT_POST, "id");
        $fin = filter_input(INPUT_POST, "efin");
        $nofin = filter_input(INPUT_POST, "nofin");
        
        $valid = true;
    
    
        if (empty($desc)) {
                $descError = 'Por favor, introduce una descripcion';
                echo "<div class='container'><p class='alert alert-danger'>$descError</p></div>";
                $valid = false;
            }

            if ($tipo == "0") {
                $tipoError = 'Por favor, escoge un tipo de evento';
                echo "<div class='container'><p class='alert alert-danger'>$tipoError</p></div>";
                $valid = false;
            }

            if ($instrument == "selec") {
                $instError = 'Por favor, selecciona un instrumento';
                echo "<div class='container'><p class='alert alert-danger'>$instError</p></div>";
                $valid = false;
            }

            if (empty($date)) {
                $dateError = 'Por favor, introduce una fecha y hora';
                echo "<div class='container'><p class='alert alert-danger'>$dateError</p></div>";
                $valid = false;
            }

            if (!$nofin && empty($fin)) {
                $finError = 'Por favor, introduce una fecha y hora para el campo fin, o marca la casilla "Por determinar" ';
                echo "<div class='container'><p class='alert alert-danger'>$finError</p></div>";
                $valid = false;
            }
            
            if($valid){
                if($id==null){
                    $format_date = date_create($date);
                    $good_date = date_format($format_date, 'Y-m-d H:i:s');
                    

                    if($nofin){
                        $good_fin = "NULL";
                    }else{
                        $format_fin = date_create($fin);
                        $good_fin = date_format($format_fin, 'Y-m-d H:i:s');
                    }
                    
                    insertarEvento($desc, $tipo, $good_date, $good_fin, $instrument);
                    echo "<div class='container'><p class='alert alert-success'>Evento añadido. Puedes seguir añadiendo, o volver.</p></div>";
                    //header("Location: index.php");
                }
                else{
                    $format_date = date_create($date);
                    $good_date = date_format($format_date, 'Y-m-d H:i:s');

                    if($nofin){
                        $good_fin = "NULL";
                    }else{
                        $format_fin = date_create($fin);
                        $good_fin = date_format($format_fin, 'Y-m-d H:i:s');
                    };

                    ActualizarEvento($id, $desc, $tipo, $good_date, $good_fin, $instrument);
                    $pafuera=true;
                    //header("Location: index.php");
                    ?><script language="javascript">window.location.href="index.php";</script><?php
                    die();
                    //echo "<div class='container'><p class='alert alert-success'>$dateError</p></div>"
                }
            }
    }
?>

