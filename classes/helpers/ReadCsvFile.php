<?php
class ReadCsvFile {

	public function validateFileName($filename){
		/**
		 *
		 * check file name contains .csv at end or not
		 *
		 * @param      $filename sourse csv file name
		 */
		
		if (!preg_match('/\.csv$/', $filename)) {
		    echo "Error : Given file not csv";
		    exit;
		}
	}

	public function readCsvFile($filename){
		/**
		 *
		 * convert csv data into array
		 *
		 * @param      $filename sourse csv file name
		 * @return     array
		 */
		return array_map('str_getcsv', file($filename));
	}
}
?>