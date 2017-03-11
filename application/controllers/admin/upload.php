<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class upload extends Ci_controller {

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

        $schoolData['options'] = $this->school_model->getAllSchools();
        $this->load->view('admin/pages/upload', $schoolData);
    }

    /**
     * Uploads execl file to directory and perfoms the insert to the database
     * @return void
     */
    public function do_upload()
    {
        if($_POST) {   
            //clean public facing app input
            $sch_reg_no = $this->input->post('sch_reg_no', true);
            $type = $this->input->post('results_type', true);
            $academicYear = $this->input->post('academic_year', true);
            $userfile1 = $_FILES['userfile']['name'];
            $file = './files/files.xlsx';

            if (file_exists($file)) {
                // set error flashdata
                $this->session->set_flashdata(
                    'error', 
                    'School Results Already uploaded'
                );
                redirect('/dashboard/upload');

            } else {

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
                    $results = $this->results_model->getExcelData($excelFile, $sch_reg_no, $academicYear, $type);

                    if ($results == true) {
                        $this->load->view('admin/pages/success');
                    } else {
                        // set error flashdata
                        $this->session->set_flashdata(
                            'error', 
                            'School Registration Number or Academic year is wrong'
                        );
                        redirect('/dashboard/upload');
                    }
                }
            }
        }
    }
    
}
