<?php
/**
 * @package opix
 * @copyright Oulu University of Applied Sciences(OUAS)
 * @license MIT
 * @version 0.1
 */

/**
 * Class definition for Verify_login controller extends CI_Controller.
 *
 * Class definition for Verify_login controller. Controller includes method
 * to check username and password.
 * Extends CI_Controller.
 * 
 * @author Tuukka Kiiskinen, Roni Kokkonen
 * @package opix
 * @subpackage controllers
 * @category verify_login
 */
class Verify_Login extends CI_Controller {
    
    /**
     * Constructor of a Verify_login class.
     * 
     * Constructor of a Verify_login class. Load person_model and language package.
     */
    function __construct()
    {
        parent::__construct();
        $this->load->model('person_model','',TRUE);  
        $this->lang->load('login');
    }
    
    /*
     * Check username and password.
     */
    public function index()
    {
        
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('txt_user_id', $this->lang->line('label_username'),'trim|required|xss_clean');
        $this->form_validation->set_rules('pwd_password', $this->lang->line('label_password2'),
                'trim|required|xss_clean|callback_check_database|md5');
        
        if ($this->form_validation->run() == FALSE)
        {
            $data = array(
                'id' => '',
                'user_id' => '',
                'password' => ''
            );
            
            $data['main_content'] = 'login_view';
            $data['pagetitle'] = $this->lang->line('title_login');
            $this->load->helper(array('form'));
            $this->load->view('template', $data);
        }
        
        else
        {
            redirect('home','refresh');
        }
    }
    
    /*
     * Compare username and password to database.
     * @param string md5 $password
     */
    public function check_database($password)
    {
        $user_id = $this->input->post('txt_user_id');
        
        $result = $this->person_model->login($user_id, $password);
        
        if ($result)
        {
            $sess_array = array();
            foreach ($result as $row)
            {
                $sess_array = array(
                    'id' => $row->id,
                    'user_id' => $row->user_id
                );
                $this->session->set_userdata('account_type', $row->account_type);
                $this->session->set_userdata('logged_in', $sess_array);
            }
        return TRUE;
        }
        else
        {        
           $this->form_validation->set_message('check_database', 'Invalid username or password');         
           return FALSE;
        }
        
    }
}

?>
