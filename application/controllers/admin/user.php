<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class User extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library("Aauth");
    }

    /**
     * [index description]
     * @return [type] [description]
     */
    public function index() {
        $this->load->view('admin/pages/add_user');
    }

    /**
     * [create_user description]
     * @return [type] [description]
     */
    public function createUser() {
        if($_POST) {   //clean public facing app input
            $email = $this->input->post('email', true);
            $username = $this->input->post('username', true);
            $password = $this->input->post('password', true);
            $permission = $this->input->post('perm', true);

            if ($this->aauth->get_user_id($email)) {
                // set error flashdata
                    $this->session->set_flashdata(
                        'error',
                        'User Already Exist'
                    );
                    //$errs['errors'] = $this->aauth->create_user->get_errors();
                    $this->load->view('admin/pages/add_user');

            } else {

                if ( $this->aauth->create_user($email, $password, $username) ){
                    $userId = $this->aauth->get_user_id($email);
                    $this->aauth->allow_user($userId, $permission);
                    redirect('dashboard/user/view');

                } else {
                    // set error flashdata
                    $this->session->set_flashdata(
                        'error',
                        'Your have errors in your form!'
                    );
                    //$errs['errors'] = $this->aauth->create_user->get_errors();
                    $this->load->view('admin/pages/add_user');
                }  
            }
            
        }           
    }

    /**
     * [viewUser description]
     * @return [type] [description]
     */
    public function viewUser() {
        $data['users'] = json_decode(json_encode($this->aauth->list_users()), True);
        $this->load->view('admin/pages/view_user', $data);

    }

    /**
     * [editUser description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function editUser($id) {
        echo "yes";
    }

    /**
     * [is_loggedin description]
     * @return boolean [description]
     */
    protected function updateUser() {

        if ( $this->aauth->is_loggedin() ){
             echo 'OK. You are logged in';
        } else {
             echo 'you must login';
        }            
    }

    /**
     * Deletes a user
     *
     * @return void
     **/
    public function deleteUser($id) {
        $this->aauth->delete_user($id);
        redirect('dashboard/user/view');
    }

}
?>