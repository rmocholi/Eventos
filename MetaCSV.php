<?php 
    include 'Funks.php';

    $fileDesc = "MetaCSV";
             
    $filename = "Eventos-$fileDesc.csv";
    $filepath = "Exports/$filename";
    $opt = array("timestamp","fin","instrument","desc");
    $eventos = leerEventos();
    $archivo = fopen($filepath, 'w');
    $delim=",";
    fputcsv($archivo, $opt,$delim);
    foreach ($eventos as $e) {
        $linea=array();
        array_push($linea,$e->getTimestamp());
        array_push($linea,$e->getFin());   
        array_push($linea,$e->getInstrument());   
        array_push($linea,$e->getDesc());             
        fputcsv($archivo, $linea,$delim);
    }
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="'.$filename.'";');
    readfile($filepath);
    exit();
    header("Location: MetaCSV.php");
            
?>