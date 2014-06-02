<?php
/**
 * @package opix
 * @copyright Oulu University of Applied Sciences(OUAS)
 * @license MIT
 * @version 0.1
 */

/**
 * Class definition for Task_Type controller extends CI_Controller.
 *
 * Class definition for Task_Type controller. Controller includes methods
 * to handle Task Type listing, inserting, editing and deleting Task Types.
 * Extends CI_Controller.
 * 
 * @author Roni Kokkonen
 * @package opix
 * @subpackage controllers
 * @category Task_Type
 */

class Task_Type extends CI_Controller {
    
    /**
     * Constructor of a Task_Type model.
     * 
     * Constructor of a Task_Type model. Loads task_type_model and language package.
     */
    public function __construct() {
        parent::__construct();
        $this->load->model('task_type_model');
        $this->lang->load('task_type');
        $this->load->library('session');
    }
    
    /**
     * Listing of all task types.
     * 
     * Reads all task types from the task_type table in the database. 
     * Uses the task_type/task_types_view.
     * 
     */
    public function index() {
        
        if ($this->session->userdata('logged_in'))
        {
            $session_data = $this->session->userdata('logged_in');
            $data = array(
                'id' => '',
                'task_type_name' => '',
                'task_type_description' => ''
            );

            $data['task_types'] = $this->task_type_model->read_all();
            $data['main_content'] = 'task_type/task_types_view';
            $data['pagetitle'] = $this->lang->line('title_task_type');
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
     * Add a task type to the database.
     * 
     * Creates an empty task type and shows it via task_type/task_types_view.
     */
    public function add() {
        
        if ($this->session->userdata('logged_in'))
        {
            $session_data = $this->session->userdata('logged_in');
            
            if ($this->session->userdata('account_type') == 1)
            {
                $data = array(
                    'id' => '',
                    'task_type_name' => '',
                    'task_type_description' => ''
                );

                $data['main_content'] = 'task_type/task_type_view';
                $data['pagetitle'] = $this->lang->line('title_add_task_type');
                $data['add'] = TRUE;
                $data['login_user_id'] = $session_data['user_id'];
                $data['login_id'] = $session_data['id'];
                $this->load->view('template', $data);
            }
            else
            {
                $error_message = $this->lang->line('not_allowed');
                $this->session->set_flashdata('$error_message', $error_message);
                redirect('task_type');
            }
        }
        else
        {
            redirect('login','refresh');
        }
    }
    
    /**
     * Insert or update task type into the database.
     * 
     * Inserts or updates the task type into the task_type table. 
     * Validates the input data; task_type name must exist.
     */
    public function save() {
        
        if ($this->session->userdata('logged_in'))
        {
            $session_data = $this->session->userdata('logged_in');
            $data = array(
                'id' => $this->input->post('txt_id'),
                'task_type_name' => $this->input->post('txt_task_typename'),
                'task_type_description' => $this->input->post('txt_task_type_description')
            );

            $update = FALSE;

            if (strlen($this->input->post('txt_id')) > 0)
            {
                $update = TRUE;
            }

            $this->load->library('form_validation');
            $this->form_validation->set_error_delimiters('<span class="error">', '</span>');

            $this->form_validation->set_rules(
                    'txt_task_typename', $this->lang->line('missing_name'), 'trim|required|max_length[255]|xss_clean');
            $this->form_validation->set_rules(
                     'txt_task_type_description', 'trim|max_length[1000]|xss_clean');



            if ($this->form_validation->run() == FALSE) 
            {
                $data['main_content'] = 'task_type/task_type_view';
                $data['pagetitle'] = $this->lang->line('title_add_task_type');

                if ($update == TRUE) 
                {
                    $data['add'] = FALSE;
                }

                else 
                {
                    $data['add'] = TRUE;
                }
                $data['login_user_id'] = $session_data['user_id'];
                $this->load->view('template', $data);
            }

            else 
            {
                if ($update == TRUE) 
                {
                    $data['id'] = intval($this->input->post('txt_id'));
                    $this->task_type_model->update($data);
                    redirect('task_type');
                }

                else 
                {
                    $this->task_type_model->create($data);
                    redirect('task_type');
                }
            }
        }
        else
        {
            redirect('login','refresh');
        }
    }
    
    /**
     * Edit a task type.
     * 
     * Reads a task type from the database using the primary key. 
     * If no task type is found redirects to index with error message in flash data.
     * 
     * @param int $id Primary key of the task type. 
     */
    public function edit($id) {
        
        if ($this->session->userdata('logged_in'))
        {
            $session_data = $this->session->userdata('logged_in');
            
            if ($this->session->userdata('account_type') == 1)
            {
                $task_type = $this->task_type_model->read($id);

                if (isset($task_type[0])) 
                {
                    $data = array(
                        'id' => $task_type[0]->id,
                        'task_type_name' => $task_type[0]->task_type_name,
                        'task_type_description' => $task_type[0]->task_type_description
                    );

                    $data['main_content'] = 'task_type/task_type_view';
                    $data['pagetitle'] = $this->lang->line('title_edit_task_type');
                    $data['add'] = FALSE;
                    $data['login_user_id'] = $session_data['user_id'];
                    $data['login_id'] = $session_data['id'];
                    $this->load->view('template', $data);
                }

                else 
                {
                    $error_message = $this->lang->line('missing_task_type');
                    $this->session->set_flashdata('$error_message', $error_message);
                    redirect('task_type');
                }
            }
            else
            {
                $error_message = $this->lang->line('not_allowed');
                $this->session->set_flashdata('$error_message', $error_message);
                redirect('task_type');
            }
        }
        else
        {
            redirect('login','refresh');
        }
    }
    
    /**
     * Delete a task type.
     * 
     * Deletes a task type using the primary key.
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

                if ($this->task_type_model->delete(intval($id)) == FALSE)
                {
                    $error_message = $this->lang->line('cannot_delete');
                    $this->session->set_flashdata('$error_message', $error_message);
                    redirect('task_type'); 
                }
                else
                {
                    $this->task_type_model->delete(intval($id));
                    redirect('task_type'); 
                } 
            }
            else
            {
                $error_message = $this->lang->line('not_allowed');
                $this->session->set_flashdata('$error_message', $error_message);
                redirect('task_type');
            }
        }
        else
        {
            redirect('login','refresh');
        }
    }
}
