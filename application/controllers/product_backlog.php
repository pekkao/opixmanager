<?php

/**
 * @package opix
 * @copyright Oulu University of Applied Sciences(OUAS)
 * @license MIT
 * @version 0.1
 */

/**
 * Class definition for Product_backlog controller extends CI_Controller.
 *
 * Class definition for Product_backlog controller. Controller includes methods
 * to handle Product_backlog listing, inserting, editing and deleting Product_backlogs.
 * Extends CI_Controller.
 * 
 * @author Wang Yuqing, Roni Kokkonen, Tuukka Kiiskinen
 * @package opix
 * @subpackage controllers
 * @category Product_backlog
 */

class Product_Backlog extends CI_Controller
{
    /**
     * Constructor of a Product_backlog model.
     * 
     * Constructor of a Product_backlog model. Loads Product_backlog_model and language package.
     */
    public function __construct() 
    {
        parent::__construct();
        $this->load->model('product_backlog_model');
        $this->load->model('project_model');
        $this->load->model('project_staff_model');
        $this->load->model('person_model');
        $this->lang->load('product_backlog');
        $this->load->library('session');
    }
    
    /**
     * Listing of all product backlog.
     * 
     * Reads all product backlogs from the product_backlog table in the database. 
     * Uses the product_backlog/product_backlogs_view.
     * 
     * @param int projectid Primary key of a project
     * 
     */
    public function index($projectid = 0)
    {   
        if ($this->session->userdata('logged_in'))
        {
            $session_data = $this->session->userdata('logged_in');          
            $data['currentprojectid'] = $projectid;
            $project = $this->project_model->read($projectid);
            $data['project'] = $project;
            $data['main_content'] = 'product_backlog/product_backlogs_view';
            
            $product = $this->product_backlog_model->read_all($projectid);
            $product_backlogs = array();
            foreach ($product as $product_backlog)
            {                                
                $product_backlogi['id'] = $product_backlog->id;
                $product_backlogi['backlog_name'] = $product_backlog->backlog_name;
                $product_backlogi['product_visio'] = $product_backlog->product_visio;
                $product_backlogi['product_current_state'] = $product_backlog->product_current_state;
                
                if (!(is_null($product_backlog->product_owner)))
                {                  
                    $name = $this->person_model->read_name($product_backlog->product_owner);                
                    $product_backlogi['product_owner'] = $name[0]->name;
                }
                else 
                {
                    $product_backlogi['product_owner'] = "";
                }
                $product_backlogi['project_id'] = $product_backlog->project_id; 
                $product_backlogs[] = $product_backlogi;
                
            }
            $data['product_backlogs'] = $product_backlogs;
             
            if (isset($project[0]))
            {
                $data['pagetitle'] = $project[0]->project_name  . ': ' .
                        $this->lang->line('title_product_backlogs');
            }
            else
            {
                $data['pagetitle'] = $this->lang->line('title_product_backlogs');
            }
            
            $data['login_user_id'] = $session_data['user_id'];
            $data['login_id'] = $session_data['id'];
            $data['error_message'] = $this->session->flashdata('$error_message');
            $data['heading'] = $this->lang->line('title_db_error');
            $this->load->view('template', $data);
        }
        else
        {
            redirect('login');
        }
    }
    
