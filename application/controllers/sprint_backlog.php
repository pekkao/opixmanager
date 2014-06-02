<?php

/**
 * @package opix
 * @copyright Oulu University of Applied Sciences(OUAS)
 * @license MIT
 * @version 0.1
 */

/**
 * Class definition for Sprint_backlog controller extends CI_Controller.
 *
 * Class definition for Sprint_backlog controller. Controller includes methods
 * to handle Sprint_backlog listing, inserting, editing and deleting 
 * Sprint_backlogs.
 * Extends CI_Controller.
 * 
 * @author Tuukka Kiiskinen, Roni Kokkonen, Liisa Auer
 * @package opix
 * @subpackage controllers
 * @category Sprint_backlog
 */

class Sprint_Backlog extends CI_Controller
{
    /**
     * Constructor of a Sprint_backlog model.
     * 
     * Constructor of a Sprint_backlog model. Loads Sprint_backlog_model and 
     * language package.
     */
    public function __construct() 
    {
        parent::__construct();
        $this->load->model('sprint_backlog_model');
        $this->load->model('project_model');
        $this->load->model('product_backlog_model');
        $this->lang->load('sprint_backlog');
        $this->load->library('session');
    }
    
    /**
     * Listing of all sprint backlogs.
     * 
     * Reads all sprint backlogs from the sprint_backlog table in the database. 
     * Uses the sprint_backlog/sprint_backlogs_view.
     * 
     * @param int $project_id Primary key of the project to be listed
     * @param int $productbacklogid Primary key of the product backlog that 
     * sprints belong to.
     *  
     */
    public function index($project_id = 0, $productbacklogid = 0)
    {   
        if ($this->session->userdata('logged_in'))
        {
            $session_data = $this->session->userdata('logged_in');
            $data['sprint_backlogs'] = 
                    $this->sprint_backlog_model->read_all($productbacklogid);
            $data['currentproductbacklogid'] = $productbacklogid;
            $productbacklog = 
                    $this->product_backlog_model->read($productbacklogid);
            $data['productbacklog'] = $productbacklog;
            $data['main_content'] = 'sprint_backlog/sprint_backlogs_view';
            $data['project_id'] = $project_id;

            $project = $this->project_model->read($project_id);

            if (isset($productbacklog[0]))
            {
                $data['pagetitle'] = $project[0]->project_name . ', ' . 
                        $productbacklog[0]->backlog_name  . ': ' .
                        $this->lang->line('title_sprint_backlogs');
            }

            else
            {
                $data['pagetitle'] = $this->lang->line('title_sprint_backlogs');
            }

            $data['error_message'] = 
                    $this->session->flashdata('$error_message');
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
     * Add a sprint backlog to the database.
     * 
     * Creates an empty sprint backlog and shows it via 
     * sprint_backlog/sprint_backlogs_view.
     * 
     * @param int $project_id Primary key of the project new sprint backlog 
     * belongs to.
     * @param int $currentproductbacklogid Primary key of the product backlog of the 
     * project.
     * 
     */
    public function add($project_id, $currentproductbacklogid)
    {
        if ($this->session->userdata('logged_in'))
        {
            $session_data = $this->session->userdata('logged_in');
            $data = array(
                'id' => '',
                'product_backlog_id' => $currentproductbacklogid,
                'sprint_name' => '',
                'sprint_description' => '',
                'start_date' => '',
                'end_date'   => '',
            );

            $data['error_message'] = 
                    $this->session->flashdata('$error_message');

            $data['project_id'] = $project_id;
            $data['main_content'] = 'sprint_backlog/sprint_backlog_view';
            $data['pagetitle'] = $this->lang->line('title_add_sprint_backlog');
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
     * Edit a sprint backlog.
     * 
     * Reads a sprint backlog from the database using the primary key. 
     * If no sprint backlog is found redirects to index with error message in 
     * flash data.
     * 
     * @param int $project_id Primary key of the project the editable sprint 
     * backlog belongs to.
     * @param int $currentproductbacklogid Primary key of the current product 
     * backlog of the project.
     * @param int $id Primary key of the sprint backlog to be edited. 
     */
     public function edit($project_id, $currentproductbacklogid, $id)
    {
        if ($this->session->userdata('logged_in'))
        {
            $session_data = $this->session->userdata('logged_in');
            $sprint_backlog = $this->sprint_backlog_model->read($id);

            if (isset($sprint_backlog[0])) 
            {
                $data = array(
                    'id'         => $sprint_backlog[0]->id,
                    'product_backlog_id' 
                        => $sprint_backlog[0]->product_backlog_id,
                    'sprint_name'  => $sprint_backlog[0]->sprint_name,
                    'sprint_description' 
                        => $sprint_backlog[0]->sprint_description,
                    'start_date'      => $sprint_backlog[0]->start_date,
                    'end_date'      => $sprint_backlog[0]->end_date                
                );

                $data['error_message'] = 
                        $this->session->flashdata('$error_message');

                $data['project_id'] = $project_id; 
                $data['main_content'] = 'sprint_backlog/sprint_backlog_view';
                $data['pagetitle'] = 
                        $this->lang->line('title_edit_sprint_backlog');
                $data['add'] = FALSE; // not show reset button
                $data['login_user_id'] = $session_data['user_id'];
                $data['login_id'] = $session_data['id'];
                $this->load->view('template', $data);
            } 

            else 
            {
                $error_message = $this->lang->line('missing_sprint_backlog');
                $this->session->set_flashdata('$error_message', $error_message);
                redirect('sprint_backlog/index/' . $project_id . '/' . 
                        $currentproductbacklogid);
            }
        }
        else
        {
            redirect('login','refresh');
        }
    }
    
    /**
     * Insert or update sprint backlog into the database.
     * 
     * Inserts or updates the sprint backlog into the sprint_backlog table. 
     * Validates the input data; sprint backlog name and start date must exist.
     * If start and end dates exists then end date must be later than start 
     * date.
     */
    public function save()
    {
        if ($this->session->userdata('logged_in'))
        {
            $session_data = $this->session->userdata('logged_in');
            $data = array(
                'id' => $this->input->post('txt_id'),
                'product_backlog_id' 
                    => $this->input->post('txt_product_backlog_id'),
                'sprint_name' => $this->input->post('txt_sprint_name'),
                'sprint_description' 
                    => $this->input->post('txt_sprint_description'),
                'start_date' => $this->input->post('dtm_start_date'),
                'end_date' => $this->input->post('dtm_end_date')
             );


            $project_id = $this->input->post('txt_project_id');
            $product_backlog_id = $this->input->post('txt_product_backlog_id');
            
            $update = FALSE; 

            if (strlen($this->input->post("txt_id")) > 0)
            {
                $update = TRUE; 
            }

            $this->load->library('form_validation');
            $this->form_validation->set_error_delimiters('<span class="error">',
                    '</span>');

            $this->form_validation->set_rules(
                    'txt_sprint_name', $this->lang->line('missing_name'), 
                    'trim|required|max_length[255]|xss_clean');
            $this->form_validation->set_rules(
                    'txt_sprint_description', 
                    'trim|max_length[1000]|xss_clean');
            $this->form_validation->set_rules(
                    'dtm_start_date', $this->lang->line('label_start_date'), 
                    'required|check_date');
            $this->form_validation->set_rules(
                    'dtm_end_date', $this->lang->line('label_end_date'), 
                    'check_date');

            if ($this->form_validation->run() == FALSE) 
            {
                $data['project_id'] = $project_id;
                $data['main_content'] = 'sprint_backlog/sprint_backlog_view';            
                $data['error_message'] = 
                        $this->session->flashdata('$error_message');
                if ($update == TRUE)
                {
                    $data['pagetitle'] = 
                            $this->lang->line('title_edit_sprint_backlog');
                    $data['add'] = FALSE; 
                }
                else
                {
                    $data['pagetitle'] = 
                            $this->lang->line('title_add_sprint_backlog')."aaa";
                    $data['add'] = TRUE;
                }
                $data['login_user_id'] = $session_data['user_id'];
                $data['login_id'] = $session_data['id'];
                $this->load->view('template', $data);
            }

            else
            {
                if (!empty($data['start_date']) && !empty($data['end_date']))
                {
                    if ($data['start_date'] < $data['end_date'])
                    {
                        if ($update == TRUE)  
                        {
                            $data['id'] = intval($this->input->post('txt_id'));
                            $this->sprint_backlog_model->update($data);     
                        }

                        else  
                        {            
                            $this->sprint_backlog_model->create($data);
                        }
                        redirect('sprint_backlog/index/' . $project_id . '/' . 
                                $product_backlog_id );
                    }
                    else
                    {
                        $data['login_user_id'] = $session_data['user_id'];
                        $data['login_id'] = $session_data['id'];
                        $data['project_id'] = 
                                $this->input->post('txt_project_id');
                        $data['error_message'] = 
                                $this->lang->line('invalid_dates');                        
                        $data['main_content'] = 
                                'sprint_backlog/sprint_backlog_view';  
                        
                        if ($update == TRUE)  // edit 
                        {
                            $data['pagetitle'] = 
                               $this->lang->line('title_edit_sprint_backlog');
                            $data['add'] = FALSE;
                        }
                        else  // add
                        {
                            $data['pagetitle'] = 
                                $this->lang->line('title_add_sprint_backlog');
                            $data['add'] = TRUE;
                        }
                        $this->load->view('template', $data);
                    }
                }
                else
                {
                    if ($update == TRUE)  
                    {
                        $data['id'] = intval($this->input->post('txt_id'));
                        $this->sprint_backlog_model->update($data);     
                    }

                    else  
                    {            
                        $this->sprint_backlog_model->create($data);
                    }
                    redirect('sprint_backlog/index/' . $project_id . '/' . 
                            $product_backlog_id );
                }           
            }
        }
        else
        {
            redirect('login','refresh');
        }
    }
    
     /**
     * Delete a sprint backlog.
     * 
     * Deletes a sprint backlog using the primary key.
     *  
     */
    public function delete()
    {
        $id = $this->input->post('txt_id');
        $project_id = $this->input->post('txt_project_id');
        $productbacklogid = $this->input->post('txt_product_backlog_id');                
        
        if ($this->sprint_backlog_model->delete(intval($id)) == FALSE)
        {
            $error_message = $this->lang->line('cannot_delete');
            $this->session->set_flashdata('$error_message', $error_message);
            redirect('sprint_backlog/index/' . $project_id . '/' . 
                    $productbacklogid); 
        }
        else
        {
            $this->sprint_backlog_model->delete(intval($id));
            redirect('sprint_backlog/index/' . $project_id . '/' . 
                    $productbacklogid); 
        } 
    }
    
}
?>
