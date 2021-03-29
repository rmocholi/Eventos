<?php
    $id;
    include 'Funks.php';
    if ( !empty(filter_input(INPUT_GET, "id"))) {
        $id = filter_input(INPUT_GET, "id");
    }
     
    if ( !empty(filter_input(INPUT_POST, "id"))) {
        $id = filter_input(INPUT_POST, "id");
        borrarEvento($id);
        header("Location: index.php");
               
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
                    <div class="row ">
                            <h1 class="text-center">Borrar Evento</h1>
                    </div>
                    <?php
                    mostrarEvento($id)?>
                    <form class="form-horizontal" action="borrar.php" method="post">
                      <input type="hidden" name="id" value="<?php echo $id;?>"/>
                      <p class="alert alert-danger text-center">¿Seguro que quieres borrar este evento? El no lo haría.</p>
                      <div class="form-actions text-center">
                          <button type="submit" class="btn btn-danger btn-lg">Si</button>
                          <a class="btn btn-lg" href="index.php">No</a>
                      </div>
                    </form>
                </div>
                 
        </div>
    </body>
</html>



