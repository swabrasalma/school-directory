<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Courses extends Ci_controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function __construct(){  
        parent::__construct();
        $this->load->model('course_model');
        if (!$this->aauth->is_allowed('university', $this->aauth->get_user_id())) {
            $msg['heading'] = 'Error: 403';
            $msg['message'] = 'You cannot view this page';
            echo "<h1>" . $msg['message'] . "</h1?";
            die();
        }
        // $this->load->model('school_model');

    }

    /**
     * index page:: loads the view for the index
     * @return void
     */
    public function index()
    {
        
        $this->load->view('admin/pages/upload_courses');
    }

    /**
     * Uploads execl file to directory and perfoms the insert to the database
     * @return void
     */
    public function do_upload()
    {
            $config['upload_path']          = './files/'; //directory path
            $config['allowed_types']        = '|xlsx|'; //allowed paths

            $this->load->library('upload', $config);

            if ( ! $this->upload->do_upload('userfile'))
            {
                // set error flashdata
                $this->session->set_flashdata(
                    'error',
                    $this->upload->display_errors()
                );

                redirect('/dashboard/upload');
            }
            else
            {  
                $excelFile = $this->upload->data('file_name');
                $this->getExcelData($excelFile);
                //$this->load->view('upload_success');
                $this->load->view('admin/pages/success');
            }
    }

    /**
     * Reads from the excel and inserts to the database
     * @return void
     */
    protected function getExcelData($excelFile){
        $file = './files/'. $excelFile;
        //load the excel library
        $this->load->library('excel');
        //read file from path
        $objPHPExcel = PHPExcel_IOFactory::load($file);
        //get only the Cell Collection
        $cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();
        //extract to a PHP readable array format
        foreach ($cell_collection as $key => $cell) {

            $column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
            $row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
            $data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();

          

            if ($row > 0) {
                $courseValues[$row][$column] = $data_value;
            }
        }
         
        // $schoolData = array_values($schoolDetails);
        // $data = [
        //     'name' => $schoolData[0],
        //     'sch_reg_no' => $schoolData[1],
        //     'district' => $schoolData[2],
        //     'academic_year' => $schoolData[3],
        //     'subject' => $schoolData[4],
        //     'paper' => $schoolData[5],
        //     'paperCode' => $schoolData[6],
        //     'results_type' => 1
        // ];

        $courseData = array_values($courseValues);
        $finalDetails = [];

        foreach ($courseData as $details) {
            array_push($finalDetails, [
                'id' => $details['A'],
                'course_code' =>  $details['B'],
                'course_name' =>  $details['C'],
                'cut_off_points'=>$details['D'],
                'max_student_no' => $details['E'],
                
            ]);
        }

        foreach ($finalDetails as $courseDetails) {
            $this->course_model->insert($courseDetails);
        }

    }
}
