<?php
if(!defined('BASEPATH')) exit('No direct script access');

class Excel{
	private $excel;

	public function __construct()
		require_once APPATH. $this->excel = new PHPExcel
}
	public function load($path){
		$objReader = PHPExcel_I
		$this->excel = $objRead
}
	public function save($path){
		$objWriter = PHPExcel_I 
		$objWriter->save($path)
	}
	public function stream($file)
		if($data !=null){
			$col = 'A';
			foreach ($data[0] as )
		}
?>