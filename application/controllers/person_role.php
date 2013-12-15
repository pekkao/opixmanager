<?php
/**
 * @package opix
 * @copyright Oulu University of Applied Sciences(OUAS)
 * @license MIT
 * @version 0.1
 */

/**
 * Class definition for Person_Role controller extends CI_Controller.
 *
 * Class definition for Person_Role controller. Controller includes methods
 * to handle Person Role listing, inserting, editing and deleting Person Roles.
 * Extends CI_Controller.
 * 
 * @author Wang Yuqing
 * @package opix
 * @subpackage controllers
 * @category Person_Role
 */
class Person_Role extends CI_Controller
{
     /**
     * Constructor of a Person_Role model.
     * 
     * Constructor of a Person_Role model. Loads person_role_model and language package.
     */
    public function __construct() 
    {
        parent::__construct();
        $this->load->model('person_role_model');
        $this->lang->load('person_role');
        $this->load->library('session');
    }
    
     /**
     * Listing of all person roles.
     * 
     * Reads all person roles from the person_role table in the database. 
     * Uses the person_role/person_roles_view.
     * 
     */
    public function index()
    {
        if ($this->session->userdata('logged_in'))
        {
            $session_data = $this->session->userdata('logged_in');
            $data = array(
                'id' => '',
                'role_name' => '',
                'role_description' => ''
            );

            $data['person_roles'] = $this->person_role_model->read_all();
            $data['main_content'] = 'person_role/person_roles_view';
            $data['pagetitle'] = $this->lang->line('title_person_roles');
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
     * Add a person role to the database.
     * 
     * Creates an empty person role and shows it via person_role/person_roles_view.
     */
    public function add()
    {
        if ($this->session->userdata('logged_in'))
        {
            $session_data = $this->session->userdata('logged_in');
            if ($this->session->userdata('account_type') == 1)
            {
                $data = array(
                    'id' => '',
                    'role_name' => '',
                    'role_description' => ''
                );

                $data['main_content'] = 'person_role/person_role_view';
                $data['pagetitle'] = $this->lang->line('title_add_person_role');
                $data['add'] = TRUE;
                $data['login_user_id'] = $session_data['user_id'];
                $data['login_id'] = $session_data['id'];
                $this->load->view('template', $data);
            }
            else
            {
                $error_message = $this->lang->line('not_allowed');
                $this->session->set_flashdata('$error_message', $error_message);
                redirect('person_role');
            }
        }
        else
        {
            redirect('login','refresh');
        }
    }
    
    /**
     * Insert or update person role into the database.
     * 
     * Inserts or updates the person role into the person_role table. 
     * Validates the input data; person_role name must exist.
     */
    public function save()
    {
        if ($this->session->userdata('logged_in'))
        {
            $session_data = $this->session->userdata('logged_in');
             $data = array(
                'id' => $this->input->post('txt_id'),
                'role_name' => $this->input->post('txt_rolename'),
                'role_description' => $this->input->post('txt_roledescription')
             );

             $update = FALSE;

             if (strlen($this->input->post("txt_id")) > 0)
             {
                 $update = TRUE;
             }

             $this->load->library('form_validation');
             $this->form_validation ->set_error_delimiters('<span class="error">','</span>');

             $this->form_validation->set_rules(
                     'txt_rolename',$this->lang->line('missing_name'),'trim|required|max_length[255]|xss_clean');
             $this->form_validation->set_rules(
                     'txt_roledescription', 'trim|max_length[1000]|xss_clean');

             if ($this->form_validation->run() == FALSE)
             {
                 $data['main_content'] = 'person_role/person_role_view';
                 $data['pagetitle'] = $this->lang->line('title_add_person_role');

                 if ($update == TRUE)
                 {
                     $data['add'] = FALSE;
                 }

                 else
                 {
                     $data['add'] = TRUE;
                 }
                 $data['login_user_id'] = $session_data['user_id'];
                 $data['login_id'] = $session_data['id'];
                 $this->load->view('template', $data);
             }
             else
             {
                 if ($update == TRUE)
                 {
                     $data['id'] = intval($this->input->post('txt_id'));
                     $this->person_role_model->update($data);
                     redirect('person_role');
                 }

                 else
                 {
                     $this->person_role_model->create($data);
                     redirect('person_role');
                 }
             }
        }
        else
        {
            redirect('login','refresh');
        }
    }
    
     /**
     * Edit a person role.
     * 
     * Reads a person role from the database using the primary key. 
     * If no person role is found redirects to index with error message in flash data.
     * 
     * @param int $id Primary key of the person role. 
     */
    public function edit($id)
    {
        if ($this->session->userdata('logged_in'))
        {
            $session_data = $this->session->userdata('logged_in');
            
            if ($this->session->userdata('account_type') == 1)
            {
                $person_role = $this->person_role_model->read($id);

                if (isset($person_role[0]))
                {
                    $data = array(
                    'id' => $person_role[0]->id,
                    'role_name' => $person_role[0]->role_name,
                    'role_description' => $person_role[0]->role_description
                    );

                    $data['main_content'] = 'person_role/person_role_view';
                    $data['pagetitle'] = $this->lang->line('title_edit_person_role');
                    $data['add'] = FALSE;
                    $data['login_user_id'] = $session_data['user_id'];
                    $data['login_id'] = $session_data['id'];
                    $this->load->view('template', $data);
                }  

                else 
                {
                    $error_message = $this->lang->line('missing_person_role');
                    $this->session->set_flashdata('$error_message', $error_message);
                    redirect('person_role');
                }
            }
            else
            {
                $error_message = $this->lang->line('not_allowed');
                $this->session->set_flashdata('$error_message', $error_message);
                redirect('person_role');
            }
        }
        else
        {
            redirect('login','refresh');
        }
    }
   
     /**
     * Delete a person role.
     * 
     * Deletes a person role using the primary key.
     * 
     * @param int $id Primary key of the person role. 
     */
    public function delete()
    {
        if ($this->session->userdata('logged_in'))
        {
            $session_data = $this->session->userdata('logged_in');
            
            if ($this->session->userdata('account_type') == 1)
            {
                $id = $this->input->post('txt_id');
                $this->person_role_model->delete($id);
                redirect('person_role');
            }
            else
            {
                $error_message = $this->lang->line('not_allowed');
                $this->session->set_flashdata('$error_message', $error_message);
                redirect('person_role');
            }
        }
        else
        {
            redirect('login');
        }
    }    
}

?>
