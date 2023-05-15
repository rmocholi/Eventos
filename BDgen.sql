/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Author:  Roger
 * Created: 06-abr-2021
 */

CREATE DATABASE eventos CHARACTER SET utf8mb4;
USE eventos;

CREATE TABLE `eventos` (
  `ID` smallint UNSIGNED NOT NULL,
  `Descripcion` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Tipo` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `Timestamp` datetime(6) NOT NULL,
  `Pos` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `Profundidad` float NOT NULL,
  `Temp_agua` float NOT NULL,
  `Sal` float NOT NULL,
  `Fluor` float NOT NULL,
  `Conductividad` float NOT NULL,
  `Temp_aire` float NOT NULL,
  `Humedad` float NOT NULL,
  `Pres_atmos` float NOT NULL,
  `Vel_med_viento` float NOT NULL,
  `Fecha_fin` datetime NULL,
  `Instrument`varchar(20) NULL
) ENGINE=Aria DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


ALTER TABLE `eventos`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `ID` (`ID`);


ALTER TABLE `eventos`
  MODIFY `ID` smallint UNSIGNED NOT NULL AUTO_INCREMENT;

