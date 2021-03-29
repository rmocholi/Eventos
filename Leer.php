
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <script src="js/jquery-3.6.0.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <title>Información</title>
    </head>
    <body>
        <div class="container my-5">
            <?php
            include 'Funks.php';
            $id = filter_input(INPUT_GET, "id");
            mostrarEvento($id);
            ?>
            <div class="row">
                <a class="btn btn-secondary" href="index.php"><h4 class="display-6">Volver</h4></a>
            </div>
        </div>   
    </body>
</html>




