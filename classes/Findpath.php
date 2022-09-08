<?php
class Findpath extends ReadCsvFile{

    private $varCsvFilename;
    private $varInput;
    private $arrCSVContent;
    private $arrFormatedCSVinputByDirection;
    private $varFromNode;
    private $varTomNode;
    private $varLatency;

    function __construct() {
    	/**
		 *
		 * validate file name having .csv at end or not
		 *
		 */
			if(count($_SERVER['argv'])!=2){
				echo "Error : Provide csv filename as first arguement & only one arguement is allowed.";
				exit;

			} 
			$this->varCsvFilename = $_SERVER['argv'][1];
    }

    
    private function getNodeInput(){
    	 /**
		 *
		 * Getting Input from user and valitating input format
		 *
		 *
		 */
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
    	 /**
		 *
		 * prepare source from csv input based on forward or reverse travel
		 *
		 */
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
    	/**
		 *
		 * Getting user input , prepare sourse based on direction and finding path
		 *
		 */
    	$this->getNodeInput();
    	$this->prepareDirectionBasisCsvInput();

    	$objPathfind = new PossiblePathFind();

    	$arrResultPath = $objPathfind->PathAlgorithm($this->varFromNode,$this->varTomNode,$this->varLatency,$this->arrFormatedCSVinputByDirection);

    	echo (!is_array($arrResultPath) || $arrResultPath=='')? "Output : Pathnot found\n": "Output : ".implode(' => ',$arrResultPath)."\n";
    	$this->findPath();

    } 

    public function findPathbylatency(){
    	/**
		 *
		 * Get data from CSV and calling findpath
		 *
		 */

    	$this->validateFileName($this->varCsvFilename);
    	$this->arrCSVContent = $this->readCsvFile($this->varCsvFilename);
    	$this->findPath();
    }
}
?>