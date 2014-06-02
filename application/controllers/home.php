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
    CONST ADMIN = 1;
    CONST MEMBER = 2;
    CONST SELECTED = TRUE; // This constant is used in person_view
    
    private static $enum = array(1 => "Admin", 2 => "Member");
    
    /*
     * Converts account_type to string
     */
    public function toString($account_type)
    {
        return self::$enum[$account_type];
    }
    
    CONST TRADITIONAL = 1;
    CONST SCRUM = 2;
    
    CONST ACTIVE = 2;
    CONST FINISHED = 1;   
    
    private static $enum2 = array(1 => "Traditional", 2 => "Scrum");
    private static $enum3 = array(1 => "Finished", 2 => "Active");
    
    /**
     * Converts project_type to string.
     */
    public function toString2($project_type)
    {
        return self::$enum2[$project_type];
    }
    
    /**
     * Converts active to string.
     */
    public function toString3($active)
    {
        return self::$enum3[$active];
    }

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
        
        $this->load->model('person_model');
        $this->load->model('project_model');
        $this->lang->load('person');
        $this->lang->load('project');
    }
    
    /*
     * Shows the home_view.
     */
    public function index()
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
            
            // persons projects into home view
            $data['projects'] = 
                    $this->person_model->read_person_projects($session_data['id']);
            
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
