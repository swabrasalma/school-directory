<?php
if(!defined('BASEPATH'))exit('No direct script access allowed');
class Export extends CI_Controller{
	
	public function __construct(){
		parent::__construct();
		$this->load->model('results_model');
        $this->load->model('students_model');
        $this->load->model('school_model');
        $this->load->library('excel');
        if (!$this->aauth->is_allowed('uneb', $this->aauth->get_user_id())) {
            $msg['heading'] = 'Error: 403';
            $msg['message'] = 'You cannot view this page';
            echo "<h1>" . $msg['message'] . "</h1?";
            die();
        }
	}

	public function index(){
		$yearData = $this->results_model->getAcademicYear();
        $allYears = [];

        foreach ($yearData as $value) {
            array_push($allYears, [$value => $value]);
        }

        $schoolData['schools'] = $this->school_model->getAllSchools();
        $schoolData['years'] = $this->results_model->array_flatten($allYears);

        if($_POST) {

            $school = $this->input->post('sch_reg_no', true);
            $type = $this->input->post('entry', true);
            $academicYear = $this->input->post('academic_year', true);

            $this->exportResults($school, $academicYear, $type);
        }

        $this->load->view('admin/pages/export_results', $schoolData);
	}

	 public function exportResults($sch_reg_no, $academicYear, $type) 
    {
        //load our new PHPExcel library
        $this->load->library('excel'); 
        //activate worksheet number 1
        $this->excel->setActiveSheetIndex(0);
        //name the worksheet
        $this->excel->getActiveSheet()->setTitle('Users list');

        $school = $this->school_model->with_students(['where' => ['academic_year' => $academicYear, 'entry' => $type]])->where(['sch_reg_no' => $sch_reg_no])->get();
        // read data to active sheet
        $this->excel->getActiveSheet()->SetCellValue('B1', 'School Name');
        $this->excel->getActiveSheet()->SetCellValue('C1', $school['name']);
        $this->excel->getActiveSheet()->SetCellValue('B2', 'District');
        $this->excel->getActiveSheet()->SetCellValue('C2', $school['district']);
        $this->excel->getActiveSheet()->SetCellValue('B3', 'Academic Year');
        $this->excel->getActiveSheet()->SetCellValue('C3', $academicYear);

        $this->excel->getActiveSheet()->SetCellValue('A4', 'Name');
        $this->excel->getActiveSheet()->SetCellValue('B4', 'Registration');
        $this->excel->getActiveSheet()->SetCellValue('C4', 'sex');
        $this->excel->getActiveSheet()->SetCellValue('D4', 'Total aggregate of eight');
        $letters = range('A','C');
        $letter = range('E','Z');
		$count = 5;
		$count2 = 5;
		$cell_name="";

		foreach($school['students'] as $key => $student)
		  {
		  	$a = $this->students_model->getStudentResult($student['stud_reg_no'], $academicYear);
		  	foreach ($a['subject'] as $key2 => $name) {
		  		$this->excel->getActiveSheet()->SetCellValue($letter[$key2]. "4", $name['subject']);
		  		if ($type == 1) {
		  			$this->excel->getActiveSheet()->SetCellValue($letter[$key2]. $count2, $name['aggregate']);
		  		} elseif ($type == 2) {
		  			$this->excel->getActiveSheet()->SetCellValue($letter[$key2]. $count2, $name['grade']);
		  		}
		  	}

		  	$this->excel->getActiveSheet()->SetCellValue('A'. $count, $student['name']);
		  	$this->excel->getActiveSheet()->SetCellValue('B'. $count, $student['stud_reg_no']);
		  	$this->excel->getActiveSheet()->SetCellValue('C'. $count, $student['sex']);
		  	if ($type == 1) {
		  		$this->excel->getActiveSheet()->SetCellValue('D'. $count, $a['finalGrade']);
		  	} elseif ($type == 2) {
		  		$this->excel->getActiveSheet()->SetCellValue('D'. $count, $a['finalPoints']);
		  	}

		  	$count++;
		  	$count2++;
		 }
 
        $filename= 'results_'.$school['name'].'.xls'; //save our workbook as this file name
 
        header('Content-Type: application/vnd.ms-excel'); //mime type
 
        header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
 
        header('Cache-Control: max-age=0'); //no cache
                    
        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
        //if you want to save it as .XLSX Excel 2007 format
 
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5'); 
 
        //force user to download the Excel file without writing it to server's HD
        $objWriter->save('php://output');
    }
}


