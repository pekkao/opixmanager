<?php

/**
 * @package opix
 * @copyright Oulu University of Applied Sciences(OUAS)
 * @license MIT
 * @version 0.1
 */

/**
 * Class definition for Task controller extends CI_Controller.
 *
 * Class definition for Task controller. Controller includes methods
 * to handle Tasks listing, inserting, editing and deleting Tasks.
 * Extends CI_Controller.
 * 
* @package	opix
* @subpackage   Controllers
* @category	task
* @author	Hannu Raappana, Roni Kokkonen, Tuukka Kiiskinen
*/


class Task extends CI_Controller
{
    /**
     * Constructor of a Task model.
     * 
     * Constructor of a Task model. Loads task_model,
     * project_period_model and language package.
     */
    public function __construct()
    {        
        parent::__construct();
        $this->lang->load('task');
        $this->load->model('task_model');
        $this->load->model('project_period_model');
        $this->load->model('project_model');
        $this->load->model('status_model');
        $this->load->model('task_type_model');
        $this->load->library('session');
    }
    
    /**
     * Listing of all tasks.
     * 
     * Reads all tasks from the task table in the database of the selected 
     * project and project period. 
     * Uses the task/tasks_view.
     * 
     * @param int $project_id Selected project
     * @param int $projectperiod_id Selected project period, optional
     */
    public function index($project_id = 0, $projectperiod_id = 0)
    {    
        if ($this->session->userdata('logged_in'))
        {
            $session_data = $this->session->userdata('logged_in');
            $data = array(
                'id' => '',
                'task_name' => '',
                'task_description' => '',
                'task_start_date' => '',
                'task_end_date' => '',
                'effort_estimate_hours' => '',
                'project_period_id' =>'',
                'task_type_id' => '',
                'status_id' => ''
            );

            $data['project_id'] = $project_id;
            $project = $this->project_model->read($project_id);

            $data['tasks'] = $this->task_model->read_all($projectperiod_id);
            $data['currentprojectperiod_id'] = $projectperiod_id;
            $data['main_content'] = 'task/tasks_view';


            // possible error message and heading for it
            $data['error_message'] = $this->session->flashdata('$error_message');

            if ($projectperiod_id > 0)
            {
                $projectperiod = $this->project_period_model->read($projectperiod_id);
                $data['pagetitle'] = $project[0]->project_name . ', ' . $projectperiod[0]->period_name  . ': ' .
                        $this->lang->line('tasks');
            }

            else
            {
                $data['pagetitle'] = $this->lang->line('title_project_periods');
            }
            
            $data['login_user_id'] = $session_data['user_id'];
            $data['login_id'] = $session_data['id'];
            $data['heading'] = $this->lang->line('title_db_error');
            $this->load->view('template', $data);
        }
        else
        {
            redirect('login','refresh');
        }
    }
    
