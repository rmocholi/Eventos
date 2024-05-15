<?php 
    include 'Funks.php';
    $codex = "ArcaDeLaVerdadIncorruptible/CodiceDelSaberSupremo.txt";            
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
                <p class="alert-secondary rounded-2 h1 text-center my-5"> Configurar lista de instrumentos</p>
            </div>      
        </div>


        <div class=" my-5  container justify-content-center">
            <div class="row mb-3">
                <h3 class="text-center">¿Qué instrumentos utilizarás en esta campaña?</h3>
            </div> 
            <div class="row h">
                <div class="overflow-scroll col-6">
                    <div class="list-group">
                        <?php
                            $ark = fopen($codex,"r");
                            while(! feof($ark)){
                                $linea = fgets($ark);
                                ?><a class="list-group-item-action list-group-item"><?php echo $linea ;?></a><?php
                            }
                            fclose($ark);
                        ?>
                    </div>
                
                </div>
                <div></div>
            </div>
                
                <div class="container">
                    <div class="row justify-content-center form-actions mt-5 mb-3 ">
                        <div class="col-4 " >
                            <button type="submit" class="btn btn-primary btn-lg" style="display:block; width: 100%; ">Listo</button>
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

    <?php ?>
