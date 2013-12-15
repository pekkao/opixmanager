<?php

/**
 * @package opix
 * @copyright Oulu University of Applied Sciences(OUAS)
 * @license MIT
 * @version 0.1
 */

/**
 * Class definition for Sprint_task controller extends CI_Controller.
 *
 * Class definition for Sprint_task controller. Controller includes methods
 * to handle Sprint_task listing, inserting, editing and deleting Sprint_tasks.
 * Extends CI_Controller.
 * 
 * @author Tuukka Kiiskinen, Roni Kokkonen
 * @package opix
 * @subpackage controllers
 * @category Sprint_task
 */

class Sprint_Task extends CI_Controller
{
    /**
     * Constructor of a Sprint_task model.
     * 
     * Constructor of a Sprint_task model. Loads Sprint_task_model,
     * sprint_backlog_model, project_model, status_model,
     * task_type_model, sprint_backlog_item_model and language package.
     */
    public function __construct() 
    {
        parent::__construct();
        $this->load->model('sprint_backlog_model');
        $this->load->model('project_model');
        $this->load->model('product_backlog_model');
        $this->load->model('sprint_task_model');
        $this->load->model('status_model');
        $this->load->model('task_type_model');
        $this->load->model('sprint_backlog_item_model');
        $this->lang->load('sprint_task');
        $this->load->library('session');
    }
    
    /**
     * Listing of all sprint tasks.
     * 
     * Reads all sprint tasks from the sprint_task table in the database. 
     * Uses the sprint_task/sprint_tasks_view.
     * @param int id primary key of the selected sprint backlog, default value 0.
     * 
     */
    public function index($project_id = 0, $sprintbacklogid = 0)
    {  
        if ($this->session->userdata('logged_in'))
        {
            $session_data = $this->session->userdata('logged_in');
            
            $data['sprint_tasks'] = $this->sprint_task_model->read_all($sprintbacklogid);
            $data['currentsprintbacklogid'] = $sprintbacklogid;
            $sprintbacklog = $this->sprint_backlog_item_model->read($sprintbacklogid);    
            $data['sprintbacklog'] = $sprintbacklog;       
            $data['main_content'] = 'sprint_task/sprint_tasks_view';
            $data['project_id'] = $project_id;

            $sprint_backlog = $this->sprint_backlog_model->read($sprintbacklog[0]->sprint_backlog_id);
            $data['product_backlog_id'] = $sprint_backlog[0]->product_backlog_id;

            $data['sprint_backlog_item_id'] = $sprint_backlog[0]->id;

            $project = $this->project_model->read($project_id);

            if (isset($sprintbacklog[0]))
            {         
                $data['pagetitle'] = $project[0]->project_name . ', ' . $sprintbacklog[0]->item_name  . ': ' .
                        $this->lang->line('title_sprint_tasks');         
            }

            else
            {
                $data['pagetitle'] = $this->lang->line('title_sprint_tasks');           
            }

            $data['login_user_id'] = $session_data['user_id'];
            $data['login_id'] = $session_data['id'];
            $data['error_message'] = $this->session->flashdata('$error_message');
            $data['heading'] = $this->lang->line('title_db_error');
            $this->load->view('template', $data);
        }
        else
        {
            redirect('login','refresh');
        }
    }
    
