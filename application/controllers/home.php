<?php
/**
 * @package opix
 * @copyright Oulu University of Applied Sciences(OUAS)
 * @license MIT
 * @version 0.1
 */

/**
 * Class definition for Home controller extends CI_Controller.
 *
 * Class definition for Home controller. Controller includes method
 * to open home page and logout user.
 * Extends CI_Controller.
 * 
 * @author Tuukka Kiiskinen, Roni Kokkonen
 * @package opix
 * @subpackage controllers
 * @category home
 */
session_start();
class Home extends CI_Controller
{
    /**
     * Constructor of a home class.
     * 
     * Constructor of a home class. Load language package and session library.
     */
    public function __construct() 
    {
        parent::__construct();
        $this->lang->load('home');
        $this->load->library('session');
    }
    
    /*
     * Shows the home_view.
     */
    public function Index()
    {
        if ($this->session->userdata('logged_in'))
        {
            $session_data = $this->session->userdata('logged_in');
            $data['main_content'] = 'home_view';
            $data['pagetitle'] = $this->lang->line('title_home');
            $data['error_message'] = $this->session->flashdata('$error_message');
            $data['heading'] = $this->lang->line('title_db_error');
            $data['login_user_id'] = $session_data['user_id'];
            $data['login_id'] = $session_data['id'];
            $this->load->view('template', $data);
        }
        else
        {
            redirect('login','refresh');
        }
    }
    
    /*
     * Logout user and destroy session.
     */
    public function logout()
    {
        $this->session->unset_userdata('logged_in');
        $this->session->unset_userdata('account_type');
        session_destroy();
        redirect('login','refresh');
    }
}

?>
