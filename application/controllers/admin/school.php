<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class School extends CI_controller {

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

        $this->load->model('school_model');
        $this->load->model('results_model');
        if (!$this->aauth->is_allowed('school', $this->aauth->get_user_id())) {
            redirect('/dashboard');
        }

    }

    /**
     * [index description]
     * @return [type] [description]
     */
    public function index()
    {
        $this->load->view('admin/pages/add_school');
    }

    /**
     * [add description]
     */
    public function add() 
    {
        $this->load->model('school_model');
        $id = $this->school_model->from_form(NULL, array('user_id' => '2'))->insert();
        if($id === FALSE)
        {
             // set error flashdata
            $this->session->set_flashdata(
                'error',
                'Your have errors in your form!'
            );
            $this->load->view('admin/pages/add_school');
        }
        else
        {
            $reg_no = $this->input->post('sch_reg_no', true);
            redirect('dashboard/school/view/'. $reg_no );
        }
    }

    /**
     * [view description]
     * @return [type]     [description]
     */
    public function list_school()
    {
        $data['school'] = $this->school_model->listSchool();
        $this->load->view('admin/pages/list_school', $data);
    }

    /**
     * [view description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function view($id)
    {
        $data['school'] = $this->school_model->viewSchool($id);
        $this->load->view('admin/pages/view_school', $data);
    }

    /**
     * [delete description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function delete($id) {
        $this->school_model->deleteSchool($id);
        redirect('dashboard/school/view');
    }
    public function search_school(){
        $this->load->view('admin/pages/search_school');
    }
}
