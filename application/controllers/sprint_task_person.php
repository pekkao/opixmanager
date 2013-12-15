<?php

/**
 * @package opix
 * @copyright Oulu University of Applied Sciences(OUAS)
 * @license MIT
 * @version 0.1
 */

/**
 * Class definition for Sprint_task_person controller extends CI_Controller.
 *
 * Class definition for Sprint_task_person controller. Controller includes methods
 * to handle Sprint_task_person listing, inserting, editing and deleting Sprint_task_persons.
 * Extends CI_Controller.
 * 
 * @author Tuukka Kiiskinen, Roni Kokkonen
 * @package opix
 * @subpackage controllers
 * @category Sprint_task_person
 */

class Sprint_Task_Person extends CI_Controller
{
    /**
     * Constructor of a Sprint task person model.
     * 
     * Constructor of a Sprint task person model. Loads Sprint_task_person_model,
     * sprint_task_model, person_model, project_staff_model, project_model,
     * sprint_backlog_item_model, sprint_backlog_model and language package.
     */
    public function __construct() 
    {
        parent::__construct();
        $this->load->model('sprint_task_person_model');
        $this->load->model('sprint_task_model');
        $this->load->model('person_model');
        $this->load->model('project_staff_model');
        $this->load->model('project_model');
        $this->load->model('sprint_backlog_item_model');
        $this->load->model('sprint_backlog_model');
        $this->lang->load('sprint_task_person');
        $this->load->library('session');      
    }
    