    /**
     * Add a sprint task to the database.
     * 
     * Creates an empty sprint task and shows it via sprint_task/sprint_tasks_view.
     * @param int $currentsprintbacklogid Primary key of the sprint backlog. 
     */
    public function add($project_id, $currentsprintbacklogid)
    {
        if ($this->session->userdata('logged_in'))
        {
            $session_data = $this->session->userdata('logged_in');
            $data = array(
                'id' => '',
                'sprint_backlog_item_id' => $currentsprintbacklogid,
                'task_name' => '',
                'task_description' => '',
                'effort_estimate_hours' => '',
                'status_id'   => '',
                'task_type_id' => ''
            );


             // helper of this project for dropdown listbox
            $this->load->helper("form_input_helper");

            // dropdown listbox of statuses task types
            $statuses_from_db = $this->status_model->read_names();
            // new text in the beginning of array
            $a = array('id' => "0", 'status_name' => $this->lang->line('select_status') );
            array_unshift($statuses_from_db, $a);
            $statuses = convert_db_result_to_dropdown(
                    $statuses_from_db, 'id', 'status_name');        
            $data['statuses'] = $statuses;

            // dropdown listbox of task types
            $task_types_from_db = $this->task_type_model->read_names();
            // new text in the beginning of array
            $a = array('id' => "0", 'task_type_name' => $this->lang->line('select_task_type') );
            array_unshift($task_types_from_db, $a);
            $task_types = convert_db_result_to_dropdown(
                    $task_types_from_db, 'id', 'task_type_name');        
            $data['task_types'] = $task_types; 

            $data['project_id'] = $project_id;
            $data['main_content'] = 'sprint_task/sprint_task_view';
            $data['pagetitle'] = $this->lang->line('title_add_sprint_task');
            $data['add'] = TRUE;
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
     * Edit a sprint task.
     * 
     * Reads a sprint task from the database using the primary key. 
     * If no sprint task is found redirects to index with error message in flash data.
     * 
     * @param int $id, $currentsprintbacklogid Primary key of the sprint backlog. 
     */
     public function edit($project_id, $id)
    {
        if ($this->session->userdata('logged_in'))
        {
            $session_data = $this->session->userdata('logged_in');
            $sprint_task = $this->sprint_task_model->read($id);

            if (isset($sprint_task[0])) 
            {
                $data = array(
                    'id'         => $sprint_task[0]->id,
                    'sprint_backlog_item_id'    => $sprint_task[0]->sprint_backlog_item_id,
                    'task_name'  => $sprint_task[0]->task_name,
                    'task_description'      => $sprint_task[0]->task_description,
                    'effort_estimate_hours'      => $sprint_task[0]->effort_estimate_hours,
                    'status_id'      => $sprint_task[0]->status_id,
                    'task_type_id' => $sprint_task[0]->task_type_id
                );

                // helper of this project for dropdown listbox
                $this->load->helper("form_input_helper");

                $statuses_from_db = $this->status_model->read_names();
                // new text in the beginning of array
                $a = array('id' => "0", 'status_name' => $this->lang->line('select_status') );
                array_unshift($statuses_from_db, $a);
                $statuses = convert_db_result_to_dropdown(
                        $statuses_from_db, 'id', 'status_name');        
                $data['statuses'] = $statuses;

                $task_types_from_db = $this->task_type_model->read_names();
                // new text in the beginning of array
                $a = array('id' => "0", 'task_type_name' => $this->lang->line('select_task_type') );
                array_unshift($task_types_from_db, $a);
                $task_types = convert_db_result_to_dropdown(
                        $task_types_from_db, 'id', 'task_type_name');        
                $data['task_types'] = $task_types;

                $data['project_id'] = $project_id;
                $data['main_content'] = 'sprint_task/sprint_task_view';
                $data['pagetitle'] = $this->lang->line('title_edit_sprint_task');
                $data['add'] = FALSE; // not show reset button
                $data['login_user_id'] = $session_data['user_id'];
                $data['login_id'] = $session_data['id'];
                $this->load->view('template', $data);
            } 

            else 
            {
                $error_message = $this->lang->line('missing_sprint_task');
                $this->session->set_flashdata('$error_message', $error_message);
                redirect('sprint_task/index/' . $project_id . '/' . $currentsprintbacklogid);
            }
        }
        else
        {
            redirect('login','refresh');
        }
    }
    
    /**
     * Insert or update sprint task into the database.
     * 
     * Inserts or updates the sprint task into the sprint_task table. 
     * Validates the input data; task name must exist.
     */
    public function save()
    {
        if ($this->session->userdata('logged_in'))
        {
            $session_data = $this->session->userdata('logged_in');
            $data = array(
                'id' => $this->input->post('txt_id'),
                'sprint_backlog_item_id' => $this->input->post('txt_sprint_backlog_item_id'),
                'task_name' => $this->input->post('txt_task_name'),
                'task_description' => $this->input->post('txt_task_description'),
                'effort_estimate_hours' => $this->input->post('txt_effort_estimate_hours'),
                'status_id' => $this->input->post('ddl_status_id'),
                'task_type_id' => $this->input->post('ddl_task_type_id')
             );

            $project_id = $this->input->post('txt_project_id');
            $update = FALSE; 

            if (strlen($this->input->post("txt_id")) > 0)
            {
                $update = TRUE; 
            }

            $this->load->library('form_validation');
            $this->form_validation->set_error_delimiters('<span class="error">', '</span>');

            $this->form_validation->set_rules(
                    'txt_task_name', $this->lang->line('missing_task_name'), 'trim|required|max_length[255]|xss_clean');
            $this->form_validation->set_rules(
                    'txt_task_description', 'trim|max_length[1000]|xss_clean');         

            if ($this->form_validation->run() == FALSE) 
            {
                $data['project_id'] = $project_id;
                $data['main_content'] = 'sprint_task/sprint_task_view';
                $data['pagetitle'] = $this->lang->line('title_add_sprint_task');

                if ($update == TRUE)
                {
                    $data['add'] = FALSE; 
                }
                else
                {
                    $data['add'] = TRUE;
                }

                 // helper of this project for dropdown listbox
                $this->load->helper("form_input_helper");

                $statuses_from_db = $this->status_model->read_names();
                // new text in the beginning of array
                $a = array('id' => "0", 'status_name' => $this->lang->line('select_status') );
                array_unshift($statuses_from_db, $a);
                $statuses = convert_db_result_to_dropdown(
                        $customers_from_db, 'id', 'status_name');        
                $data['statuses'] = $statuses;

                $task_types_from_db = $this->task_type_model->read_names();
                // new text in the beginning of array
                $a = array('id' => "0", 'task_type_name' => $this->lang->line('select_task_type') );
                array_unshift($task_types_from_db, $a);
                $task_types = convert_db_result_to_dropdown(
                        $task_types_from_db, 'id', 'task_type_name');        
                $data['task_types'] = $task_types;
                $data['login_user_id'] = $session_data['user_id'];
                $data['login_id'] = $session_data['id'];
                $this->load->view('template', $data);
            }

            else
            {
                if ($update == TRUE)  
                {
                    $data['id'] = intval($this->input->post('txt_id'));
                    $this->sprint_task_model->update($data);     
                }

                else  
                {             
                    $this->sprint_task_model->create($data);
                }

                redirect('sprint_task/index/' . $project_id . '/' . $data['sprint_backlog_item_id']);
            }
        }
        else
        {
            redirect('login','refresh');
        }
    }
    
     /**
     * Delete a sprint task.
     * 
     * Deletes a sprint task using the primary key.
     * 
     * @param int $id Primary key of the sprint task. 
     */
    public function delete()
    {
        $id = $this->input->post('txt_id');
        $project_id = $this->input->post('txt_project_id');
        $sprintbacklogid = $this->input->post('txt_sprint_backlog_item_id');                      
        
        if ($this->sprint_task_model->delete(intval($id)) == FALSE)
        {
            $error_message = $this->lang->line('cannot_delete');
            $this->session->set_flashdata('$error_message', $error_message);
            redirect('sprint_task/index/' . $project_id . '/' . $sprintbacklogid); 
        }
        else
        {
            $this->sprint_task_model->delete(intval($id));
            redirect('sprint_task/index/' . $project_id . '/' . $sprintbacklogid); 
        }
    }
    
}
?>
