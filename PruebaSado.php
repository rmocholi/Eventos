<?php

include 'BDConn.php';

$sadoConn = new BDConn("sadodb", "sado", "sado", "SADO_SDG_RT");

$sadoConn->connect();

$datos = $sadoConn->getSadoLastPos();


echo $datos;

