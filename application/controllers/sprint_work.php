<?php

/**
 * @package opix
 * @copyright Oulu University of Applied Sciences(OUAS)
 * @license MIT
 * @version 0.1
 */

/**
 * Class definition for Sprint_work controller extends CI_Controller.
 *
 * Class definition for Sprint_work controller. Controller includes methods
 * to handle Sprint_work listing, inserting, editing and deleting Sprint_works.
 * Extends CI_Controller.
 * 
 * @author Tuukka Kiiskinen, Roni Kokkonen
 * @package opix
 * @subpackage controllers
 * @category Sprint_work
 */

class Sprint_Work extends CI_Controller
{
    /**
     * Constructor of a Sprint_work model.
     * 
     * Constructor of a Sprint_work model. Loads Sprint_work_model,
     * sprint_task_model, person_model and language package.
     */
    public function __construct() 
    {
        parent::__construct();
        $this->load->model('sprint_work_model');
        $this->load->model('sprint_task_model');
        $this->load->model('sprint_backlog_item_model');
        $this->load->model('sprint_backlog_model');
        $this->load->model('sprint_task_person_model');
        $this->load->model('person_model');
        $this->lang->load('sprint_work');
        $this->load->library('session');
    }
    
    /**
     * Listing of all sprint works.
     * 
     * Reads all sprint works from the sprint_work table in the database. 
     * Uses the sprint_work/sprint_works_view.
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
            $data['sprint_task_person'] = $this->sprint_task_person_model->read_by_personid($person_id);       
            $sprint_works = $this->sprint_work_model->read_all($person_id);    
            $data['sprint_works'] = $sprint_works;       
            $data['main_content'] = 'sprint_work/sprint_works_view';        

            if (isset($sprint_works[0]))
            {  
                $person_id = $sprint_works[0]->person_id;
                $sprint_task = $this->sprint_task_model->read($sprint_works[0]->sprint_task_id);
                $sprint_backlog_item = $this->sprint_backlog_item_model->read($sprint_task[0]->sprint_backlog_item_id);
                $sprint_backlog = $this->sprint_backlog_model->read($sprint_backlog_item[0]->sprint_backlog_id);
                $sprint_task_person = $this->sprint_task_person_model->read_by_personid($sprint_works[0]->person_id);
                $data['pagetitle'] = $sprint_backlog[0]->sprint_name . ', ' . $sprint_task_person[0]->surname  . ' ' .
                        $sprint_task_person[0]->firstname . ' ' . $this->lang->line('title_sprint_works');         
            }

            else
            {
                $data['pagetitle'] = $this->lang->line('title_sprint_works');           
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
    
    /**
     * ??
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

                $data['pagetitle'] = $this->lang->line('title_choose_person');
                $data['login_user_id'] = $session_data['user_id'];
                $data['login_id'] = $session_data['id'];
                $data['main_content'] = 'sprint_work/choose_person_view';
                $this->load->view('template', $data);
            }
            else
            {
                $data['login_user_id'] = $session_data['user_id'];
                $data['login_id'] = $session_data['id'];
                $error_message = $this->lang->line('not_allowed');
                $this->session->set_flashdata('$error_message', $error_message);
                redirect('sprint_work/index/' . $data['login_id']);
            }
        }
        else
        {
            redirect('login','refresh');
        }
        
    }
    
    /**
     * Add a sprint work to the database.
     * 
     * Creates an empty sprint work and shows it via sprint_work/sprint_work_view.
     * 
     * @param int $currentpersonid Primary key of the selected person. 
     */
    public function add($currentpersonid)
    {
        if ($this->session->userdata('logged_in'))
        {
            $session_data = $this->session->userdata('logged_in');
            $data = array(
                'id' => '',
                'work_date' => '',
                'work_done_hours' => '',
                'description' => '',
                'work_remaining_hours' => '',
                'sprint_task_id'   => '',
                'person_id' => $currentpersonid
            );

            $sprint_tasks = $this->sprint_task_model->read_person_tasks_in_progress($currentpersonid);

             // helper of this project for dropdown listbox
            $this->load->helper("form_input_helper");        
            // dropdown listbox of statuses task types
            // new text in the beginning of array
            $a = array('id' => "0", 'task_name' => $this->lang->line('select_task') );
            array_unshift($sprint_tasks, $a);
            $tasks = convert_db_result_to_dropdown(
                    $sprint_tasks, 'id', 'task_name');        
            $data['tasks'] = $tasks; 

            $data['main_content'] = 'sprint_work/sprint_work_view';
            $data['pagetitle'] = $this->lang->line('title_add_sprint_work');
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
     * Edit a sprint work.
     * 
     * Reads a sprint work from the database using the primary key. 
     * If no sprint work is found redirects to index with error message in flash data.
     * 
     * @param int $id Selected sprint work 
     * @param int $person_id Selected person. 
     */
     public function edit($person_id, $id)
    {
        if ($this->session->userdata('logged_in'))
        {
            $session_data = $this->session->userdata('logged_in');
            $sprint_work = $this->sprint_work_model->read($id);

            if (isset($sprint_work[0])) 
            {
                $data = array(
                    'id'         => $sprint_work[0]->id,
                    'work_date'    => $sprint_work[0]->work_date,
                    'work_done_hours'  => $sprint_work[0]->work_done_hours,
                    'description'      => $sprint_work[0]->description,
                    'work_remaining_hours'      => $sprint_work[0]->work_remaining_hours,
                    'sprint_task_id'      => $sprint_work[0]->sprint_task_id,
                    'person_id' => $sprint_work[0]->person_id
                );            

                $sprint_task = $this->sprint_task_model->read($data['sprint_task_id']);
                #$data['person_id'] = $person_id;
                $data['main_content'] = 'sprint_work/sprint_work_view';
                $data['pagetitle'] = $sprint_task[0]->task_name . ': ' . $this->lang->line('title_edit_sprint_work');
                $data['add'] = FALSE; // not show reset button
                $data['login_user_id'] = $session_data['user_id'];
                $data['login_id'] = $session_data['id'];
                $this->load->view('template', $data);
            } 

            else 
            {
                $data['person_id'] = $person_id;
                $error_message = $this->lang->line('missing_sprint_work');
                $this->session->set_flashdata('$error_message', $error_message);
                redirect('sprint_work/index/' . $person_id);
            }
        }
        else
        {
            redirect('login','refresh');
        }
    }
    
    /**
     * Insert or update sprint work into the database.
     * 
     * Inserts or updates the sprint work into the sprint_work table. 
     */
    public function save()
    {
        if ($this->session->userdata('logged_in'))
        {
            $session_data = $this->session->userdata('logged_in');
            $data = array(
                'id' => $this->input->post('txt_id'),
                'work_date' => $this->input->post('dtm_work_date'),
                'work_done_hours' => $this->input->post('txt_work_done_hours'),
                'description' => $this->input->post('txt_description'),
                'work_remaining_hours' => $this->input->post('txt_work_remaining_hours'),
                'sprint_task_id' => $this->input->post('ddl_sprint_task_id'),
                'person_id' => $this->input->post('txt_person_id')
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
                    'txt_work_done_hours', 'trim|required|xss_clean');
            $this->form_validation->set_rules(
                    'txt_description', 'trim|max_length[1000]|xss_clean');
            $this->form_validation->set_rules(
                    'txt_work_remaining_hours', 'trim|xss_clean');

            if ($this->form_validation->run() == FALSE) 
            {
                $data['person_id'] = $person_id;
                $data['main_content'] = 'sprint_work/sprint_work_view';
                $data['pagetitle'] = $this->lang->line('title_add_sprint_work');

                if ($update == TRUE)
                {
                    $data['add'] = FALSE; 
                }
                else
                {
                    $data['add'] = TRUE;
                }

                $sprint_tasks = $this->sprint_task_model->read_person_tasks_in_progress($person_id);
                 // helper of this project for dropdown listbox
                $this->load->helper("form_input_helper");        
                // dropdown listbox of statuses task types
                // new text in the beginning of array
                $a = array('id' => "0", 'task_name' => $this->lang->line('select_task') );
                array_unshift($sprint_tasks, $a);
                $tasks = convert_db_result_to_dropdown(
                        $sprint_tasks, 'id', 'task_name');        
                $data['tasks'] = $tasks;
                $data['login_user_id'] = $session_data['user_id'];
                $data['login_id'] = $session_data['id'];
                $this->load->view('template', $data);
            }

            else
            {
                $data['person_id'] = $person_id;
                if ($update == TRUE)  
                {
                    $data['sprint_task_id'] = $this->input->post('txt_sprint_task_id');
                    $data['id'] = intval($this->input->post('txt_id'));
                    $this->sprint_work_model->update($data);     
                }

                else  
                {                
                    $this->sprint_work_model->create($data);
                }

                redirect('sprint_work/index/' . $person_id);
            }
        }
        else
        {
            redirect('login','refresh');
        }
    }
    
     /**
     * Delete a sprint work.
     * 
     * Deletes a sprint work using the primary key.
     * 
     */
    public function delete()
    {
        $id = $this->input->post('txt_id');
        $person_id = $this->input->post('txt_person_id');
        $data['currentpersonid'] = $person_id;
        $this->sprint_work_model->delete(intval($id));
        redirect('sprint_work/index/' . $person_id);
    }
    
}
?>
