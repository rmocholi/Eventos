<!DOCTYPE html>
<?php 
    include'Funks.php';
?>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <script src="js/jquery-3.6.0.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <title>Eventos</title>
    </head>
    <body>
        <div class="container my-5 ">
            <div class="row ">
                <h1 class="text-center display-3">EVENTOS</h1>
            </div>
            <div class="row">
                <table class="table  table-dark table-hover">
                    <tr>
                        <th>ID</th>
                        <th>Descripción</th>
                        <th>Tipo</th>
                        <th>Instrumento</th>
                        <th>Fecha inicio</th>
                        <th>Fecha fin</th>
                        <th>Posición</th>
                        <th>Acciones</th>
                    </tr>
                    <?php 
                        $eventos = leerEventos();
                        foreach ($eventos as $event) {
                            $id=$event->getID();
                            $desc=$event->getDesc();
                            $tipo=$event->getTipo();
                            $date=$event->getTimestamp();
                            $fin=$event->getFin();
                            $pos=$event->getPos();
                            $inst=$event->getInstrument();
                            echo "<tr>";
                                echo "<td>$id</td>";
                                echo "<td>$desc</td>";
                                echo "<td>$tipo</td>";
                                echo "<td>$inst</td>";
                                echo "<td>$date</td>";
                                echo "<td>$fin</td>";
                                echo "<td>$pos</td>";
                                echo "<td class='py-1'>"
                                    . "<a class='p-1 btn btn-secondary ' href='Leer.php?id=$id'>Leer</a>"
                                    . "<a class='p-1 btn btn-light ' href='FormEvento.php?id=$id'>Editar</a>"
                                    . "<a class='p-1 btn btn-danger' href='Borrar.php?id=$id'>Borrar</a>"
                                . "</td>";
                            echo "</tr>";                        
                        }
                    ?>
                </table>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-6 " >
                        <a class=" btn btn-success" href="FormEvento.php" style="display:block; width: 100%; ">Añadir Evento</a>
                    </div>
                    <div class="col-6">
                        <a class="btn btn-danger" href="Borrar.php?id=all"style="display:block; width: 100%; ">BORRAR TODO</a>
                    </div>
                    <div class="col-12 mt-1">
                        <a class="btn btn-secondary" href="ExportCSV.php"style="display:block; width: 100%; ">Exportar CSV</a>
                    </div>
                    
                </div>
            </div>
        </div>
               
        
        
        
        <script src="js/popper.min.js"></script>
    </body>
</html>
