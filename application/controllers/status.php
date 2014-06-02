<?php
/**
 * @package opix
 * @copyright Oulu University of Applied Sciences(OUAS)
 * @license MIT
 * @version 0.1
 */

/**
 * Class definition for Status controller extends CI_Controller.
 *
 * Class definition for Status controller. Controller includes methods
 * to handle status listing, inserting, editing and deleting statuses.
 * Extends CI_Controller.
 * 
 * @author Tuukka Kiiskinen
 * @package opix
 * @subpackage controllers
 * @category status
 */
class Status extends CI_Controller {
    /**
     * Constructor of a status model.
     * 
     * Constructor of a status model. Loads status_model and language package.
     */
    public function __construct() {
        parent::__construct(); 
        $this->load->model('status_model');
        $this->lang->load('status');
        $this->load->library('session');
    }
    
     /**
     * Listing of all statuses.
     * 
     * Reads all statuses from the status table in the database. 
     * Uses the status/statuses_view.
     * 
     */    
    public function index() {
        
        if ($this->session->userdata('logged_in'))
        {
            $session_data = $this->session->userdata('logged_in');
            $data = array(
                'id'                 => '',
                'status_name'        => '',
                'status_description' => ''
            );

            $data['statuses'] = $this->status_model->read_all();
            $data['main_content'] = 'status/statuses_view';
            $data['pagetitle'] = $this->lang->line('title_status');
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
    
    /**
     * Add a status to the database.
     * 
     * Creates an empty status and shows it via status/statuses_view.
     */
    public function add()
    {
        if ($this->session->userdata('logged_in'))
        {
            $session_data = $this->session->userdata('logged_in');
            
            if ($this->session->userdata('account_type') == 1)
            {
                $data = array(
                    'id'                 => '',
                    'status_name'        => '',
                    'status_description' => ''
                );

                $data['main_content'] = 'status/status_view';
                $data['pagetitle'] = $this->lang->line('title_add_status');
                $data['add'] = TRUE;
                $data['login_user_id'] = $session_data['user_id'];
                $data['login_id'] = $session_data['id'];
                $this->load->view('template', $data);
            }
            else
            {
                $error_message = $this->lang->line('not_allowed');
                $this->session->set_flashdata('$error_message', $error_message);
                redirect('status');
            }
        }
        else
        {
            redirect('login','refresh');
        }
    }
    
    /**
     * Insert or update status into the database.
     * 
     * Inserts or updates the status into the status table. 
     * Validates the input data; status name must exist.
     */
    public function save()
    {
        if ($this->session->userdata('logged_in'))
        {
            $session_data = $this->session->userdata('logged_in');
             $data = array(
                'id' => $this->input->post('txt_id'),
                'status_name' => $this->input->post('txt_statusname'),
                'status_description' => $this->input->post('txt_status_description')
             );

             $update = FALSE;

             if (strlen($this->input->post("txt_id")) > 0)
             {
                 $update = TRUE;
             }

             $this->load->library('form_validation');
             $this->form_validation ->set_error_delimiters('<span class="error">','</span>');

             $this->form_validation->set_rules(
                     'txt_statusname',$this->lang->line('missing_name'),'trim|required|max_length[255]|xss_clean');
             $this->form_validation->set_rules(
                     'txt_status_description', 'trim|max_length[1000]|xss_clean');

             if( $this->form_validation->run() == FALSE)
             {
                 $data['main_content'] = 'status/status_view';
                 $data['pagetitle'] = $this->lang->line('title_add_status');

                 if ($update == TRUE)
                 {
                     $data['add'] = FALSE;
                 }

                 else
                 {
                     $data['add'] = TRUE;
                 }
                 $data['login_user_id'] = $session_data['user_id'];
                 $data['login_id'] = $session_data['id'];
                 $this->load->view('template', $data);
             }

             else
             {
                 if ($update == TRUE)
                 {
                     $data['id'] = intval($this->input->post('txt_id'));
                     $this->status_model->update($data);
                     redirect('status');
                 }

                 else
                 {
                     $this->status_model->create($data);
                     redirect('status');
                 }
             }
        }
        else
        {
            redirect('login','refresh');
        }
    }
    
    /**
     * Edit a status.
     * 
     * Reads a status from the database using the primary key. 
     * If no status is found redirects to index with error message in flash data.
     * 
     * @param int $id Primary key of the status. 
     */
    public function edit($id)
    {
        if ($this->session->userdata('logged_in'))
        {
            $session_data = $this->session->userdata('logged_in');
            
            if ($this->session->userdata('account_type') == 1)
            {
                $status = $this->status_model->read($id);

                if (isset($status[0]))
                {
                    $data = array(
                        'id' => $status[0]->id,
                        'status_name' => $status[0]->status_name,
                        'status_description' => $status[0]->status_description
                    );

                    $data['main_content'] = 'status/status_view';
                    $data['pagetitle'] = $this->lang->line('title_edit_status');
                    $data['add'] = FALSE;
                    $data['login_user_id'] = $session_data['user_id'];
                    $data['login_id'] = $session_data['id'];
                    $this->load->view('template', $data);
                }  

                else 
                {
                    $error_message = $this->lang->line('missing_status');
                    $this->session->set_flashdata('$error_message', $error_message);
                    redirect('status');
                }
            }
            else
            {
                $error_message = $this->lang->line('not_allowed');
                $this->session->set_flashdata('$error_message', $error_message);
                redirect('status');
            }
        }
        else
        {
            redirect('login','refresh');
        }
    }
    
    /**
     * Delete a status.
     * 
     * Deletes a status using the primary key.
     * 
     */
    public function delete()
    {
        if ($this->session->userdata('logged_in'))
        {
            $session_data = $this->session->userdata('logged_in');
            
            if ($this->session->userdata('account_type') == 1)
            {
                $id = $this->input->post('txt_id');              

                if ($this->status_model->delete(intval($id)) == FALSE)
                {
                    $error_message = $this->lang->line('cannot_delete');
                    $this->session->set_flashdata('$error_message', $error_message);
                    redirect('status'); 
                }
                else
                {
                    $this->status_model->delete(intval($id));
                    redirect('status');  
                }
            } 
            else
            {
                $error_message = $this->lang->line('not_allowed');
                $this->session->set_flashdata('$error_message', $error_message);
                redirect('status');
            }
        }
        else
        {
            redirect('login','refresh');
        }
    }
}

?>
