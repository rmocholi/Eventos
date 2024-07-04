<?php 
include 'Funks.php';

$fileDesc = "MetaCSV";
$filename = "Eventos-$fileDesc.csv";
$filepath = "Exports/$filename";
$eventos = leerEventos();

// Asegúrate de que el directorio Exports existe
if (!file_exists('Exports')) {
    mkdir('Exports', 0777, true);
}

$archivo = fopen($filepath, 'w');
$delim = ",";

foreach ($eventos as $e) {

    
    $linea = array();
    // Sanitiza los datos para evitar caracteres no deseados
    $lat = trim($e->getLat());
    $long = trim($e->getLong());
    $timestamp = trim($e->getTimestamp());
    $fin = trim($e->getFin());
    $instrument = trim($e->getInstrument());
    $desc = trim($e->getDesc());
    
    array_push($linea, $long);
    array_push($linea, $lat);
    array_push($linea, $timestamp);
    array_push($linea, $fin);
    array_push($linea, $instrument);
    array_push($linea, $desc);
    
    $linea_csv = implode($delim, $linea) . "\n";
    fwrite($archivo, $linea_csv);
}

fclose($archivo);

// Asegúrate de que no haya salida antes de los headers
ob_clean();
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="' . $filename . '";');
readfile($filepath);
exit();

header("Location: MetaCSV.php");
?>