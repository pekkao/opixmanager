<?php

/**
 * @package opix
 * @copyright Oulu University of Applied Sciences(OUAS)
 * @license MIT
 * @version 0.1
 */

/**
 * Class definition for Project_period controller extends CI_Controller.
 *
 * Class definition for Project_period controller. Controller includes methods
 * to handle Project_period listing, inserting, editing and deleting Project_periods.
 * Extends CI_Controller.
 * 
* @package	opix
* @subpackage   Controllers
* @category	project_period
* @author	Hannu Raappana, Roni Kokkonen, Tuukka Kiiskinen
*/


Class Project_Period extends CI_Controller
{    
    /**
     * Constructor of a Project_period model.
     * 
     * Constructor of a Project_period model. Loads project_period_model,
     * project_model, task_model and language package.
     */
    public function __construct()
    {
        parent::__construct();       
        $this->load->model('project_period_model');
        $this->load->model('project_model');
        $this->load->model('task_model');
        $this->lang->load('project_period');
        $this->load->library('session');

    }
    
    /**
     * Listing of all project periods.
     * 
     * Reads all project periods from the project_period table in the database. 
     * Uses the project_period/project_periods_view.
     * 
     */
    public function index($project_id = 0)
    {
        if ($this->session->userdata('logged_in'))
        {
            $session_data = $this->session->userdata('logged_in');
            $data = array(           
                'id' => '',
                'period_name' => '',
                'period_description' => '',
                'period_start_date' => '',
                'period_end_date' => '',
                'milestone' => '',
                'project_id' => ''            
            );

            $data['project_periods'] = $this->project_period_model->read_all($project_id);
            $data['currentproject_id'] = $project_id;
            $data['main_content'] = 'project_period/project_periods_view';

            if ($project_id > 0)
            {
                $project = $this->project_model->read($project_id);
                $data['pagetitle'] = $project[0]->project_name  . ': ' .
                        $this->lang->line('title_project_periods');
            }

            else
            {
                $data['pagetitle'] = $this->lang->line('title_project_periods');
            }
            // possible error message and heading for it
            $data['error_message'] = $this->session->flashdata('$error_message');
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
     * Edit a project_period.
     * 
     * Reads a project_period from the database using the primary key. 
     * If no project period is found redirects to index with error message in flash data.
     * 
     * @param int $project_period_id, $currentprojectid Primary key of the project_period. 
     */
    public function edit($project_period_id, $currentproject_id) 
    {
        if ($this->session->userdata('logged_in'))
        {
            $session_data = $this->session->userdata('logged_in');
            $project_period = $this->project_period_model->read($project_period_id);

            if (isset($project_period[0])) 
            {
                $data = array(
                    'id'         => $project_period[0]->id,
                    'period_start_date'    => $project_period[0]->period_start_date,
                    'period_end_date'  => $project_period[0]->period_end_date,
                    'milestone'      => $project_period[0]->milestone,
                    'project_id'      => $project_period[0]->project_id,
                    'period_description'      => $project_period[0]->period_description,
                    'period_name'   => $project_period[0]->period_name
                );

                $data['error_message'] = $this->session->flashdata('$error_message');

                $data['main_content'] = 'project_period/project_period_view';
                $data['login_user_id'] = $session_data['user_id'];
                $data['login_id'] = $session_data['id'];
                $data['pagetitle'] = $this->lang->line('title_edit_project_period');
                $data['add'] = FALSE; // not show reset button        
                $this->load->view('template', $data);
            }

            else 
            {
                // error message if not found and redirected to index
                // uses flash data for error_message
                $error_message = $this->lang->line('missing_project_period');
                $this->session->set_flashdata('$error_message', $error_message);
                redirect('project_period/index/' . $currentproject_id);
            }
        }
        else
        {
            redirect('login','refresh');
        }
    }
    
    /**
     * Add a project_period to the database.
     * 
     * Creates an empty project_period and shows it via project_period/project_period_view.
     * @param int $currentprojectid Primary key of the project_period. 
     */
    public function add($currentproject_id = 0)
    {
        if ($this->session->userdata('logged_in'))
        {
            $session_data = $this->session->userdata('logged_in');
            $data = array(
                'id' => '',    
                'period_start_date' => '',
                'period_end_date' => '',
                'milestone' => '',
                'period_name' => '',
                'period_description' => '',
                'project_id' => $currentproject_id
            );

            $data['error_message'] = $this->session->flashdata('$error_message');

            $data['main_content'] = 'project_period/project_period_view';
            $data['pagetitle'] = $this->lang->line('title_add_project_period');
            $data['add'] = TRUE; // show reset button
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
     * Insert or update project_period into the database.
     * 
     * Inserts or updates the project period into the project_period table. 
     * Validates the input data; period name must exist.
     */
    public function save()
    {
        // data from a page
        $data = array(
            'id' => $this->input->post('txt_id'),
            'project_id' => $this->input->post('txt_projectid'),
            'period_name' => $this->input->post('txt_period_name'),
            'period_description' => $this->input->post('txt_period_description'),
            'period_start_date' => $this->input->post('txt_period_start_date'),
            'period_end_date' => $this->input->post('txt_period_end_date'),
            'milestone' => $this->input->post('txt_milestone')
        );                
        
        $update = FALSE; // assume it it add new
        // is there an id value
        if (strlen($this->input->post("txt_id"))>0)
        {
            $update = TRUE; // it is update
        }

        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<span class="error">', 
                '</span>');
        
        $this->form_validation->set_rules('txt_period_name',
                $this->lang->line('label_period_name'), 'trim|required|max_length[255]|xss_clean');
        $this->form_validation->set_rules('txt_period_description',
                $this->lang->line('label_period_description'), 'trim|max_length[1000]|xss_clean');
        $this->form_validation->set_rules('txt_period_start_date', 
                $this->lang->line('label_period_start_date'), 'xss_clean|check_date');
        $this->form_validation->set_rules('txt_period_end_date', 
                $this->lang->line('label_period_end_date'), 'xss_clean|check_date');
        $this->form_validation->set_rules('txt_milestone',
                $this->lang->line('label_milestone'), 'xss_clean');

        if ($this->form_validation->run() == FALSE)
        {
            $data['main_content'] = 'project_period/project_period_view';
            $data['error_message'] = $this->session->flashdata('$error_message');
            if ($update == TRUE)
            {
                $data['add'] = FALSE; // not show reset button
                $data['pagetitle'] = $this->lang->line('title_edit_project_period');
            }
            
            else
            {
                $data['add'] = TRUE; // show reset button
                $data['pagetitle'] = $this->lang->line('title_add_project_period');
            }
            $this->load->view('template', $data);
     
        }
        
        else
        {
            if (!empty($data['period_start_date']) && !empty($data['period_end_date']))
            {
                if ($data['period_start_date'] < $data['period_end_date'])
                {
                    if ($update == TRUE)  // update the database
                    {
                        $data['id'] = intval($this->input->post('txt_id'));
                        $this->project_period_model->update($data);     
                    }

                    else  // insert new
                    {
                        $this->project_period_model->create($data);
                    }
                }
                else
                {
                    if ($update == TRUE)
                    {
                        $error_message = $this->lang->line('invalid_dates');
                        $this->session->set_flashdata('$error_message', $error_message);
                        redirect('project_period/edit/' . $data['id'] . '/' . $data['project_id']);
                    }
                    else
                    {
                        $error_message = $this->lang->line('invalid_dates');
                        $this->session->set_flashdata('$error_message', $error_message);
                        redirect('project_period/add/' . $data['project_id']);
                    }
                }
            }
            else
            {
                if ($update == TRUE)  // update the database
                {
                    $data['id'] = intval($this->input->post('txt_id'));
                    $this->project_period_model->update($data);     
                }

                else  // insert new
                {
                    $this->project_period_model->create($data);
                }
            }
            
            redirect('project_period/index/' . $data['project_id']);            
        }
    }
    
    /**
     * Delete a project_period.
     * 
     * Deletes a project period using the primary key.
     * 
     * @param int $id Primary key of the project_period. 
     */
    public function delete() 
    {
        $id = $this->input->post('txt_id');
        $project_id = $this->input->post('txt_projectid');                
        
        if ($this->project_period_model->delete(intval($id)) == FALSE)
        {
            $error_message = $this->lang->line('cannot_delete');
            $this->session->set_flashdata('$error_message', $error_message);
            redirect('project_period/index/' . $project_id );
        }
        else
        {
            $this->project_period_model->delete(intval($id));
            redirect('project_period/index/' . $project_id );
        }
    }
}

?>