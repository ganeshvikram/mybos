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

class pathFind {

	Public function PathAlgorithm($varFromNode,$varToNode,$varLatency,$varPathArray){

			  $arrStatingpoints 		= array_keys($varPathArray);
				$varMaxCount = count(max($varPathArray));
				$varFindpPth = false;
				for($j=0;$j<$varMaxCount;$j++){
					$arrResult =array();
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

				return ($varFindpPth)?$arrResult:'';

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

    
    private function getNodeInput(){
    	$varEnterredInput = readline("Input : ");
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
					$this->arrFormatedCSVinputByDirection[strtoupper(trim($v[1]))][strtoupper(trim($v[0]))]=trim($v[2]);
				}else{
					$this->arrFormatedCSVinputByDirection[strtoupper(trim($v[0]))][strtoupper(trim($v[1]))]=trim($v[2]);
				}
				
			}

		($varDirection==1)?krsort($this->arrFormatedCSVinputByDirection):ksort($this->arrFormatedCSVinputByDirection);
	
    }

    protected function findPath(){
    	$this->getNodeInput();
    	$this->prepareDirectionBasisCsvInput();

    	$objPathfind = new pathFind();

    	$arrResultPath = $objPathfind->PathAlgorithm($this->varFromNode,$this->varTomNode,$this->varLatency,$this->arrFormatedCSVinputByDirection);

    	echo (!is_array($arrResultPath) || $arrResultPath=='')? "Output : Pathnot found\n": "Output : ".implode(' => ',$arrResultPath)."\n";
    	$this->findPath();

    } 

    public function findPathbylatency(){

    	$this->validateFileName($this->varCsvFilename);
    	$this->arrCSVContent = $this->readCsvFile($this->varCsvFilename);
    	$this->findPath();
    }


   


}

$varFindpath = new Findpath();
$varFindpath->findPathbylatency();



exit;
?>