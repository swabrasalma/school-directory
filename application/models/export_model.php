<?php
class Excel_model extends CI_Model{
	
	public function __construct(){
	parent::__construct();

	$this->db=$this->load->database('default',TRUE,TRUE);
	}

	puublic function getdata(){
	$this->db->select('*');
	$querry=$this->db->get('student');
	return $query->result_array();
	}
}

?>