    /**
     * Add a task to the database.
     * 
     * Creates an empty task and shows it via task/task_view.
     * 
     * @param int $currentprojectperiod_id Selected project period. 
     * @param int $project_id Primary key of the selected project. 
     */
    public function add($project_id, $currentprojectperiod_id = 0)
    {    
        if ($this->session->userdata('logged_in'))
        {
            $session_data = $this->session->userdata('logged_in');
            $data = array(
                'id' => '',
                'task_name' => '',
                'task_description' => '',
                'task_start_date' => '',
                'task_end_date' => '',
                'effort_estimate_hours' => '',
                'project_period_id' => $currentprojectperiod_id,
                'task_type_id' => '',
                'status_id' => ''
            );

            $data['error_message'] = $this->session->flashdata('$error_message');

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
            $project = $this->project_model->read($project_id);
            $projectperiod = $this->project_period_model->read($currentprojectperiod_id);
            $data['main_content'] = 'task/task_view';
            $data['pagetitle'] = $project[0]->project_name . 
                    ', ' . $projectperiod[0]->period_name . ': ' .$this->lang->line('title_add_task');
            $data['add'] = true; // show reset button
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
     * Edit a task.
     * 
     * Reads a task from the database using the primary key. 
     * If no task is found redirects to index with error message in flash data.
     * 
     * @param int $project_id Primary key of the selected project.
     * @param int $currentprojectperiod_id Selected project period, 
     * @param int $task_id Primary key of the task. 
     */
    public function edit($project_id, $currentprojectperiod_id, $task_id)
    {     
        if ($this->session->userdata('logged_in'))
        {
            $session_data = $this->session->userdata('logged_in');
            $task = $this->task_model->read($task_id);

            if (isset($task[0]))
            {          
                $data = array(        
                    'id' => $task[0]->id,
                    'task_name' => $task[0]->task_name,
                    'task_description' => $task[0]->task_description,
                    'task_start_date' => $task[0]->task_start_date,
                    'task_end_date' => $task[0]->task_end_date,
                    'effort_estimate_hours' => $task[0]->effort_estimate_hours,
                    'project_period_id' => $task[0]->project_period_id,
                    'task_type_id' => $task[0]->task_type_id,
                    'status_id' => $task[0]->status_id
                );

                $data['error_message'] = $this->session->flashdata('$error_message');

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
                $project = $this->project_model->read($project_id);
                $projectperiod = $this->project_period_model->read($currentprojectperiod_id);

                $data['main_content'] = 'task/task_view';
                $data['pagetitle'] = $project[0]->project_name . ', ' . 
                        $projectperiod[0]->period_name . ': ' . $this->lang->line('title_edit_task');
                $data['add'] = FALSE;             
                $data['login_user_id'] = $session_data['user_id'];
                $data['login_id'] = $session_data['id'];
                $this->load->view('template', $data);
            }

            else 
            {
                // error message if not found and redirected to index
                // uses flash data for error_message
                $this->session->set_flashdata('$error_message', $error_message);
                redirect('task/index/' . $project_id . '/' . $currentprojectperiod_id);
            }            
        }
        else
        {
            redirect('login','refresh');
        }
    }
    
    /**
     * Insert or update task into the database.
     * 
     * Inserts or updates the task into the task table. 
     * Validates the input data; task name must exist.
     */    
    public function save()
    {      
        if ($this->session->userdata('logged_in'))
        {
            $session_data = $this->session->userdata('logged_in');
             // data from a page
            $data = array(
                'id' => $this->input->post('txt_id'),
                'project_period_id' => $this->input->post('txt_project_period_id'),
                'task_name' => $this->input->post('txt_task_name'),
                'task_description' => $this->input->post('txt_task_description'),
                'task_start_date' => $this->input->post('txt_task_start_date'),
                'task_end_date' => $this->input->post('txt_task_end_date'),
                'effort_estimate_hours' => $this->input->post('txt_effort_estimate_hours'),
                'status_id' => $this->input->post('ddl_status_id'),
                'task_type_id' => $this->input->post('ddl_task_type_id')            
            );

            $project_id = $this->input->post('txt_project_id');

            $update = FALSE; // assume it it add new
            // is there an id value
            if (strlen($this->input->post("txt_id")) > 0)
            {
                $update = TRUE; // it is update
            }

            $this->load->library('form_validation');
            $this->form_validation->set_error_delimiters('<span class="error">', 
                    '</span>');

            $this->form_validation->set_rules('txt_task_name', 
                    $this->lang->line('label_task_name'), 'trim|required|max_length[255]|xss_clean');
            $this->form_validation->set_rules('txt_task_description', 
                    $this->lang->line('label_task_description'), 'xss_clean');
            $this->form_validation->set_rules('txt_task_start_date', 
                    $this->lang->line('label_task_start_date'), 'xss_clean|check_date');
            $this->form_validation->set_rules('txt_task_end_date', 
                    $this->lang->line('label_task_end_date'), 'xss_clean|check_date');
            $this->form_validation->set_rules('txt_effort_estimate_hours',
                    $this->lang->line('label_effort_estimate_hours'), 'required|xss_clean');

            if ($this->form_validation->run() == FALSE)
            {
                $data['main_content'] = 'task/task_view';
                $data['project_id'] = $project_id;
                $data['error_message'] = $this->session->flashdata('$error_message');
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

                $project = $this->project_model->read($project_id);
                $projectperiod = $this->project_period_model->read($data['project_period_id']);

                if ($update == TRUE)
                {
                    $data['add'] = FALSE; // not show reset button
                    $data['pagetitle'] = $project[0]->project_name . ', ' . 
                        $projectperiod[0]->period_name . ': ' . $this->lang->line('title_edit_task');
                }
                else
                {
                    $data['add'] = TRUE; // show reset button
                    $data['pagetitle'] = $project[0]->project_name . 
                    ', ' . $projectperiod[0]->period_name . ': ' .$this->lang->line('title_add_task');
                }
                $data['login_user_id'] = $session_data['user_id'];
                $data['login_id'] = $session_data['id'];
                $this->load->view('template', $data);

            }

            else
            {
                if (!empty($data['task_start_date']) && !empty($data['task_end_date']))
                {
                    if ($data['task_start_date'] < $data['task_end_date'])
                    {
                        if ($update == TRUE)  // update the database
                        {
                            $data['id'] = intval($this->input->post('txt_id'));
                            $this->task_model->update($data);     
                        }

                        else  // insert new
                        {
                            $this->task_model->create($data);
                        }
                    }
                    else
                    {
                        if ($update == TRUE)
                        {
                            $error_message = $this->lang->line('invalid_dates');
                            $this->session->set_flashdata('$error_message', $error_message);
                            redirect('task/edit/' . $project_id . '/' . $data['project_period_id'] .
                                    '/' . $data['id']);
                        }
                        else
                        {
                            $error_message = $this->lang->line('invalid_dates');
                            $this->session->set_flashdata('$error_message', $error_message);
                            redirect('task/add/' . $project_id . '/' . $data['project_period_id']);
                        }
                    }
                }
                else
                {
                    if ($update == TRUE)  // update the database
                    {
                        $data['id'] = intval($this->input->post('txt_id'));
                        $this->task_model->update($data);     
                    }

                    else  // insert new
                    {
                        $this->task_model->create($data);
                    }
                }

                redirect('task/index/' . $project_id . '/' . $data['project_period_id']);            
            }
        }
        else
        {
            redirect('login','refresh');
        }
    }
    
    /**
     * Delete a task.
     * 
     * Deletes a task using the primary key.
     * 
     */
    public function delete() 
    {
        $id = $this->input->post('txt_id');
        $project_id = $this->input->post('txt_project_id');
        $projectperiod_id = $this->input->post('txt_project_period_id');                
        
        if ($this->task_model->delete(intval($id)) == FALSE)
        {
            $error_message = $this->lang->line('cannot_delete');
            $this->session->set_flashdata('$error_message', $error_message);
            redirect('task/index/' . $project_id . '/' . $projectperiod_id );
        }
        else
        {
            $this->task_model->delete(intval($id));
            redirect('task/index/' . $project_id . '/' . $projectperiod_id );
        }
    }
}
?>