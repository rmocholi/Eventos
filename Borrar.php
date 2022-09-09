<?php
    $id;
    include 'Funks.php';
    if ( !empty(filter_input(INPUT_GET, "id"))) {
        $id = filter_input(INPUT_GET, "id");
    }
     
    if ( !empty(filter_input(INPUT_POST, "id"))) {
        $id = filter_input(INPUT_POST, "id");
        if($id=='all'){
            borrarTodo();
            header("Location: index.php");
        }
        else{
            borrarEvento($id);
            header("Location: index.php"); 
        }
        
               
    }
?>



<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <script src="js/jquery-3.6.0.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <title>Borrar Evento</title>
    </head>
    <body>
        <div class="container">
     
                <div class="span10 offset1">
                    <?php if($id!='all'){ ?>
                        <div class="row ">
                            <h1 class="text-center">Borrar Evento</h1>
                        </div>
                        <?php
                        mostrarEvento($id)?>
                        <form class="form-horizontal" action="Borrar.php" method="post">
                          <input type="hidden" name="id" value="<?php echo $id;?>"/>
                          <p class="alert alert-danger text-center">¿Seguro que quieres borrar este evento? El no lo haría.</p>
                          <div class="form-actions text-center">
                              <button type="submit" class="btn btn-danger btn-lg">Si</button>
                              <a class="btn btn-lg" href="index.php">No</a>
                          </div>
                        </form>
                    <?php } else { ?>
                        <div class="row ">
                            <h1 class="text-center">BORRAR TODOS LOS EVENTOS</h1>
                        </div>
                        <form class="form-horizontal mt-5" action="Borrar.php" method="post">
                          <input type="hidden" name="id" value="<?php echo $id;?>"/>
                          <p class="alert alert-danger text-center h2">¿Seguro que quieres borrar TODOS los eventos?</p>
                          <h5 class="text-center">
                              <small class="text-muted">
                                  También se borraran del servidor los CSV exportados hasta ahora.<br> Utiliza esta opción solo al terminar una campaña, o al comenzarla si no se ha borrado antes.
                              </small>
                          </h5>
                          <div class="container">
                            <div class="row justify-content-around form-actions mt-5 ">
                                <div class="col-4 " >
                                  <button type="submit" class="btn btn-danger btn-lg" style="display:block; width: 100%; ">Si</button>
                                </div>
                                <div class="col-4" >
                                  <a class="btn btn-lg btn-secondary " href="index.php" style="display:block; width: 100%; ">No</a>
                                </div>
                            </div>
                          </div>
                        </form>
                    <?php } ?>
                    
                </div>
                 
        </div>
        <script src="js/popper.min.js"></script>
    </body>
</html>



