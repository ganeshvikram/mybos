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
    	$this->getNodeInput();
    	$this->prepareDirectionBasisCsvInput();
    }



    private function getNodeInput(){
    	$this->varInput = readline("Input :");

    	if(strtolower($this->varInput)=='quit'){
    		echo 'Ending script...';
    		exit;
    	}elseif(count(explode(' ',$this->varInput))!=3){
    		echo 'Input error... Synrax: "[from] [to] [latency]", type "QUIT" to terminate the script'."\n";
    		$this->getNodeInput();
    	}

    	
    }

    private function prepareDirectionBasisCsvInput(){
    	$varTempArray = explode(' ',$this->varInput);
    	$varDirection = 0;
    	$this->arrFormatedCSVinputByDirection = [];

    	if(strtoupper($varTempArray[0]) > strtoupper($varTempArray[1])){
    			$varDirection = 1;
    	}



    	foreach($this->arrCSVContent as $v)	{
			if($varDirection==1){
				$this->arrFormatedCSVinputByDirection[$v[1]][$v[0]]=$v[2];
			}else{
				$this->arrFormatedCSVinputByDirection[$v[0]][$v[1]]=$v[2];
			}
			
		}

		print_r($this->arrFormatedCSVinputByDirection);
    }


}

$varFindpath = new Findpath();
$varFindpath->getCsvfile();


exit;
?>