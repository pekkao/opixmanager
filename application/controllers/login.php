<?php
/**
 * @package opix
 * @copyright Oulu University of Applied Sciences(OUAS)
 * @license MIT
 * @version 0.1
 */

/**
 * Class definition for Login controller extends CI_Controller.
 *
 * Class definition for Login controller. Controller includes method
 * to open login_view.
 * Extends CI_Controller.
 * 
 * @author Tuukka Kiiskinen, Roni Kokkonen
 * @package opix
 * @subpackage controllers
 * @category login
 */
class Login extends CI_Controller {
    
     /**
     * Constructor of a login class.
     * 
     * Constructor of a login class. Load language package.
     */
    public function __construct()
    {
        parent::__construct();
        $this->lang->load('login');
    }
    
    /*
     * Shows login_view.
     */
    public function index()
    {
        $data = array(
            'id' => '',
            'login_user_id' => '',
            'password' => '',
            'account_type' => ''
        );
        
        $data['main_content'] = 'login_view';
        $data['pagetitle'] = $this->lang->line('title_login');
        $this->load->helper(array('form'));
        $this->load->view('template', $data);
    }
    
    
}

?>
