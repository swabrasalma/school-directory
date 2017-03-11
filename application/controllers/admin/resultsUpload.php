<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class resultsUpload extends Ci_controller {

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
        $this->load->model('results_model');
        $this->load->model('school_model');
        if (!$this->aauth->is_allowed('uneb', $this->aauth->get_user_id())) {
            $msg['heading'] = 'Error: 403';
            $msg['message'] = 'You cannot view this page';
            echo "<h1>" . $msg['message'] . "</h1?";
            die();
        }

    }

    /**
     * index page:: loads the view for the index
     * @return void
     */
    public function index()
    {
        
        $this->load->view('admin/pages/upload');
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

            if ($row > 0 &&  $row <= 7) {
                $schoolDetails[$row] = $data_value;
            }

            if ($row > 8) {
                $resultsValues[$row][$column] = $data_value;
            }
        }
         
        $schoolData = array_values($schoolDetails);
        $data = [
            'name' => $schoolData[0],
            'sch_reg_no' => $schoolData[1],
            'district' => $schoolData[2],
            'academic_year' => $schoolData[3],
            'subject' => $schoolData[4],
            'paper' => $schoolData[5],
            'paperCode' => $schoolData[6],
            'results_type' => 1
        ];

        $schoolResultsData = array_values($resultsValues);
        $resultsData = [];

        foreach ($schoolResultsData as $results) {
            array_push($resultsData, [
                'stud_reg_no' => $results['D'],
                'sch_reg_no' =>  $data['sch_reg_no'],
                'paper_code' =>  $data['paperCode'],
                'paper' => $data['paper'],
                'score' => $results['E'],
                'aggreagate' => $results['F'],
                'academic_year' => $data['academic_year'],
                'district_of_origin' => $results['H'],
                'results_type_id' => $data['results_type']
            ]);
        }

        foreach ($resultsData as $studentResults) {
            $this->results_model->insert($studentResults);
        }
    }
}
