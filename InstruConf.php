<?php 
    include 'Funks.php';
    $codex = "ArcaDeLaVerdadIncorruptible/CodiceDelSaberSupremo.txt";
    $lilcodex = "ArcaDeLaVerdadIncorruptible/Reduct.txt";
    $current = [];

    $lilcoread = fopen($lilcodex, "r");
    while (($linea = fgets($lilcoread)) !== false) {
        $current[trim($linea)] = trim($linea);
    }
    fclose($lilcoread);
    $current = file($lilcodex, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    function escribirEnArchivo($array, $lilcodex) {
        $reduct = fopen($lilcodex, 'w');
        if ($reduct) {
            foreach ($array as $line) {
                if (fwrite($reduct, $line . PHP_EOL) === false) {
                    fclose($reduct);
                    return "Error al escribir en el archivo.";
                }
            }
            fclose($reduct);
            return "El contenido del array se ha escrito en el archivo correctamente.";
        } else {
            return "No se pudo abrir el archivo.";
        }
    }

    $mensaje = '';
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['writeToFile'])) {
        $current = isset($_POST['current']) ? explode("\n", trim($_POST['current'])) : [];
        if (!is_array($current)) {
            // Si $current no es un array válido, reasignar como un array vacío
            $current = [];
        $mensaje = escribirEnArchivo($current, $lilcodex);
        }
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
        <title>Exportar CSV</title>
    </head>
    <body>
        <div class="container my-5">
            <div class="row">
                <p class="alert-secondary rounded-2 h1 text-center my-5"> Configurar lista de instrumentos</p>
            </div>
        </div>

        <div class="my-5 container justify-content-center">
            <div class="row mb-3">
                <h3 class="text-center">¿Qué instrumentos utilizarás en esta campaña?</h3>
            </div>
            <div class="container d-flex justify-content-around">
                <div class="overflow-auto col-4" style="height:15rem" id="codice">
                    <div class="list-group">
                        <?php
                            $ark = fopen($codex, "r");
                            while (!feof($ark)) {
                                $linea = fgets($ark);
                                if ($linea !== false) {
                                    ?><a class="list-group-item-action list-group-item" onclick="seleccionarInstrumento(this)"><?php echo $linea; ?></a><?php
                                }
                            }
                            fclose($ark);
                        ?>
                    </div>
                </div>
                <div class="overflow-auto col-4" style="height:15rem" id="selekta">
                    <div class="list-group" id="selektaGroup">
                        <?php
                            foreach ($current as $seleks) {
                                ?><a class="list-group-item list-group-item-action d-flex justify-content-between">
                                    <?php echo $seleks; ?>
                                    <button class="btn btn-sm" onclick="eliminarElemento(<?php echo array_search($seleks, $current); ?>)"><i class="fa-solid fa-close"></i></button>
                                </a><?php
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <script>
            var current = <?php echo json_encode($current); ?>;

            function seleccionarInstrumento(elemento) {
                var textoElemento = elemento.textContent.trim();

                if (current.includes(textoElemento)) {
                    return;
                } else {
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
                xhr.open('POST', 'guardar_seleccion.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === XMLHttpRequest.DONE) {
                        if (xhr.status === 200) {
                            // Verificar la respuesta del servidor
                            if (xhr.responseText.trim() === "El contenido del array se ha escrito en el archivo correctamente.") {
                                // Redireccionar al usuario a index.php
                                window.location.href = 'index.php';
                            } else {
                                // Si hay un error, imprimir el mensaje de error
                                console.error(xhr.responseText+'Ha habido un error, contacta con tu administrador');
                            }
                        } else {
                            console.error('Error en la solicitud AJAX');
                        }
                    }
                };
            var currentData = 'current=' + encodeURIComponent(JSON.stringify(current));
            xhr.send(currentData);
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
                        <button type="submit" name="writeToFile" onclick="guardarSeleccion()" class="btn btn-primary btn-lg" style="display:block; width: 100%;">Listo</button>
                    </div>
                    <div class="col-4">
                        <a class="btn btn-lg btn-secondary" href="index.php" style="display:block; width: 100%;">Volver</a>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>