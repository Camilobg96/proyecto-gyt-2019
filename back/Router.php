<?php
/*
              -------Creado por-------
             \(x.x )/ Anarchy \( x.x)/
              ------------------------
 */

//    Si crees que las mujeres son difíciles, no conoces Anarchy  \\
include_once realpath('Controller.php');

$ruta = strip_tags($_POST['ruta']);
    	$rtn = "";
    	switch ($ruta) {
        case 'listarTerceros':
    			$rtn = Controller::listarTerceros();
    			break;
        case 'listarMovimientos':
          $rtn = Controller::listarMovimientos();
          break;
        case 'carteraPorTercero':
          $rtn = Controller::carteraPorTercero();
          break;
        case 'buscarTercero':
          $rtn = Controller::buscarTercero();
          break;
        case 'insertarPedido':
          $rtn = Controller::insertarPedido();
          break;    
    		default:
    			$rtn="404 Ruta no encontrada.";
    			break;
    	}

echo $rtn;

//That's all folks!