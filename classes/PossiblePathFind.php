<?php
class PossiblePathFind {

	Public function PathAlgorithm($varFromNode,$varToNode,$varLatency,$varPathArray){
		 /**
		 *
		 * Process to find path exists or not in given latency
		 *
		 * @param      $varFromNode Starting node
		 * @param      $varToNode Ending node
		 * @param      $varLatency Latency time
		 * @param      $varPathArray Source array
		 * @return     path exists retrn array otherwise return empty
		 *
		 */

			  $arrStatingpoints 		= array_keys($varPathArray);
				$varMaxCount = count(max($varPathArray));
				$varFindpPth = false;
				for($j=0;$j<$varMaxCount;$j++){
					$arrResult =array();

					if(strpos(json_encode($varPathArray), $varFromNode)>0 && strpos(json_encode($varPathArray), $varToNode)>0){
						
			    array_push($arrResult, $varFromNode);
					$varTime= 0;
					$varFindpPth= false;
					for($i= array_search($varFromNode,array_keys($varPathArray)); $i < count($varPathArray); ++$i) {
							if(isset(array_keys($varPathArray[$arrStatingpoints[$i]])[$j])){

								array_push($arrResult, array_keys($varPathArray[$arrStatingpoints[$i]])[$j]);
								$varTime= $varTime+$varPathArray[$arrStatingpoints[$i]][array_keys($varPathArray[$arrStatingpoints[$i]])[$j]];

							}else{

								array_push($arrResult, array_keys($varPathArray[$arrStatingpoints[$i]])[count(array_keys($varPathArray[$arrStatingpoints[$i]]))-1]);
								$varTime= $varTime+$varPathArray[$arrStatingpoints[$i]][array_keys($varPathArray[$arrStatingpoints[$i]])[count(array_keys($varPathArray[$arrStatingpoints[$i]]))-1]];

							}
						

						if(end($arrResult) == $varToNode && $varTime<= $varLatency){
								$varFindpPth= true;
								array_push($arrResult, $varTime);
								break 2;
						}

					}

				}
			}

				return ($varFindpPth)?$arrResult:'';

    }
}
?>