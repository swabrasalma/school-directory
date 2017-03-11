<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Subject extends Ci_controller {

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
        $this->load->model('subject_model');

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
        
        $this->load->view('admin/pages/upload_subjects');
    }

    /**
     * Uploads execl file to directory and perfoms the insert to the database
     * @return void
     */
    public function do_upload()
    {
        if($_POST) {

            $type = $this->input->post('entry', true);

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

                redirect('/dashboard/subjects');
            }
            else
            {  
                $excelFile = $this->upload->data('file_name');

                $results = $this->subject_model->getExcelData($excelFile, $type);

                if ($results == true) {
                    $this->load->view('admin/pages/success');
                } else {
                    // set error flashdata
                    $this->session->set_flashdata(
                        'error', 
                        'Could Not Upload Subjects'
                    );
                    redirect('/dashboard/subjects');
                } 
            }
        }
    }

    /**
     * [listStudents description]
     * @return [type] [description]
     */
    public function listSubject() 
    {
         

    }

    /**
     * [listStudents description]
     * @return [type] [description]
     */
    public function viewSubject() 
    {
         

    }

    /**
     * [listStudents description]
     * @return [type] [description]
     */
    public function editSubject() 
    {
         

    }

    /**
     * [listStudents description]
     * @return [type] [description]
     */
    public function deletetSubject() 
    {
         

    }

}
