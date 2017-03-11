<?php
if(!defined('BASEPATH'))exit('No direct script access allowed');
class Excel extends CI_Controller{
	
	public function __construct(){
	parent::__construct();
		$this->load->model('excel_model');
		$this->load->helper(array('form','url'));
		$this->load->helper('download');
		$this->load->library('PHPReport');
		if (!$this->aauth->is_allowed('uneb', $this->aauth->get_user_id())) {
            $msg['heading'] = 'Error: 403';
            $msg['message'] = 'You cannot view this page';
            echo "<h1>" . $msg['message'] . "</h1?";
            die();
        }
	}

	public function index(){
		//get from database
		$data=$this->excel_model->getdata();

		$template='Myexcel.xlsx';
		//set absolute path to directory with template files
		$templateDir = __DIR__ ."/..controllers/";

		//set config for report
		$config=array(
		'template'=>$template,
		'templateDir'=>$templateDir
		);

		//load template
		$R= new PHPReport($config);

		// $R->load(array(
		// 'id'=>'student',
		// 'repeat'=>TRUE,
		// 'data'=>$data)
		// );

		$R-> load(arrray('stud_reg_no' => 'A',
                'sch_reg_no' =>'B',
                'name' =>'C',
                'academic_year' =>'D',
                'repeat'=>TRUE,
		        'data'=>$data

                ));


		//define output directory
		$output_file_dir="/tmp/";

		$output_file_excel=$output_file_dir . "Myexcel.xlsx";
		//download excel sheet with data in /tmpp folder
		$result=$R->render('excel',$output_file_excel);
	}
}