    /**
     * Add a product backlog to the database.
     * 
     * Creates an empty product backlog and shows it via product backlog/product backlogs_view.
     * 
     * @param int $currentprojectid Primary key of the project. 
     */
    public function add($currentprojectid)
    {
        if ($this->session->userdata('logged_in'))
        {
            $session_data = $this->session->userdata('logged_in');
            $data = array(
                'id' => '',
                'backlog_name' => '',
                'product_visio' => '',
                'product_current_state' => '',
                'product_owner' => '',
                'project_id'   => $currentprojectid,
            );
            
            $this->load->helper("form_input_helper");
            $persons_from_project = $this->project_staff_model->read_project_persons($currentprojectid);
            // new text in the beginning of array
            $a = array('person_id' => "0", 'name' => $this->lang->line('select_person') );
            array_unshift($persons_from_project, $a);
            $persons = convert_db_result_to_dropdown(
            $persons_from_project, 'person_id', 'name');        
            $data['persons'] = $persons;
                 
            $data['main_content'] = 'product_backlog/product_backlog_view';
            $data['pagetitle'] = $this->lang->line('title_add_product_backlog');
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
     * Edit a product backlog.
     * 
     * Reads a product backlog from the database using the primary key. 
     * If no product backlog is found redirects to index with error message in flash data.
     * 
     * @param int $currentprojectid Primary key of the project.
     * @param int $id Primary key of a product backlog
     *  
     */
     public function edit($currentprojectid, $id)
    {
        if ($this->session->userdata('logged_in'))
        {
            $session_data = $this->session->userdata('logged_in');
            $data['login_user_id'] = $session_data['user_id'];
            $data['login_id'] = $session_data['id'];
            
            $product_backlog = $this->product_backlog_model->read($id);

            if (isset($product_backlog[0])) 
            {
                if ($this->session->userdata('account_type') == 1 || $data['login_id'] == $product_backlog[0]->product_owner)
                {
                    $data = array(
                        'id'         => $product_backlog[0]->id,
                        'backlog_name'    => $product_backlog[0]->backlog_name,
                        'product_visio'  => $product_backlog[0]->product_visio,
                        'product_current_state'      => $product_backlog[0]->product_current_state,
                        'product_owner'      => $product_backlog[0]->product_owner,
                        'project_id'      => $product_backlog[0]->project_id,                 
                    );

                    $this->load->helper("form_input_helper");
                    $persons_from_project = $this->project_staff_model->read_project_persons($currentprojectid);
                    // new text in the beginning of array
                    $a = array('person_id' => "0", 'name' => $this->lang->line('select_person') );
                    array_unshift($persons_from_project, $a);
                    $persons = convert_db_result_to_dropdown(
                    $persons_from_project, 'person_id', 'name');        
                    $data['persons'] = $persons;

                    $data['main_content'] = 'product_backlog/product_backlog_view';
                    $data['pagetitle'] = $this->lang->line('title_edit_product_backlog');
                    $data['add'] = FALSE; // not show reset button
                    $data['login_user_id'] = $session_data['user_id'];
                    $data['login_id'] = $session_data['id'];
                    $this->load->view('template', $data);
                } 
                else
                {
                    $error_message = $this->lang->line('not_allowed');
                    $this->session->set_flashdata('$error_message', $error_message);
                    redirect('product_backlog/index/' . $currentprojectid);
                }
            }

            else 
            {
                $error_message = $this->lang->line('missing_product_backlog');
                $this->session->set_flashdata('$error_message', $error_message);
                redirect('product_backlog/index/' . $currentprojectid);
            }
        }
        else
        {
            redirect('login','refresh');
        }
    }
    
    /**
     * Insert or update product backlog into the database.
     * 
     * Inserts or updates the product backlog into the product_backlog table. 
     * Validates the input data; backlog name must exist.
     */
    public function save()
    {
        
        $data = array(
            'id' => $this->input->post('txt_id'),
            'backlog_name' => $this->input->post('txt_backlog_name'),
            'product_visio' => $this->input->post('txt_product_visio'),
            'product_current_state' => $this->input->post('txt_product_current_state'),
            'product_owner' => $this->input->post('ddl_product_owner'),
            'project_id' => $this->input->post('txt_project_id')
         );
    
        $update = FALSE; 
        
        if (strlen($this->input->post("txt_id")) > 0)
        {
            $update = TRUE; 
        }
        
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<span class="error">', '</span>');

        $this->form_validation->set_rules(
                'txt_backlog_name', $this->lang->line('missing_backlog_name'), 'trim|required|max_length[255]|xss_clean');
        $this->form_validation->set_rules(
                'txt_product_visio', 'trim|max_length[1000]|xss_clean');
        $this->form_validation->set_rules(
                'txt_product_current_state', 'trim|max_length[1000]|xss_clean');
        
        
        if ($this->form_validation->run() == FALSE) 
        {
            $session_data = $this->session->userdata('logged_in');
            $data['login_user_id'] = $session_data['user_id'];
            $data['login_id'] = $session_data['id'];
            
            $data['main_content'] = 'product_backlog/product_backlog_view';
            $data['pagetitle'] = $this->lang->line('title_add_product_backlog');
            
            $this->load->helper("form_input_helper");
            $persons_from_project = 
                    $this->project_staff_model->read_project_persons(
                    $this->input->post('txt_project_id'));
            // new text in the beginning of array
            $a = array('person_id' => "0", 'name' => $this->lang->line('select_person') );
            array_unshift($persons_from_project, $a);
            $persons = convert_db_result_to_dropdown(
            $persons_from_project, 'person_id', 'name');        
            $data['persons'] = $persons;
            
            if ($update == TRUE)
            {
                $data['add'] = FALSE; 
            }
            else
            {
                $data['add'] = TRUE;
            }
            $this->load->view('template', $data);
        }
        
        else
        {
            if ($update == TRUE)  
            {
                $data['id'] = intval($this->input->post('txt_id'));
                $this->product_backlog_model->update($data);     
            }
            
            else  
            {
                $this->product_backlog_model->create($data);
            }

            redirect('product_backlog/index/' . $data['project_id']);
        }
    }
    
     /**
     * Delete a product backlog.
     * 
     * Deletes a product backlog using the primary key.
     */
    public function delete()
    {
        $id = $this->input->post('txt_id');
        $projectid = $this->input->post('txt_project_id');
        
        if ($this->product_backlog_model->delete(intval($id)) == FALSE)
        {
            $error_message = $this->lang->line('cannot_delete');
            $this->session->set_flashdata('$error_message', $error_message);
            redirect('product_backlog/index/' . $projectid);
        }
        else
        {
            $this->product_backlog_model->delete(intval($id));
            redirect('product_backlog/index/' . $projectid);
        }               
    }
    
}
?>
