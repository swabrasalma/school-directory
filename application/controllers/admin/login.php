<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Login extends CI_Controller {

    public function __construct() {
        parent::__construct();
        
    }

    /**
     * [index description]
     * @return [type] [description]
     */
    public function index() {
        if ($this->aauth->is_loggedin() ){
            redirect('/dashboard');
        }
        $this->load->view('login');
    }

    /**
     * [login description]
     * @return [type] [description]
     */
    public function loginAction() {
        if($_POST) {   //clean public facing app input
            $username = $this->input->post('username', true);
            $password = $this->input->post('password', true);
            //vdebug($this->aauth->login($username, $password, true));
            //Ion_Auth Login fun
            if ($this->aauth->login($username, $password, true)){
                    $loginInfo = $this->aauth->get_user_groups($this->aauth->get_user_id());
                    $permissionList = $this->aauth->list_perms();
                    $user = json_decode(json_encode($loginInfo), True);
                    $permissions = json_decode(json_encode($permissionList), True);
                    foreach ($permissions as $key => $permission) {
                        if ($this->aauth->is_allowed($permission['name'], $this->aauth->get_user_id())) {
                            $userData = array( 
                               'username'  => 'username', 
                               'section'     => $permission['name'], 
                               'logged_in' => TRUE
                            );
                            $this->session->set_userdata($userData);
                            break;  
                        }
                    }
                    redirect('/dashboard');
            } else {
                // set error flashdata
                $this->session->set_flashdata(
                    'error',
                    'Your Username or Password is wrong!'
                );

                redirect('/dashboard/login');
            }
        }

    }

    /**
     * Global logout function to destroy user session
     *
     * @return void
     **/
    public function logoutAction() {
        $this->aauth->logout();
        $this->load->view('login');
    }

}
?>