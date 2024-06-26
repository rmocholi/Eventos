<?php 
include 'Funks.php';

$codex = "ArcaDeLaVerdadIncorruptible/CodiceDelSaberSupremo.txt";
$lilcodex = "ArcaDeLaVerdadIncorruptible/Reduct.txt";
$current = file($lilcodex, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

function escribirEnArchivo($array, $lilcodex) {
    if ($reduct = fopen($lilcodex, 'w')) {
        foreach ($array as $line) {
            if (fwrite($reduct, $line . PHP_EOL) === false) {
                fclose($reduct);
                return "Error al escribir en el archivo.";
            }
        }
        fclose($reduct);
        return "El contenido del array se ha escrito en el archivo correctamente.";
    }
    return "No se pudo abrir el archivo.";
}

$mensaje = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['writeToFile'])) {
    $current = isset($_POST['current']) ? json_decode($_POST['current'], true) : [];
    if (!is_array($current)) {
        $current = [];
    }
    $mensaje = escribirEnArchivo($current, $lilcodex);
    echo $mensaje;
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script defer src="fontawesome/solid.min.js"></script>
    <script defer src="fontawesome/fontawesome.min.js"></script>
    <script src="js/jquery-3.6.0.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <title>Instrumentación</title>
</head>
<body>
    <div class="container my-5">
        <div class="row">
            <p class="alert-secondary rounded-2 h1 text-center my-5">Configurar lista de instrumentos</p>
        </div>
    </div>


    <div class="my-5 container justify-content-around">
        <div class="row mb-3">
            <h3 class="text-center">¿Qué instrumentos utilizarás en esta campaña?</h3>
        </div>
        
        <div class="row d-flex justify-content-around">
            <div class="d-flex col-4">
                <input type="text" id="searchInput" class="form-control mb-3" placeholder="Buscar instrumento...">
            </div>
            <div class="col-4 d-flex justify-content-between">
                        <h4 class="col-2">Selección</h4>
                        <button class=" col-2 btn btn-secondary btn-sm " style="height: 5vh;" onclick="vaciarSeleccion()"> Vaciar</button>
            </div>

        </div>

        <div class="row d-flex justify-content-around">
        <div class="col-4">
                <div class="overflow-auto border rounded" style="height:15rem" id="codice">
                    <div class="list-group" id="codiceGroup">
                        <?php
                        $ark = fopen($codex, "r");
                        while (($linea = fgets($ark)) !== false) {
                            echo '<a class="list-group-item-action list-group-item" onclick="seleccionarInstrumento(this)">' . htmlspecialchars($linea) . '</a>';
                        }
                        fclose($ark);
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-4">                
                    <div class="overflow-auto border rounded" style="height:15rem" id="selekta">
                        <div class="list-group" id="selektaGroup">
                            <?php
                            foreach ($current as $seleks) {
                                echo '<a class="list-group-item list-group-item-action d-flex justify-content-between">' . htmlspecialchars($seleks) . 
                                '<button class="btn btn-sm" onclick="eliminarElemento(' . array_search($seleks, $current) . ')"><i class="fa-solid fa-close"></i></button></a>';
                            }
                            ?>
                        </div>
                    </div>
            </div>           
        </div>           
    </div>




    <script>
        var current = <?php echo json_encode($current); ?>;

        document.getElementById('searchInput').addEventListener('input', function() {
            var filter = this.value.toLowerCase();
            var nodes = document.getElementById('codiceGroup').getElementsByTagName('a');

            Array.prototype.forEach.call(nodes, function(node) {
                if (node.textContent.toLowerCase().indexOf(filter) > -1) {
                    node.style.display = '';
                } else {
                    node.style.display = 'none';
                }
            });
        });

        function vaciarSeleccion() {
            current.length = 0;
            actualizarListaSeleccionados();
            
        }

        function seleccionarInstrumento(elemento) {
            var textoElemento = elemento.textContent.trim();
            if (!current.includes(textoElemento)) {
                current.push(textoElemento);
                actualizarListaSeleccionados();
                console.log('Elemento seleccionado: ' + textoElemento);
            }
        }

        function eliminarElemento(indice) {
            current.splice(indice, 1);
            actualizarListaSeleccionados();
        }

        function guardarSeleccion() {
            var xhr = new XMLHttpRequest();
            xhr.open('POST', '', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                    if (xhr.responseText.trim() === "El contenido del array se ha escrito en el archivo correctamente.") {
                        window.location.href = 'index.php';
                    } else {
                        console.error(xhr.responseText + ' Ha habido un error, contacta con tu administrador');
                    }
                } else if (xhr.readyState === XMLHttpRequest.DONE) {
                    console.error('Error en la solicitud AJAX');
                }
            };
            xhr.send('writeToFile=1&current=' + encodeURIComponent(JSON.stringify(current)));
        }

        function actualizarListaSeleccionados() {
            var listaSeleccionados = document.getElementById('selektaGroup');
            listaSeleccionados.innerHTML = '';
            current.forEach(function(elemento, indice) {
                var nuevoElemento = document.createElement('a');
                nuevoElemento.classList.add('list-group-item', 'list-group-item-action', 'd-flex', 'justify-content-between');
                nuevoElemento.textContent = elemento;

                var botonEliminar = document.createElement('button');
                botonEliminar.classList.add('btn', 'btn-sm');
                botonEliminar.onclick = function() {
                    eliminarElemento(indice);
                };

                var cruz = document.createElement('i');
                cruz.classList.add('fa-solid', 'fa-close');
                botonEliminar.appendChild(cruz);
                nuevoElemento.appendChild(botonEliminar);
                listaSeleccionados.appendChild(nuevoElemento);
            });
        }

        actualizarListaSeleccionados();
    </script>

    <div class="container">
        <div class="row justify-content-center form-actions mt-5 mb-3">
            <div class="col-4">
                <button type="button" name="writeToFile" onclick="guardarSeleccion()" class="btn btn-primary btn-lg" style="display:block; width: 100%;">Listo</button>
            </div>
            <div class="col-4">
                <a class="btn btn-lg btn-secondary" href="index.php" style="display:block; width: 100%;">Volver</a>
            </div>
        </div>
    </div>
</body>
</html>