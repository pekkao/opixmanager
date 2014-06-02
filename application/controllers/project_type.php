<?php
/**
 * @package opix
 * @copyright Oulu University of Applied Sciences(OUAS)
 * @license MIT
 * @version 0.1
 */

/**
 * Class definition for Project_type controller extends CI_Controller.
 *
 * Class definition for Project_type controller. Controller includes methods
 * to handle Project_type listing, inserting, editing and deleting Project typeS.
 * Extends CI_Controller.
 * 
 * @author Wang Yuqing
 * @package opix
 * @subpackage controllers
 * @category project_type
 */

class Project_Type extends CI_Controller 
{
    public function __construct() 
    {
     /**
     * Constructor of a Project_type model.
     * 
     * Constructor of a Project_type model. Loads project_type_model and language package.
     */
        parent::__construct();
        $this->load->model('project_type_model');
        $this->lang->load('project_type');
        $this->load->library('session');
    }
    
     /**
     * Listing of all project types.
     * 
     * Reads all project types from the project_type table in the database. 
     * Uses the project_type/project_types_view.
     * 
     */
    public function index()
    {
        $data = array(
            'id' => '',
            'type_name' => '',
            'type_description' => ''
        );
        
        $data['project_types'] = $this->project_type_model->read_all();
        $data['main_content'] = 'project_type/project_types_view';
        $data['pagetitle'] = $this->lang->line('title_project_types');
        $data['error_message'] = $this->session->flashdata('$error_message');
        $data['heading'] = $this->lang->line('title_db_error');
        $this->load->view('template', $data);
    }
    
     /**
     * Add a project type to the database.
     * 
     * Creates an empty project type and shows it via project_type/project_types_view.
     */
    public function add()
    {
        $data = array(
            'id' => '',
            'type_name' => '',
            'type_description' => ''
        );
        
        $data['main_content'] = 'project_type/project_type_view';
        $data['pagetitle'] = $this->lang->line('title_add_project_type');
        $data['add'] = TRUE;
        $this->load->view('template', $data);
    }
    
     /**
     * Insert or update project type into the database.
     * 
     * Inserts or updates the project type into the project_type table. 
     * Validates the input data; project_type name must exist.
     */
    public function save()
    {
         $data = array(
            'id' => $this->input->post('txt_id'),
            'type_name' => $this->input->post('txt_typename'),
            'type_description' => $this->input->post('txt_type_description')
         );
         
         $update = FALSE;
         
         if (strlen($this->input->post("txt_id")) > 0)
         {
             $update = TRUE;
         }
         
         $this->load->library('form_validation');
         $this->form_validation ->set_error_delimiters('<span class="error">','</span>');
         
         $this->form_validation->set_rules(
                 'txt_typename',$this->lang->line('missing_name'),'trim|required|max_length[255]|xss_clean');
         $this->form_validation->set_rules(
                 'txt_type_description', 'trim|max_length[1000]|xss_clean');
         
         if ($this->form_validation->run() == FALSE)
         {
             $data['main_content'] = 'project_type/project_type_view';
             $data['pagetitle'] = $this->lang->line('title_add_project_type');
             
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
                 $this->project_type_model->update($data);
                 redirect('project_type');
             }
             
             else
             {
                 $this->project_type_model->create($data);
                 redirect('project_type');
             }
         }
    }
    
    /**
     * Edit a project type.
     * 
     * Reads a project type from the database using the primary key. 
     * If no project type is found redirects to index with error message in flash data.
     * 
     * @param int $id Primary key of the project type. 
     */
     public function edit($id)
     {
        $project_type = $this->project_type_model->read($id);
        if (isset($project_type[0]))
        {
            $data = array(
                'id' => $project_type[0]->id,
                'type_name' => $project_type[0]->type_name,
                'type_description' => $project_type[0]->type_description
            );
            
            $data['main_content'] = 'project_type/project_type_view';
            $data['pagetitle'] = $this->lang->line('title_edit_project_type');
            $data['add'] = FALSE;
            $this->load->view('template', $data);
        }  
        
        else 
        {
            $error_message = $this->lang->line('missing_project_type');
            $this->session->set_flashdata('$error_message', $error_message);
            redirect('project_type');
        }
     }
    
    /**
     * Delete a project type.
     * 
     * Deletes a project type using the primary key.
     * 
     */
    public function delete()
    {
            $id = $this->input->post('txt_id');
            $this->project_type_model->delete($id);
            redirect('project_type');
    }    
}

?>
