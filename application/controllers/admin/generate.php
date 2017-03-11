<?php
if(!defined('BASEPATH'))exit('No direct script access');

class Export extends CI_Controller{
	funcyion Generate(){
		parent::__construct();
		$this->load->database();

		$this->load->helper('url');

	}

	function create(){
	$this->load->library('cezpdf');
	$this->cezpdf->ezText('PDF REPORT OF LOGIN TABLE',12,array('justification'=>'center'));
	$this->cezpdf->ezSetDY(-10);
		$i=1;
		$content="";
		$fname="";
		$query=$this->db->query('SELECT * FROM students');
		$num=query->num_fields();
		$farr=array();
		while($i<=$num){
			$test=$i;
			$value=$this->input->post($test);

			if($value !=''{
			fname."".$value;
			array_push($farr, $value);
			}
			$i++;
		}
		$fname=trim($fname);
		$fname=str_replace('',',',$fname);
		$this->db->select($fname);
		$querry=$this->db->get('students');
		$result=$query->result();

		foreach($farr as $j){
		$content=strtoupper($j)."\n\n";
		foreach($result as $res)
		$content= $content.$res->$j.'\n';
		}
		$this->cezpdf->ezText($content,10);
		$this->cezpdf->ezStream();
	}
}


?>