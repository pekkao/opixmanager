<?php

/**
 * @package opix
 * @copyright Oulu University of Applied Sciences(OUAS)
 * @license MIT
 * @version 0.1
 */

/**
 * Class definition for Task_work controller extends CI_Controller.
 *
 * Class definition for Task_work controller. Controller includes methods
 * to handle Task_work listing, inserting, editing and deleting Task_works.
 * Extends CI_Controller.
 * 
 * @author Tuukka Kiiskinen, Roni Kokkonen
 * @package opix
 * @subpackage controllers
 * @category Task_work
 */

class Task_Work extends CI_Controller
{
    /**
     * Constructor of a Task_work model.
     * 
     * Constructor of a Task_work model. Loads Task_work_model,
     * task_model, person_model and language package.
     */
    public function __construct() 
    {
        parent::__construct();
        $this->load->model('task_work_model');
        $this->load->model('task_model');
        $this->load->model('project_period_model');
        $this->load->model('task_person_model');
        $this->load->model('person_model');
        $this->lang->load('task_work');
        $this->load->library('session');
    }
    
    /**
     * Listing of all task works.
     * 
     * Reads all task works from the task_work table in the database. 
     * Uses the task_work/task_works_view.
     * 
     * @param int id primary key of the selected person, default value 0.
     * 
     */
    public function index($person_id = 0)
    {  
        if ($this->session->userdata('logged_in'))
        {
            $session_data = $this->session->userdata('logged_in');
            if ($person_id == 0)
            {
                $person_id = $this->input->post('ddl_person');
            }

            $data['task_person'] = $this->task_person_model->read_by_personid($person_id);  
            $task_works = $this->task_work_model->read_all($person_id);    
            $data['task_works'] = $task_works;       
            $data['main_content'] = 'task_work/task_works_view';        

            if (isset($task_works[0]))
            {  
                $person_id = $task_works[0]->person_id;
                $task = $this->task_model->read($task_works[0]->task_id);
                $project_period = $this->project_period_model->read($task[0]->project_period_id);
                $task_person = $this->task_person_model->read_by_personid($task_works[0]->person_id);
                $data['pagetitle'] = $project_period[0]->period_name . ', ' . $task_person[0]->surname  . ' ' .
                        $task_person[0]->firstname . ' ' . $this->lang->line('title_task_works');         
            }

            else
            {
                $data['pagetitle'] = $this->lang->line('title_task_works');           
            }
            $data['currentpersonid'] = $person_id;
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
     * Reads persons and converts them into a dropdown list
     */
    public function choose_person()
    {
        if ($this->session->userdata('logged_in'))
        {
            $session_data = $this->session->userdata('logged_in');
            if ($this->session->userdata('account_type') == 1)
            {
                $data['selected_person'] = 0;
                $persons_from_db = $this->person_model->read_names();
                $this->load->helper("form_input_helper");
                $persons = convert_db_result_to_dropdown(
                $persons_from_db, 'id', 'name');        
                $data['persons'] = $persons;
                $data['login_user_id'] = $session_data['user_id'];
                $data['login_id'] = $session_data['id'];
                $data['pagetitle'] = $this->lang->line('title_choose_person');

                $data['main_content'] = 'task_work/choose_person_view';
                $this->load->view('template', $data);
            }
            else
            {
                $data['login_user_id'] = $session_data['user_id'];
                $data['login_id'] = $session_data['id'];
                $error_message = $this->lang->line('not_allowed');
                $this->session->set_flashdata('$error_message', $error_message);
                redirect('task_work/index/' . $data['login_id']);
            }
        }
        else
        {
            redirect('login','refresh');
        }
        
    }
    
    /**
     * Add a task work to the database.
     * 
     * Creates an empty task work and shows it via task_work/task_work_view.
     * 
     * @param int $currentpersonid Primary key of the person. 
     */
    public function add($currentpersonid)
    {
        if ($this->session->userdata('logged_in'))
        {
            $session_data = $this->session->userdata('logged_in');
            $data = array(
                'id' => '',
                'work_hours' => '',
                'description' => '',
                'task_id'   => '',
                'work_date' => '',
                'person_id' => $currentpersonid
            );

            $tasks = $this->task_model->read_person_tasks_in_progress($currentpersonid);

             // helper of this project for dropdown listbox
            $this->load->helper("form_input_helper");        
            // dropdown listbox of statuses task types
            // new text in the beginning of array
            $a = array('id' => "0", 'task_name' => $this->lang->line('select_task') );
            array_unshift($tasks, $a);
            $task = convert_db_result_to_dropdown(
                    $tasks, 'id', 'task_name');        
            $data['task'] = $task; 

            $data['main_content'] = 'task_work/task_work_view';
            $data['pagetitle'] = $this->lang->line('title_add_task_work');
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
     * Edit a task work.
     * 
     * Reads a task work from the database using the primary key. 
     * If no task work is found redirects to index with error message in flash data.
     * 
     * @param int $id Primary key of a task work
     * @param int $person_id Primary key of selected person. 
     */
     public function edit($person_id, $id)
    {
        if ($this->session->userdata('logged_in'))
        {
            $session_data = $this->session->userdata('logged_in');
            $task_work = $this->task_work_model->read($id);

            if (isset($task_work[0])) 
            {
                $data = array(
                    'id'         => $task_work[0]->id,
                    'work_hours'  => $task_work[0]->work_hours,
                    'description'      => $task_work[0]->description,
                    'task_id'      => $task_work[0]->task_id,
                    'person_id' => $task_work[0]->person_id,
                    'work_date' => $task_work[0]->work_date
                );            

                $task = $this->task_model->read($data['task_id']);              
                $data['main_content'] = 'task_work/task_work_view';
                $data['pagetitle'] = $task[0]->task_name . ': ' . $this->lang->line('title_edit_task_work');
                $data['add'] = FALSE; // not show reset button
                $data['login_user_id'] = $session_data['user_id'];
                $data['login_id'] = $session_data['id'];
                $this->load->view('template', $data);
            } 

            else 
            {
                $data['person_id'] = $person_id;
                $error_message = $this->lang->line('missing_task_work');
                $this->session->set_flashdata('$error_message', $error_message);
                redirect('task_work/index/' . $person_id);
            }
        }
        else
        {
            redirect('login','refresh');
        }
    }
    
    /**
     * Insert or update task work into the database.
     * 
     * Inserts or updates the task work into the task_work table. 
     */
    public function save()
    {
        if ($this->session->userdata('logged_in'))
        {
            $session_data = $this->session->userdata('logged_in');
            $data = array(
                'id' => $this->input->post('txt_id'),
                'work_hours' => $this->input->post('txt_work_hours'),
                'description' => $this->input->post('txt_description'),
                'task_id' => $this->input->post('ddl_task_id'),
                'person_id' => $this->input->post('txt_person_id'),
                'work_date' => $this->input->post('dtm_work_date')
            );

            $person_id = $this->input->post('txt_person_id');

            $update = FALSE; 

            if (strlen($this->input->post("txt_id")) > 0)
            {
                $update = TRUE; 
            }

            $this->load->library('form_validation');
            $this->form_validation->set_error_delimiters('<span class="error">', '</span>');

            $this->form_validation->set_rules(
                    'dtm_work_date', $this->lang->line('missing_work_date'), 'required|xss_clean|check_date');
            $this->form_validation->set_rules(
                    'txt_work_hours', $this->lang->line('missing_work_hours'), 'trim|required|xss_clean');
            $this->form_validation->set_rules(
                    'txt_description', 'trim|max_length[1000]|xss_clean');

            if ($this->form_validation->run() == FALSE) 
            {
                $data['person_id'] = $person_id;
                $data['main_content'] = 'task_work/task_work_view';
                $data['pagetitle'] = $this->lang->line('title_add_task_work');

                if ($update == TRUE)
                {
                    $data['add'] = FALSE; 
                }
                else
                {
                    $data['add'] = TRUE;
                }

                $tasks = $this->task_model->read_person_tasks_in_progress($person_id);                
                 // helper of this project for dropdown listbox
                $this->load->helper("form_input_helper");        
                // dropdown listbox of statuses task types
                // new text in the beginning of array
                $a = array('id' => "0", 'task_name' => $this->lang->line('select_task') );
                array_unshift($tasks, $a);
                $task = convert_db_result_to_dropdown(
                        $tasks, 'id', 'task_name');        
                $data['task'] = $task; 
                $data['login_user_id'] = $session_data['user_id'];              
                $data['login_id'] = $session_data['id'];
                $this->load->view('template', $data);
            }

            else
            {
                $data['person_id'] = $person_id;
                if ($update == TRUE)  
                {
                    $data['task_id'] = $this->input->post('txt_task_id');
                    $data['id'] = intval($this->input->post('txt_id'));
                    $this->task_work_model->update($data);     
                }

                else  
                {                
                    $this->task_work_model->create($data);
                }

                redirect('task_work/index/' . $person_id);
            }
        }
        else
        {
            redirect('login','refresh');
        }
    }
    
     /**
     * Delete a task work.
     * 
     * Deletes a task work using the primary key.
     * 
     */
    public function delete()
    {
        $id = $this->input->post('txt_id');
        $person_id = $this->input->post('txt_person_id');
        $data['currentpersonid'] = $person_id;
        $this->task_work_model->delete(intval($id));
        redirect('task_work/index/' . $person_id);
    }
    
}
?>
