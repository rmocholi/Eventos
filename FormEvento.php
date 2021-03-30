<!DOCTYPE html>
<?php 
    include 'Funks.php';
    if (!empty(filter_input(INPUT_GET, "id"))) {
        $id = filter_input(INPUT_GET, "id");
        $ev = adquireEv2Update($id);
        $updTime = $ev->getTimestamp();
        $updformat_date = date_create($updTime);
        $updTime = date_format($updformat_date, 'Y-m-d\TH:i');
        
    }else{
        $id = null;
        $typ = 0;
    }
?>
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
                                        }
                                    ?>
                                    <option value="0" <?php echo ($typ == 0 ? 'selected' : ''); ?>>Selecciona un tipo</option>
                                    <option value="1" <?php echo ($typ == 1 ? 'selected' : ''); ?>>Equipo al Agua</option>
                                    <option value="2" <?php echo ($typ == 2 ? 'selected' : ''); ?>>Equipo a bordo</option>
                                    <option value="3" <?php echo ($typ == 3 ? 'selected' : ''); ?>>Inicio de Linea</option>
                                    <option value="4" <?php echo ($typ == 4 ? 'selected' : ''); ?>>Fin de Linea</option>
                                    <option value="5" <?php echo ($typ == 5 ? 'selected' : ''); ?>>Estación</option>
                                    <option value="6" <?php echo ($typ == 6 ? 'selected' : ''); ?>>Incidencia</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="etime" class="form-label">Fecha y hora</label>
                                <input type="datetime-local" class="form-control" name="etime" id="etime" aria-describedby="etimeHelp" <?php if($id !=null){ echo "value='$updTime'";}?>>
                                <div id="etimeHelp" class="form-text"><?php if($id ==null){ echo "Si presionas enter al abrir el calendario se introducirá automaticamente el momento actual.";}?></div>
                            </div>
                            <button type="submit" class="btn btn-primary"><?php echo ($id==null ? 'Añadir' : 'Editar');?></button>
                            <a class="btn btn-secondary " href="index.php" >Volver</a>
                        </form>
                    </div>
                </div>
        
        
        
        <script src="js/popper.min.js"></script>
        

    </body>
</html>

<?php
    
    
    if(!empty(filter_input_array(INPUT_POST))){
        $descError= null;
        $tipoError = null;
        $dateError = null;
        
        $desc = filter_input(INPUT_POST, "edesc");
        $tipo = filter_input(INPUT_POST, "etipo");
        $date = filter_input(INPUT_POST, "etime");
        $id = filter_input(INPUT_POST, "id");
        
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

            if (empty($date)) {
                $dateError = 'Por favor, introduce una fecha y hora';
                echo "<div class='container'><p class='alert alert-danger'>$dateError</p></div>";
                $valid = false;
            }
            
            if($valid){
                if($id==null){
                    $format_date = date_create($date);
                    $good_date = date_format($format_date, 'Y-m-d H:i:s');
                    insertarEvento($desc, $tipo, $good_date);
                    header("Location: index.php");
                }
                else{
                    $format_date = date_create($date);
                    $good_date = date_format($format_date, 'Y-m-d H:i:s');
                    ActualizarEvento($id, $desc, $tipo, $good_date);
                    header("Location: index.php");
                }
            }
    }

?>

