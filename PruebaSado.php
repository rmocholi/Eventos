<?php

$string = "2021-04-08 20:25:14";
$hora = substr($string,11,2 );
$hora=$hora-4;
if(strlen($hora) == 1){$hora = "0".$hora-2;}

$intervalo = substr_replace($string, $hora,11,2);

echo $intervalo;

