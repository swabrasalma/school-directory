<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Students extends Ci_controller {

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
        $this->load->model('students_model');
        $this->load->model('school_model');
        if (!$this->aauth->is_allowed('school', $this->aauth->get_user_id())) {
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
        
        $this->load->view('admin/pages/upload_students');
    }

    /**
     * Uploads execl file to directory and perfoms the insert to the database
     * @return void
     */
    public function do_upload()
    {
        if($_POST) {

            $type = $this->input->post('results_type', true);
            $academicYear = $this->input->post('academic_year', true);

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

                redirect('/dashboard/students');
            }
            else
            {  
                $excelFile = $this->upload->data('file_name');

                $results = $this->students_model->getExcelData($excelFile, $type, $academicYear);

                if ($results == true) {
                    $this->load->view('admin/pages/success');
                } else {
                    // set error flashdata
                    $this->session->set_flashdata(
                        'error', 
                        'Student academic year is wrong'
                    );
                    redirect('/dashboard/students');
                } 
            }
        }
    }

    /**
     * [listStudents description]
     * @return [type] [description]
     */
    public function listStudents() 
    {
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

            $schoolData['students'] = $this->students_model->getStudents($school, $academicYear, $type); 
        }

        $this->load->view('admin/pages/list_students', $schoolData);

    }

    /**
     * [ViewStudents description]
     */
    public function studentResult($school, $stud_no, $year) 
    {
        $stud_reg_no = $school . '/' . $stud_no;

        $data['results'] = $this->students_model->getStudentResult($stud_reg_no, $year);
        $this->load->view('admin/pages/results_passlip', $data);
    }

}