    /**
     * Listing of all sprint task persons.
     * 
     * Reads all sprint task persons or of a specific sprint task
     * from the sprint_task_person table in the database. 
     * Uses the sprint task persons.
     * 
     * @param int $sprinttaskid Selected sprinttaskid, default is zero. 
     */
    public function index($project_id = 0, $sprinttaskid = 0) 
    {
        if ($this->session->userdata('logged_in'))
        {
            $session_data = $this->session->userdata('logged_in');
            $data = array(
                'id' => '',
                'sprint_task_id' => '',
                'person_id' => '',
                'estimate_work_effort_hours' => '',
                'firstname' => '',
                'surname' => ''
            );

            $data['project_id'] = $project_id;
            $data['sprint_task_persons'] = $this->sprint_task_person_model->read_all($sprinttaskid);
            $data['currentid'] = $sprinttaskid;
            $data['main_content'] = 'sprint_task_person/sprint_task_persons_view';

            $sprint_task = $this->sprint_task_model->read($sprinttaskid);
            $data['sprint_task_id'] = $sprint_task[0]->sprint_backlog_item_id;
            $sprint_backlog_item = $this->sprint_backlog_item_model->read($sprint_task[0]->sprint_backlog_item_id);
            $data['sprint_backlog_id'] = $sprint_backlog_item[0]->sprint_backlog_id;
            $sprint_backlog = $this->sprint_backlog_model->read($sprint_backlog_item[0]->sprint_backlog_id);
            $data['product_backlog_id'] = $sprint_backlog[0]->product_backlog_id;
            $data['sprint_backlog_item_id'] = $sprint_backlog[0]->id;

            $project = $this->project_model->read($project_id);

            if ($sprinttaskid > 0)
            {
                $sprinttask = $this->sprint_task_model->read($sprinttaskid);
                $data['pagetitle'] = $project[0]->project_name . ', ' . $sprinttask[0]->task_name . ': ' .
                        $this->lang->line('title_sprint_task_persons');
            }

            else
            {
                $data['pagetitle'] = $this->lang->line('title_sprint_task_persons');
            }

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
     * Add a sprint_task_person to the database.
     * 
     * Creates a sprint_task_person and shows it via sprint_task_person_view.
     */
    public function add($project_id, $id)
    {
        if ($this->session->userdata('logged_in'))
        {
            $session_data = $this->session->userdata('logged_in');
            $task_persons_not_in_sprint_task = $this->sprint_task_person_model->read_not_task_persons($id);

            $tp = $this->project_staff_model->read_project_staffs($project_id);

            // an empty array
            $task_persons = array();

            // fill the array with sprint task person data + not selected checkbox
            if (isset ($task_persons_not_in_sprint_task[0])) // is there any
            {         
                foreach ($task_persons_not_in_sprint_task as $one_task_person)
                {
                    if (isset ($tp[0]))
                    {
                        foreach ($tp as $one_tp)
                        {
                            if ($one_tp->person_id == $one_task_person->person_id)
                            {
                                $task_person['person_id'] = $one_task_person->person_id;
                                $task_person['firstname'] = $one_task_person->firstname;
                                $task_person['surname'] = $one_task_person->surname;
                                $task_person['selected'] = FALSE;
                                $task_persons[] = $task_person;
                            }
                        }
                    }
                }          
            }

            $data['project_id'] = $project_id;
            $data['estimate_work_effort_hours'] = '';       
            $data['add'] = TRUE;        
            $data['task_persons'] = $task_persons;       
            $data['sprinttask_id'] = $id;

            if ($id > 0)
            {
                $sprinttask = $this->sprint_task_model->read($id);
                $data['pagetitle'] = $sprinttask[0]->task_name . ': ' .
                        $this->lang->line('title_add_sprint_task_person');
            }

            else 
            {
                $data['pagetitle'] = $this->lang->line('title_add_sprint_task_person');
            }

            $data['login_user_id'] = $session_data['user_id'];
            $data['login_id'] = $session_data['id'];
            $data['error_message'] = $this->session->flashdata('$error_message');
            $data['main_content'] = 'sprint_task_person/sprint_task_person_view';
            $this->load->view('template', $data);
        }
        else
        {
            redirect('login','refresh');
        }
    }
    
    /**
     * Edit sprint task person's estimate work effort hours.
     * 
     * Edit sprint task person's estimate work effort hours.
     * @param type $id primary key person_id.
     */
    
    public function edit($project_id, $id, $sprinttask_id)
    {
        if ($this->session->userdata('logged_in'))
        {
            $session_data = $this->session->userdata('logged_in');
            $sprint_task_person = $this->sprint_task_person_model->read_by_person($id, $sprinttask_id);

            if (isset($sprint_task_person[0])) 
            {
                $data = array(
                    'id' => $sprint_task_person[0]->id,
                    'sprint_task_id' => $sprint_task_person[0]->sprint_task_id,
                    'person_id' => $sprint_task_person[0]->person_id,
                    'estimate_work_effort_hours' => $sprint_task_person[0]->estimate_work_effort_hours,
                    'firstname' => $sprint_task_person[0]->firstname,
                    'surname' => $sprint_task_person[0]->surname              
                );

                $data['sprinttask_id'] = $sprinttask_id;
                $data['project_id'] = $project_id;
                $data['main_content'] = 'sprint_task_person/sprint_task_person_view';
                $data['pagetitle'] = $this->lang->line('title_edit_sprint_task_person');
                $data['add'] = FALSE; // not show reset button
                $data['error_message'] = $this->session->flashdata('$error_message');
                $data['login_user_id'] = $session_data['user_id'];
                $data['login_id'] = $session_data['id'];
                $this->load->view('template', $data);
            } 

            else 
            {
                $error_message = $this->lang->line('missing_sprint_task_person');
                $this->session->set_flashdata('$error_message', $error_message);
                redirect('sprint_task_person/index/' . $project_id . '/' . $sprinttask_id);
            }
        }
        else
        {
            redirect('login','refresh');
        }
    }
    
    /**
     * Insert sprint_task_person into the database.
     * 
     * Inserts the sprint_task_person into the sprint_task_person table. 
     */
     public function save()
     {
        $project_id = $this->input->post('txt_project_id');
        $sprinttask_id = $this->input->post('sprint_task_id');
        $new_task_persons = $this->input->post('chk_new_task_person');
        $ewehs = $this->input->post('txt_eweh');
        $sprint_task = $this->sprint_task_model->read($sprinttask_id);
        
        $sprint_task_person = $this->sprint_task_person_model->read_eweh($sprinttask_id);
        
        if (isset($sprint_task[0])) 
        {
            $data2 = array(
                'effort_estimate_hours' => $sprint_task[0]->effort_estimate_hours,
            );
            $a = 0;
            if (isset($sprint_task_person[0]))
            {
                while ($a < count($sprint_task_person))
                {
                    $data2['effort_estimate_hours'] = $data2['effort_estimate_hours'] - $sprint_task_person[$a]->estimate_work_effort_hours;
                    $a++;
                }
            }
        }      
            if (!empty($new_task_persons)) 
            {
                $hours = 0;
                $h = 0;
                $i = 0;
                $j = -1;
                
                while ($h < count($ewehs))
                {
                    if (!empty($ewehs[$h]))
                    {
                        $hours = $hours + $ewehs[$h];
                    }
                    $h++;
                }
                
                if ($hours <= $data2['effort_estimate_hours'])
                {
                    foreach ($new_task_persons as $task_person)
                    {

                        $i = $j +1;
                        while ($i < count($ewehs))
                        {                       
                            if (!empty($ewehs[$i]))
                            {
                                $data = array(                                  
                                    'sprint_task_id'  => $sprinttask_id,
                                    'person_id' => $task_person,
                                    'estimate_work_effort_hours' => $ewehs[$i]
                                );
                                $j = $i;
                                $i = count($ewehs);
                                $this->sprint_task_person_model->create($data);
                            }
                            $i++;
                        }
                    }
                    redirect('sprint_task_person/index/' . $project_id . '/' . $sprinttask_id);
                }
                
                else
                {
                    $error_message = $this->lang->line('invalid_hours') . '</br>' .
                        $this->lang->line('remaining_hours') .
                        $data2['effort_estimate_hours'];
                    $data['error_message'] = $this->session->set_flashdata('$error_message', $error_message);
                    redirect('sprint_task_person/add/' . $project_id . '/' . $sprinttask_id);
                }
            }
                
    }
    
    /**
     * Edit selected person's estimate work effort hours.
     * 
     * Edit selected person's estimate work effort hours.
     */
    
    public function save_edit()
     {     
        $project_id = $this->input->post('txt_project_id');
        $sprint_task_id = $this->input->post('sprint_task_id');

        $data = array(
            'person_id' => $this->input->post('person_id'),
            'sprint_task_id' => $this->input->post('sprint_task_id'),
            'estimate_work_effort_hours'=>$this->input->post('txt_eweh')
        );

        $sprint_task = $this->sprint_task_model->read($data['sprint_task_id']);

        $sprint_task_person = $this->sprint_task_person_model->read_eweh($data['sprint_task_id']);       

        if (isset($sprint_task[0])) 
        {
            $data2 = array(
                'effort_estimate_hours' => $sprint_task[0]->effort_estimate_hours,
            );
            $a = 0;
            if (isset($sprint_task_person[0]))
            {
                while ($a < count($sprint_task_person))
                {
                    if ($sprint_task_person[$a]->person_id != $data['person_id'])
                    {
                        $data2['effort_estimate_hours'] = $data2['effort_estimate_hours'] - $sprint_task_person[$a]->estimate_work_effort_hours;
                        $a++;
                    }
                    else
                    {
                        $a++;
                    }
                }
            }
        }        

        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<span class= "error">', '</span>');

        $this->form_validation->set_rules(
             'txt_eweh', $this->lang->line('missing_eweh'), 'trim|required|xss_clean');

        if ($this->form_validation->run() == FALSE)
        {
            $data['project_id'] = $project_id;
            $data['pagetitle'] = $this->lang->line('title_edit_sprint_task_person');
            redirect('sprint_task_person/edit/' . $project_id . '/' . $data['person_id'] . '/' .
                        $sprint_task_id);
        }

        else
        {
            if ($data['estimate_work_effort_hours'] <= $data2['effort_estimate_hours'])
            {
                $this->sprint_task_person_model->update($data);
                redirect('sprint_task_person/index/' . $project_id . '/' . $data['sprint_task_id']);
            }
            else
            {
                $data['project_id'] = $project_id;
                $data['pagetitle'] = $this->lang->line('title_edit_sprint_task_person');
                $error_message = $this->lang->line('invalid_hours') . '</br>' .
                    $this->lang->line('remaining_hours') .
                    $data2['effort_estimate_hours'];
                $data['error_message'] = $this->session->set_flashdata('$error_message', $error_message);
                redirect('sprint_task_person/edit/' . $project_id . '/' . $data['person_id'] . '/' .
                        $sprint_task_id);
            }
        }
         
     }
     
    /**
     * Delete a sprint_task_person.
     * 
     * @param int $id Primary key of the sprint_task_person. 
     */
    public function delete()
    {
        $id = $this->input->post('txt_id');
        $project_id = $this->input->post('txt_project_id');
        $sprinttask_id = $this->input->post('txt_sprint_task_id');
        $this->sprint_task_person_model->delete(intval($id));
        redirect('sprint_task_person/index/' . $project_id . '/' . $sprinttask_id );
    } 
     
}

?>