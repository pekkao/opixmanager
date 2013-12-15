<?php

/**
 * @package opix
 * @copyright Oulu University of Applied Sciences(OUAS)
 * @license MIT
 * @version 0.1
 */

/**
 * Class definition for Task_person controller extends CI_Controller.
 *
 * Class definition for Task_person controller. Controller includes methods
 * to handle Task_person listing, inserting, editing and deleting Task_persons.
 * Extends CI_Controller.
 * 
 * @author Tuukka Kiiskinen, Roni Kokkonen
 * @package opix
 * @subpackage controllers
 * @category Task_person
 */

class Task_Person extends CI_Controller
{
    /**
     * Constructor of a Task person model.
     * 
     * Constructor of a Task person model. Loads Task_person_model,
     * task_model, person_model, project_staff_model, project_model,
     * and language package.
     */
    public function __construct() 
    {
        parent::__construct();
        $this->load->model('task_person_model');
        $this->load->model('task_model');
        $this->load->model('person_model');
        $this->load->model('project_staff_model');
        $this->load->model('project_model');
        $this->load->model('project_period_model');
        $this->lang->load('task_person');
        $this->load->library('session');
    }
    
    /**
     * Listing of all task persons.
     * 
     * Reads all task persons or of a specific task
     * from the task_person table in the database. 
     * Uses the task persons.
     * 
     * @param int $taskid Selected taskid, default is zero. 
     */
    public function index($project_id = 0, $taskid = 0) 
    {
        if ($this->session->userdata('logged_in'))
        {
            $session_data = $this->session->userdata('logged_in');
            $data = array(
                'id' => '',
                'task_id' => '',
                'person_id' => '',
                'effort_estimate_hours' => '',
                'start_date' => '',
                'end_date' => ''
            );

            $data['project_id'] = $project_id;
            $data['task_persons'] = $this->task_person_model->read_all($taskid);
            $data['currentid'] = $taskid;
            $data['main_content'] = 'task_person/task_persons_view';                

            $task = $this->task_model->read($taskid);
            $data['project_period_id'] = $task[0]->project_period_id;

            $project = $this->project_model->read($project_id);

            if ($taskid > 0)
            {
                $task = $this->task_model->read($taskid);
                $data['pagetitle'] = $project[0]->project_name . ', ' . $task[0]->task_name . ': ' .
                        $this->lang->line('title_task_persons');
            }

            else
            {
                $data['pagetitle'] = $this->lang->line('title_task_persons');
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
     * Add a task_person to the database.
     * 
     * Creates a task_person and shows it via task_person_view.
     */
    public function add($project_id, $id)
    {
        if ($this->session->userdata('logged_in'))
        {
            $session_data = $this->session->userdata('logged_in');
            $task_persons_not_in_task = $this->task_person_model->read_not_task_persons($id);

            $tp = $this->project_staff_model->read_project_staffs($project_id);

            // an empty array
            $task_persons = array();

            // fill the array with task person data + not selected checkbox
            if (isset ($task_persons_not_in_task[0])) // is there any
            {         
                foreach ($task_persons_not_in_task as $one_task_person)
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
            $data['effort_estimate_hours'] = '';
            $data['start_date'] = '';
            $data['end_date'] = '';
            $data['add'] = TRUE;        
            $data['task_persons'] = $task_persons;       
            $data['task_id'] = $id;

            if ($id > 0)
            {
                $task = $this->task_model->read($id);
                $data['pagetitle'] = $task[0]->task_name . ': ' .
                        $this->lang->line('title_add_task_person');
            }

            else 
            {
                $data['pagetitle'] = $this->lang->line('title_add_task_person');
            }

            $data['login_user_id'] = $session_data['user_id'];
            $data['login_id'] = $session_data['id'];
            $data['error_message'] = $this->session->flashdata('$error_message');
            $data['main_content'] = 'task_person/task_person_view';
            $this->load->view('template', $data);
        }
        else
        {
            redirect('login','refresh');
        }
    }
    
    /**
     * Edit task person's effort estimate hours.
     * 
     * Edit task person's effort estimate hours.
     * @param type $id primary key person_id.
     */
    
    public function edit($project_id, $id, $task_id)
    {
        if ($this->session->userdata('logged_in'))
        {
            $session_data = $this->session->userdata('logged_in');
            $task_person = $this->task_person_model->read_by_person($id, $task_id);

            if (isset($task_person[0])) 
            {
                $data = array(
                    'id' => $task_person[0]->id,
                    'task_id' => $task_person[0]->task_id,
                    'person_id' => $task_person[0]->person_id,
                    'effort_estimate_hours' => $task_person[0]->effort_estimate_hours,
                    'start_date' => $task_person[0]->start_date,
                    'end_date' => $task_person[0]->end_date,
                    'firstname' => $task_person[0]->firstname,
                    'surname' => $task_person[0]->surname              
                );

                $data['project_id'] = $project_id;
                $data['main_content'] = 'task_person/task_person_view';
                $task = $this->task_model->read($task_id);
                $data['pagetitle'] = $task[0]->task_name . ': ' .
                        $this->lang->line('title_edit_task_person');
                $data['add'] = FALSE; // not show reset button
                $data['error_message'] = $this->session->flashdata('$error_message');
                $data['login_user_id'] = $session_data['user_id'];
                $data['login_id'] = $session_data['id'];
                $this->load->view('template', $data);
            } 

            else 
            {
                $error_message = $this->lang->line('missing_task_person');
                $this->session->set_flashdata('$error_message', $error_message);
                redirect('task_person/index/' . $project_id . '/' . $data['task_id']);
            }
        }
        else
        {
            redirect('login','refresh');
        }
    }
    
    /**
     * Insert task_person into the database.
     * 
     * Inserts the task_person into the task_person table. 
     */
     public function save()
    {
        $project_id = $this->input->post('txt_project_id');
        $task_id = $this->input->post('txt_task_id');
        
        $new_task_persons = $this->input->post('chk_new_task_person'); 
        // All entered effort estimate hours in a table. ($eehs)
        $eehs = $this->input->post('txt_eeh');
        $start_dates = $this->input->post('dtm_start_date');
        $end_dates = $this->input->post('dtm_end_date');       
        
        $task = $this->task_model->read_task($task_id);

        $task_person = $this->task_person_model->read_eeh($task_id);                                

        if (isset($task[0])) 
        {
            $data2 = array(
                'effort_estimate_hours' => $task[0]->effort_estimate_hours,
            );
            $a = 0;
            if (isset($task_person[0]))
            {
                while ($a < count($task_person))
                {
                    $data2['effort_estimate_hours'] = $data2['effort_estimate_hours'] - $task_person[$a]->effort_estimate_hours;
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

                while ($h < count($eehs))
                {
                    if (!empty($eehs[$h]))
                    {
                        if (is_numeric($eehs[$h]))
                        {
                            $hours = $hours + $eehs[$h];
                        }
                        else
                        {
                            $error_message = $this->lang->line('invalid_eeh');
                            $this->session->set_flashdata('$error_message', $error_message);
                            redirect('task_person/add/' . $project_id . '/' . $task_id);
                        }
                    }
                    $h++;
                }                

                if ($hours <= $data2['effort_estimate_hours'])
                {
                    foreach ($new_task_persons as $task_person)
                    {

                        $i = $j +1;
                        while ($i < count($eehs))
                        {                       
                            if (!empty($eehs[$i]))
                            {
                                $data = array(                               
                                    'task_id'  => $task_id,
                                    'person_id' => $task_person,
                                    'effort_estimate_hours' => $eehs[$i],
                                    'start_date' => $start_dates[$i],
                                    'end_date' => $end_dates[$i]
                                );
                                if (!empty($data['start_date']) && !empty($data['end_date']))
                                {
                                    if ($data['start_date'] < $data['end_date'])
                                    {
                                        $j = $i;
                                        $i = count($eehs);
                                        $this->task_person_model->create($data);
                                    }
                                    else
                                    {
                                        $error_message = $this->lang->line('invalid_dates');
                                        $data['error_message'] = $this->session->set_flashdata('$error_message', $error_message);
                                        redirect('task_person/add/' . $project_id . '/' . $task_id);
                                    }
                                }
                                else
                                {
                                    $j = $i;
                                    $i = count($eehs);
                                    $this->task_person_model->create($data);
                                }                               
                            }
                            $i++;
                        }
                    }
                    redirect('task_person/index/' . $project_id . '/' . $task_id);
                }

                else
                {
                    $error_message = $this->lang->line('invalid_hours') . '</br>' .
                        $this->lang->line('remaining_hours') .
                        $data2['effort_estimate_hours'];
                    $data['error_message'] = $this->session->set_flashdata('$error_message', $error_message);
                    redirect('task_person/add/' . $project_id . '/' . $task_id);
                }
            }
            else
            {
                redirect('task_person/add/' . $project_id . '/' . $task_id);
            }
          
                
    }
    
    /**
     * Edit selected person's effort estimate hours.
     *     
     */
    
    public function save_edit()
     {     
        $project_id = $this->input->post('txt_project_id');
        
         $data = array(
             'person_id' => $this->input->post('person_id'),
             'task_id' => $this->input->post('task_id'),
             'effort_estimate_hours' => $this->input->post('txt_eeh'),
             'start_date' => $this->input->post('dtm_start_date'),
             'end_date' => $this->input->post('dtm_end_date')
         );
         
         $task = $this->task_model->read($data['task_id']);

         $task_person = $this->task_person_model->read_eeh($data['task_id']);                 

         if (isset($task[0])) 
         {
            $data2 = array(
                'effort_estimate_hours' => $task[0]->effort_estimate_hours,
            );
            $a = 0;
            if (isset($task_person[0]))
            {
                while ($a < count($task_person))
                {
                    if ($task_person[$a]->person_id != $data['person_id'])
                    {
                        $data2['effort_estimate_hours'] = $data2['effort_estimate_hours'] - $task_person[$a]->effort_estimate_hours;
                        $a++;
                    }
                    else
                    {
                        $a++;
                    }
                }
            }
        }
            
            if ($data['effort_estimate_hours'] <= $data2['effort_estimate_hours'])
            {
                if (!empty($data['start_date']) && !empty($data['end_date']))
                {
                    if ($data['start_date'] < $data['end_date'])
                    {
                        $this->task_person_model->update($data);
                        redirect('task_person/index/' . $project_id . '/' . $data['task_id']);
                    }
                    else
                    {
                        $task = $this->task_model->read($data['task_id']);
                         $data['pagetitle'] = $task[0]->task_name . ': ' .
                                $this->lang->line('title_edit_task_person');
                        $error_message = $this->lang->line('invalid_dates');
                        $data['error_message'] = $this->session->set_flashdata('$error_message', $error_message);
                        redirect('task_person/edit/' . $project_id . '/' . $data['person_id'] . '/' .
                        $data['task_id']);
                    }
                }
                else
                {
                    $this->task_person_model->update($data);
                    redirect('task_person/index/' . $project_id . '/' . $data['task_id']);
                }
                
            }
            else
            {
                $data['project_id'] = $project_id;
                $task = $this->task_model->read($data['task_id']);
                 $data['pagetitle'] = $task[0]->task_name . ': ' .
                        $this->lang->line('title_edit_task_person');
                $error_message = $this->lang->line('invalid_hours') . '</br>' .
                    $this->lang->line('remaining_hours') .
                    $data2['effort_estimate_hours'];
                $data['error_message'] = $this->session->set_flashdata('$error_message', $error_message);
                redirect('task_person/edit/' . $project_id . '/' . $data['person_id'] . '/' .
                        $data['task_id']);
            }
        // }
         
     }
     
    /**
     * Delete a task_person.
     * 
     * @param int $id Primary key of the task_person. 
     */
    public function delete()
    {
        $id = $this->input->post('txt_id');
        $project_id = $this->input->post('txt_project_id');
        $task_id = $this->input->post('txt_task_id');
        $this->task_person_model->delete(intval($id));
        redirect('task_person/index/' . $project_id . '/' . $task_id );
    } 
     
}

?>