<?php
/**
 * @package opix
 * @copyright Oulu University of Applied Sciences(OUAS)
 * @license MIT
 * @version 0.1
 */

/**
 * Class definition for Backup controller extends CI_Controller.
 *
 * Class definition for Backup controller. Controller includes method
 * to backup entire database.
 * Extends CI_Controller.
 * 
 * @author Tuukka Kiiskinen, Roni Kokkonen
 * @package opix
 * @subpackage controllers
 * @category backup
 */

class Backup extends CI_Controller
{
    /**
     * Constructor of a backup class.
     * 
     * Constructor of a backup class. Load backup utility
     */
    public function __construct() 
    {
        parent::__construct();
        $this->load->dbutil();
        $this->lang->load('backup');
        $this->load->library('session');
    }
    
    /*
     * Shows the backup_view.
     */
    public function index()
    {
        if ($this->session->userdata('logged_in'))
        {
            if ($this->session->userdata('account_type') == 1)
            {
                $session_data = $this->session->userdata('logged_in');
                $data['error_message'] = $this->session->flashdata('$error_message');
                $data['heading'] = $this->lang->line('title_db_error');
                $data['pagetitle'] = $this->lang->line('title_backup');
                $data['main_content'] = 'backup_view';
                $data['login_user_id'] = $session_data['user_id'];
                $data['login_id'] = $session_data['id'];
                $this->load->view('template', $data);
            }
            else
            {
                $error_message = $this->lang->line('not_allowed');
                $this->session->set_flashdata('$error_message', $error_message);
                redirect('home');
            }
        }
        else
        {
            redirect('login','refresh');
        }
    }
    
    /*
     * Makes a backup of the database to application/backup folder.
     */
    public function backupdb()
    {
        if ($this->session->userdata('logged_in'))
        {
            if ($this->session->userdata('account_type') == 1)
            {
               
                $session_data = $this->session->userdata('logged_in');
                $data['login_user_id'] = $session_data['user_id'];
                $data['login_id'] = $session_data['id'];
                
                $data['error_message'] = $this->session->flashdata('$error_message');
                $data['heading'] = $this->lang->line('title_db_error');
                
                // name the file
                $time = date('j-n-Y_H-i-s', time());
                $filename = 'backup-'.$time.'.sql';

                // path to file
                $path = FCPATH.'application/backup/';

                $prefs = array(
                    'tables'      => array('item_type', 'language', 'person', 'status', 
                        'task_type', 'person_role', 'project_type',  
                        'customer', 'contact_person', 'project', 'project_staff', 
                        'product_backlog', 'product_backlog_item', 'sprint_backlog', 
                        'sprint_backlog_item', 'sprint_task', 'sprint_task_person', 
                        'sprint_work', 
                        'project_period', 'task', 'task_person', 'task_work'
                        ),  // Array of tables to backup.
                    'format'      => 'txt',             // gzip, zip, txt
                    'add_drop'    => TRUE,              // Whether to add DROP TABLE statements to backup file
                    'add_insert'  => TRUE,              // Whether to add INSERT data to backup file
                    'newline'     => "\n"               // Newline character used in backup file
                );

                // Load the DB utility class and backup db
                $this->load->dbutil();            
                $backup =& $this->dbutil->backup($prefs); 

                // load file helper and save the file
                $this->load->helper('file');            

                if (!write_file($path.$filename, $backup))
                {
                      echo $this->lang->line('label_error');
                      echo br(1);
                      echo anchor('backup/index', $this->lang->line('link_return'));
                }

                else
                {
                      echo $this->lang->line('label_success');
                      echo br(1);
                      echo anchor('backup/index', $this->lang->line('link_return'));
                }
            }
            else
            {
                $error_message = $this->lang->line('not_allowed');
                $this->session->set_flashdata('$error_message', $error_message);
                redirect('home');
            }
        }
        else
        {
            redirect('login','refresh');
        }
             
    }
}
?>