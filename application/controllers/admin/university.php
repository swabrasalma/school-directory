<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class university extends CI_Controller {

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
        $this->load->model('university_model');
        if (!$this->aauth->is_allowed('university', $this->aauth->get_user_id())) {
            $msg['heading'] = 'Error: 403';
            $msg['message'] = 'You cannot view this page';
            echo "<h1>" . $msg['message'] . "</h1?";
            die();
        }

    }

    /**
     * index
     * @return viod
     */
    public function index()
    { 
        $this->load->view('admin/pages/add_university');  
    }
    
    /**
     * Add a university
     */
    public function add()
    {
        $this->load->model('university_model');

        $id = $this->university_model->from_form(NULL, array('user_id' => '1'))->insert();
        if($id === FALSE)
        {
            $this->load->view('user_form_view');
        }
        else
        {
            redirect('dashboard/school/view/');
        }
    }

    /**
     * lists universities
     * @return [type] [description]
     */
    public function list_university()
    {
        $data['university'] = $this->university_model->listUniversity();
        $this->load->view('admin/pages/list_university', $data);
    }

    /**
     * [view description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function view($id)
    {
        $data['university'] = $this->university_model->viewUniversity($id);
        $this->load->view('admin/pages/view_university', $data);
    }

    /**
     * [delete description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function delete($id) {
        $this->university_model->deleteUniversity($id);
        redirect('dashboard/university/view');
    }

}