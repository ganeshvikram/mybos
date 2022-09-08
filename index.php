<?php

class ReadCsvGile {

	public function validateFileName($filename){
		if (!preg_match('/\.csv$/', $filename)) {
		    echo "Error : Given file not csv";
		    exit;
		}
	}

	public function readCsvFile($filename){
		return array_map('str_getcsv', file($filename));
	}
}


class Findpath extends ReadCsvGile{

    private $varCsvFilename;
    private $varInput;
    private $arrCSVContent;
    private $arrFormatedCSVinputByDirection;
    private $varFromNode;
    private $varTomNode;
    private $varLatency;

    function __construct() {
		if(count($_SERVER['argv'])!=2){
			echo "Error : Provide csv filename as first arguement & only one arguement is allowed.";
			exit;

		} 
		$this->varCsvFilename = $_SERVER['argv'][1];
    }

     function getCsvfile(){


    	$this->validateFileName($this->varCsvFilename);
    	$this->arrCSVContent = $this->readCsvFile($this->varCsvFilename);
    	$this->findPath();
    }

    private function findPath(){
    	$this->getNodeInput();
    	$this->prepareDirectionBasisCsvInput();
    	exit;
    	$this->PathAlgorithm();

    } 



    private function getNodeInput(){
    	$varEnterredInput = readline("Input :");
    	$varEnterredInput = trim($varEnterredInput);


    	if(strtolower($varEnterredInput)=='quit'){
    		echo 'Ending script...';
    		exit;
    	}elseif(count(explode(' ',$varEnterredInput))!=3){
    		echo 'Input error... Synrax: "[from] [to] [latency]", type "QUIT" to terminate the script'."\n";
    		$this->getNodeInput();
    	}

    	$arrEnterredInput = explode(' ',$varEnterredInput);

    	$this->varFromNode = strtoupper($arrEnterredInput[0]);
    	$this->varTomNode = strtoupper($arrEnterredInput[1]);
    	$this->varLatency = $arrEnterredInput[2];

    	
    }

    private function prepareDirectionBasisCsvInput(){
    	$varDirection = 0;
    	$this->arrFormatedCSVinputByDirection = [];

    	if($this->varFromNode > $this->varTomNode){
    			$varDirection = 1;
    	}



    	foreach($this->arrCSVContent as $v)	{
				if($varDirection==1){
					$this->arrFormatedCSVinputByDirection[$v[1]][$v[0]]=strtoupper($v[2]);
				}else{
					$this->arrFormatedCSVinputByDirection[$v[0]][$v[1]]=strtoupper($v[2]);
				}
				
			}

		($direction==1)?krsort($arrFormatedCSVinputByDirection):ksort($arrFormatedCSVinputByDirection);
	

		print_r($this->arrFormatedCSVinputByDirection);
    }

    function PathAlgorithm($varFromNode,$varToNode,$varLatency,$varPathArray){

			  $arrStatingpoints 		= array_keys($varPathArray);
				$maxCount = count(max($varPathArray));
				
				for($j=0;$j<$maxCount;$j++){
					$resultArr =array();
			        array_push($resultArr, $varFromNode);
					
					$time = 0;
					$findpath = 0;
					for($i= array_search($varFromNode,array_keys($varPathArray)); $i < count($varPathArray); ++$i) {
						//if(array_pop($resultArr)==$arrStatingpoints[$i]){

							if(isset(array_keys($varPathArray[$arrStatingpoints[$i]])[$j])){

								//echo '======'.array_keys($varPathArray[$arrStatingpoints[$i]])[$j].'=======';
								//$resultArr[] = array_keys($varPathArray[$arrStatingpoints[$i]])[$j];
								array_push($resultArr, array_keys($varPathArray[$arrStatingpoints[$i]])[$j]);
								//print_r($resultArr);
								$time = $time+$varPathArray[$arrStatingpoints[$i]][array_keys($varPathArray[$arrStatingpoints[$i]])[$j]];

							
						    echo $arrStatingpoints[$i] . ' -- ' . array_keys($varPathArray[$arrStatingpoints[$i]])[$j].array_keys($varPathArray[$arrStatingpoints[$i]])[$j].'--'.$varPathArray[$arrStatingpoints[$i]][array_keys($varPathArray[$arrStatingpoints[$i]])[$j]] . "\n";
							}else{

								array_push($resultArr, array_keys($varPathArray[$arrStatingpoints[$i]])[count(array_keys($varPathArray[$arrStatingpoints[$i]]))-1]);
								$time = $time+$varPathArray[$arrStatingpoints[$i]][array_keys($varPathArray[$arrStatingpoints[$i]])[count(array_keys($varPathArray[$arrStatingpoints[$i]]))-1]];

								//echo $arrStatingpoints[$i] . ' -- ' . array_keys($varPathArray[$arrStatingpoints[$i]])[count(array_keys($varPathArray[$arrStatingpoints[$i]]))-1].'--'.$varPathArray[$arrStatingpoints[$i]][array_keys($varPathArray[$arrStatingpoints[$i]])[count(array_keys($varPathArray[$arrStatingpoints[$i]]))-1]] . "\n";

							}
						//}

							echo '===time==//='.$time."=====".end($resultArr);


						if(end($resultArr) == 'B' && $time < $varLatency){
								$findpath = 1;
								break 2;
						}

					}

				}

			    if($findpath==1){
			      print_r($resultArr);
			    }else{
			    	echo 'yyyyyy';
			    }

    }


}

$varFindpath = new Findpath();
$varFindpath->getCsvfile();



exit;
?>