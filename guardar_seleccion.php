<?php
    // Obtener el array de selección enviado por AJAX
    $current = isset($_POST['current']) ? json_decode($_POST['current'], true) : [];

    // Escribir el array en el archivo 'Reduct.txt'
    $lilcodex = "ArcaDeLaVerdadIncorruptible/Reduct.txt";
    $reduct = fopen($lilcodex, 'w');
    if ($reduct) {
        foreach ($current as $line) {
            fwrite($reduct, $line . PHP_EOL);
        }
        fclose($reduct);
        echo "El contenido del array se ha escrito en el archivo correctamente.";
    } else {
        echo "No se pudo abrir el archivo para escritura.";
    }
?>