<?php

 /**
 *
 * Finding network travel path
 *
 * Author : ganeshvikram
 * Date : 0/09/2022
 *
 */

// Adding required classe
require_once('classes/helpers/ReadCsvFile.php');
require_once('classes/PossiblePathFind.php');
require_once('classes/Findpath.php');


//Main process caling
$varFindpath = new Findpath();
$varFindpath->findPathbylatency();

?>