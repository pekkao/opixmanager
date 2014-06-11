<?php
/**
 * @package opix
 * @copyright Oulu University of Applied Sciences(OUAS)
 * @license MIT
 * @version 0.1
 */

/**
 * Class definition for Person controller extends CI_Controller.
 *
 * Class definition for Person controller. Controller includes methods
 * to handle Person listing, inserting, editing and deleting persons.
 * Extends CI_Controller.
 * 
 * @author Wang Yuqing, Tuukka Kiiskinen, Roni Kokkonen
 * @package opix
 * @subpackage controllers
 * @category customer
 */
class Person extends CI_Controller
{
    CONST ADMIN = 1;
    CONST MEMBER = 2;
    CONST SELECTED = TRUE; // This constant is used in person_view
    
    private static $enum = array(1 => "Admin", 2 => "Member");
    
    /*
     * Converts account_type to string
     */
    public function toString($account_type)
    {
        return self::$enum[$account_type];
    }
    
    CONST TRADITIONAL = 1;
    CONST SCRUM = 2;
    
    CONST ACTIVE = 2;
    CONST FINISHED = 1;   
    
    private static $enum2 = array(1 => "Traditional", 2 => "Scrum");
    private static $enum3 = array(1 => "Finished", 2 => "Active");
    
    /**
     * Converts project_type to string.
     */
    public function toString2($project_type)
    {
        return self::$enum2[$project_type];
    }
    
    /**
     * Converts active to string.
     */
    public function toString3($active)
    {
        return self::$enum3[$active];
    }
    
     /**
     * Constructor of a person model.
     * 
     * Constructor of a person model. Loads person_model, project_model and language package.
     */
    public function __construct() 
    {
        parent::__construct();
        $this->load->model('person_model');
        $this->load->model('project_model');
        $this->load->model('project_staff_model');
        $this->lang->load('person');
        $this->lang->load('project');
        $this->load->library('session');
    }
    
    /**
     * Listing of all persons.
     * 
     * Reads all persons from the person table in the database. 
     * Uses the person/persons_view.
     * 
     */
    public function index()
    {
        if ($this->session->userdata('logged_in'))
        {
            $session_data = $this->session->userdata('logged_in');
            $data = array(
                'id' => '',
                'surname' => '',
                'firstname' => '',
                'title' => '',
                'email' => '',
                'phone_number' =>'',
                'user_id' => '',
                'password' => '',
                'language_id' => '',
                'language_long' => '',
                'account_type' => ''
            );

            $persons = $this->person_model->read_all_with_group();
            
            if (isset($persons[0]))
            {
                foreach ($persons as $person)
                {
                    // logged in user can edit own data
                    if ($person->id == $session_data['id'])
                    {
                        $person->can_edit = TRUE;
                    }
                    else
                    {
                        $person->can_edit = FALSE;
                    }
                }
            }
            
            $data['persons'] = $persons; 
            $data['main_content'] = 'person/persons_view';
            $data['pagetitle'] = $this->lang->line('title_persons');
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
     * Add a person to the database.
     * 
     * Creates an empty person and shows it via person/person_view.
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
                    'surname' => '',
                    'firstname' => '',
                    'title' => '',
                    'email' => '',
                    'phone_number' =>'',
                    'user_id' => '',
                    'password' => '',
                    'language_id' => '',
                    'account_type' => '',
                    'confirm_password' => ''
                );

                $this->load->helper("form_input_helper");
                $languages_from_db = $this->person_model->read_language();
                // new text in the beginning of array
                $a = array('id' => "0", 'language_long' => $this->lang->line('select_language') );
                array_unshift($languages_from_db, $a);
                $languages = convert_db_result_to_dropdown(
                        $languages_from_db, 'id', 'language_long');        
                $data['languages'] = $languages;
                
                $data['login_user_id'] = $session_data['user_id'];
                $data['login_id'] = $session_data['id'];
                $data['main_content'] = 'person/person_view';
                $data['pagetitle'] = $this->lang->line('title_add_person');
                $data['add'] = TRUE;
                $this->load->view('template', $data);
            }
            else
            {
                $error_message = $this->lang->line('not_allowed');
                $this->session->set_flashdata('$error_message', $error_message);
                redirect('person');
            }
        }
        else
        {
            redirect('login');
        }
    }
    
     /**
     * Insert or update person into the database.
     * 
     * Inserts or updates the person into the person table. 
     * Validates the input data; firstname and surname must exist.
     */
    public function save()
    {
        if ($this->session->userdata('logged_in'))
        {
            $session_data = $this->session->userdata('logged_in');
            
            if (strlen($this->input->post("txt_id") == 0))
            {
                $data = array(
                    'id' => $this->input->post('txt_id'),
                    'surname' => $this->input->post('txt_surname'),
                    'firstname' => $this->input->post('txt_firstname'),
                    'title' => $this->input->post('txt_title'),
                    'email' => $this->input->post('eml_email'),
                    'phone_number' => $this->input->post('tel_phone_number'),
                    'user_id' => $this->input->post('txt_user_id'),
                    'password' => md5($this->input->post('pwd_password')),
                    'language_id' => $this->input->post('ddl_language'),
                    'account_type' => $this->input->post('rdo_account_type')
                );                
            }
            else
            {
                $data = array(
                    'id' => $this->input->post('txt_id'),
                    'surname' => $this->input->post('txt_surname'),
                    'firstname' => $this->input->post('txt_firstname'),
                    'title' => $this->input->post('txt_title'),
                    'email' => $this->input->post('eml_email'),
                    'phone_number' => $this->input->post('tel_phone_number'),
                    'user_id' => $this->input->post('txt_user_id'),                  
                    'language_id' => $this->input->post('ddl_language'),
                    'account_type' => $this->input->post('rdo_account_type')
                );                
            }
            $update = FALSE;

            if (strlen($this->input->post("txt_id")) > 0)
            {
                $update = TRUE; 
            }

            $this->load->library('form_validation');
            $this->form_validation->set_error_delimiters('<span class="error">', '</span>');

            $this->form_validation->set_rules(
                    'txt_surname', $this->lang->line('missing_surname'), 'trim|required|max_length[255]|xss_clean');
            $this->form_validation->set_rules(
                    'txt_firstname', $this->lang->line('missing_firstname'), 'trim|required|max_length[255]|xss_clean');
            // also a callback function to check that user_id is unique
            $this->form_validation->set_rules(
                    'txt_user_id', $this->lang->line('missing_user_id'), 'trim|required|callback_check_user_id');
            
            // callback function to validate that language is selected
            // error message for that callback function
            $this->form_validation->set_message('check_language', $this->lang->line('missing_language'));
            $this->form_validation->set_rules(
                    'ddl_language', null, 'callback_check_language');
            
            if ($update == FALSE)  // new person
            {
                $this->form_validation->set_rules(
                    'pwd_password', $this->lang->line('missing_password'), 'min_length[6]|trim|required|md5');
                $this->form_validation->set_rules(
                    'pwd_confirm_password', $this->lang->line('label_confirm_password'), 'matches[pwd_password]|trim|required|md5');
            }

            $this->form_validation->set_rules(
                    'eml_email', $this->lang->line('invalid_email'), 'trim|valid_email|max_length[255]|xss_clean');
            $this->form_validation->set_rules(
                    'txt_title', 'trim|max_length[255]|xss_clean');
            $this->form_validation->set_rules(
                    'tel_phone_number', $this->lang->line('invalid_phonenumber'), 'numeric|max_length[255]');

            if ($this->form_validation->run() == FALSE) 
            {            
                $data['login_user_id'] = $session_data['user_id'];
                $data['login_id'] = $session_data['id'];
                $data['main_content'] = 'person/person_view';            

                if ($update == TRUE)
                { 
                    $data['pagetitle'] = $this->lang->line('title_edit_person');
                    $data['add'] = FALSE;    
                }
                else
                {
                    $data['pagetitle'] = $this->lang->line('title_add_person');
                    $data['add'] = TRUE;              
                }

                $this->load->helper("form_input_helper");
                $languages_from_db = $this->person_model->read_language();
                // new text in the beginning of array
                $a = array('id' => "0", 'language_long' => $this->lang->line('select_language') );
                array_unshift($languages_from_db, $a);
                $languages = convert_db_result_to_dropdown(
                $languages_from_db, 'id', 'language_long');        
                $data['languages'] = $languages;
                $data['confirm_password'] = '';
                $this->load->view('template', $data);
            }
            else
            {                
                if ($update == TRUE)  
                {          
                    $data['id'] = intval($this->input->post('txt_id'));
                    $this->person_model->update($data);            
                }
                else  
                {
                    $this->person_model->create($data);
                }
                
                // account_type = 1 for admins
                $account_type = $this->input->post("txt_account_type");
                
                if ($account_type == 1)
                {
                    redirect('person');
                }
                else 
                {
                    redirect('home');
                }
                
            }   
        }
        else
        {
            redirect('login', 'refresh');
        }
    }
    
    /**
     * Checks that language is selected
     * @param int $language what language is selected
     * @return boolean 
     */
    function check_language($language) {
        if ($language > 0) {
            return true;
        }
        else {
            return false;
        }
    }
    
    /**
     * Checks that user_id is unique
     * @param string $user_id User_id to check
     * @return boolean
     */
    function check_user_id ($user_id)
    {
        $result = $this->person_model->unique_user_id($user_id);
        if ($result == TRUE)
        {
            return TRUE;
        }
        else 
        {
            // note! message is to callback function, not to field
            $this->form_validation->set_message('check_user_id', $this->lang->line('invalid_user_id'));
            return FALSE;
        }
    }
    
     /**
     * Edit a person.
     * 
     * Reads a person from the database using the primary key. 
     * If no person is found redirects to index with error message in flash data.
     * 
     *  @param int $id Primary key of the person.
     */
    public function edit($id)
    {
        if ($this->session->userdata('logged_in'))
        {
            $session_data = $this->session->userdata('logged_in');
            $data['login_user_id'] = $session_data['user_id'];
            $data['login_id'] = $session_data['id'];
            
            if ($this->session->userdata('account_type') == 1 || $data['login_id'] === $id)
            {
                $person = $this->person_model->read($id);

                if (isset($person[0]))
                {
                    $data = array(
                        'id' => $person[0]->id,
                        'surname' => $person[0]->surname,
                        'firstname' => $person[0]->firstname,
                        'title' => $person[0]->title,
                        'email' => $person[0]->email,
                        'phone_number' => $person[0]->phone_number,
                        'user_id' => $person[0]->user_id,
                        'password' => $person[0]->password,                    
                        'language_id' => $person[0]->language_id,
                        'account_type' => $person[0]->account_type
                    );

                     // helper of this project for dropdown listbox
                    $this->load->helper("form_input_helper");

                    // dropdown listbox of customer_ids and names
                    $languages_from_db = $this->person_model->read_language();
                    // new text in the beginning of array
                    $a = array('id' => "0", 'language_long' => $this->lang->line('select_language') );
                    array_unshift($languages_from_db, $a);
                    $languages = convert_db_result_to_dropdown(
                            $languages_from_db, 'id', 'language_long');        
                    $data['languages'] = $languages;        
                    $data['login_user_id'] = $session_data['user_id'];
                    $data['login_id'] = $session_data['id'];
                    $data['main_content'] = 'person/person_view';
                    $data['pagetitle'] = $this->lang->line('title_edit_person');
                    $data['add'] = FALSE;       
                    $this->load->view('template', $data);
                }
                else 
                {
                    $error_message = $this->lang->line('missing_customer');
                    $this->session->set_flashdata('$error_message', $error_message);
                    redirect('person');
                }
            }
            else
            {
                $error_message = $this->lang->line('not_allowed');
                $this->session->set_flashdata('$error_message', $error_message);
                redirect('person');
            }
        }
        else
        {
            redirect('login');
        }
    }
    
    /**
     * Delete a person.
     * 
     * Deletes a personr using the primary key.
     * 
     * @param int $id Primary key of the person. 
     */
    public function delete()
    {
        if ($this->session->userdata('logged_in'))
        {
            $session_data = $this->session->userdata('logged_in');
            if ($this->session->userdata('account_type') == 1)
            {
                $id = $this->input->post('txt_id');
                $this->person_model->delete(intval($id));
                redirect('person');
            }
            else
            {
                $error_message = $this->lang->line('not_allowed');
                $this->session->set_flashdata('$error_message', $error_message);
                redirect('person');
            }
        }
        else
        {
            redirect('login');
        }
    } 
    
    /**
    * search person
    */
    public function find()
    {
        if ($this->session->userdata('logged_in'))
        {
            $session_data = $this->session->userdata('logged_in');
            $data = array(
                'id' => '',
                'surname' => '',
                'firstname' => '',
                'title' => '',
                'email' => '',
                'phone_number' =>'',
                'user_id' => '',
                'password' => '',
                'language_id' => '',
                'account_type' => ''

            );
            $criteria = $this->input->post('src_search');

            $this->load->library('form_validation');
            $this->form_validation->set_error_delimiters('<span class="error">', 
                    '</span>');

            $this->form_validation->set_rules('src_search', 
                    $this->lang->line('missing_name'), 'trim|required');
            $data['login_user_id'] = $session_data['user_id'];
            $data['login_id'] = $session_data['id'];
            $data['main_content'] = 'person/persons_view';
            $data['pagetitle'] = $this->lang->line('title_persons');
            $data['error_message'] = "";
            $data['surname'] = $criteria;


            if ($this->form_validation->run() != FALSE)
            {
                $data['persons'] = $this->person_model->find_person_by_name(
                        'person.surname', $criteria); 
                if (empty($data['persons']))
                {
                    $data['persons'] = $this->person_model->find_person_by_name(
                            'person.firstname', $criteria);
                }
            }
            else
            {
                $data['heading'] = $this->lang->line('search_results');
                $data['error_message'] = $this->lang->line('no_results');
            }
            $this->load->view('template', $data); 
        }
        else
        {
            redirect('login');
        }
    }
    /**
    * show the page with no person data
    */
    public function clear()
    {
        if ($this->session->userdata('logged_in'))
        {
            $session_data = $this->session->userdata('logged_in');
            $data = array(
                'surname' => '',
                'firstname' => '',
                'title' => '',
                'email' => '',
                'phone_number' =>'',
                'user_id' => '',
                'password' => '',
                'language_id' => ''
            );
            
            $data['login_user_id'] = $session_data['user_id'];
            $data['login_id'] = $session_data['id'];
            $data['main_content'] = 'person/persons_view';
            $data['pagetitle'] = $this->lang->line('title_persons');
            $data['error_message'] = "";
            $this->load->view('template', $data);
        }
        else
        {
            redirect('login');
        }
    }
    
    /*
     * Reads a person from person model and reads the persons projects. 
     * This is used from the persons views.
     * 
     * @param int id Primary key of a person
     */
    public function read_project($id)
    {
        if ($this->session->userdata('logged_in'))
        {
            $session_data = $this->session->userdata('logged_in');
            $person = $this->person_model->read($id);
            
            $projects = $this->person_model->read_persons_project($id);
            
            // is there projects for this person
            if (isset($projects[0]))
            {
                foreach($projects as $project)
                {
                    $result = $this->project_staff_model->can_edit_project_staff(
                            $session_data['id'], $project->project_id);
                    if ($result == TRUE)
                    {
                        $project->can_edit = TRUE;
                    }
                    else 
                    {
                        $project->can_edit = FALSE;
                    }
                }
            }
            $data['projects'] = $projects;
            $data['main_content'] = 'person/persons_project_view';

            if (isset($person[0]))
            {
                $data['pagetitle'] =  
                    $person[0]->surname . ' ' . $person[0]->firstname . ': ' .
                    $this->lang->line('title_persons_project');
            }
            else
            {
                $data['pagetitle'] =  
                    $this->lang->line('title_persons_project');            
            }
            $data['login_user_id'] = $session_data['user_id'];
            $data['login_id'] = $session_data['id'];
            $this->load->view('template', $data);
        }
        else
        {
            redirect('login');
        }
    }
    
    /*
     * Reads a person from person model and reads the persons projects.
     * This function is used on the home page to show person's projects.
     * 
     * @param int id Primary key of a person
     */
    public function read_projects($id)
    {
        if ($this->session->userdata('logged_in'))
        {
            $session_data = $this->session->userdata('logged_in');
            $person = $this->person_model->read($id);
            $data['projects'] = $this->person_model->read_person_projects($id);
            $data['main_content'] = 'person/person_projects_view';
            $data['error_message'] = $this->session->flashdata('$error_message');
            $data['heading'] = $this->lang->line('title_permission');
            
            if (isset($person[0]))
            {
                $data['pagetitle'] =  
                    $person[0]->surname . ' ' . $person[0]->firstname . ': ' .
                    $this->lang->line('title_persons_project');
            }
            else
            {
                $data['pagetitle'] =  
                    $this->lang->line('title_persons_project');            
            }
            $data['login_user_id'] = $session_data['user_id'];
            $data['login_id'] = $session_data['id'];
            $this->load->view('template', $data);
        }
        else
        {
            redirect('login');
        }
    }
    
    /*
     * Edit a person's password
     * Edit a person's password via person/person_password_view
     * 
     * @param int id Primary key of a person
     */
    public function edit_password($id)
    {
        if ($this->session->userdata('logged_in'))
        {
            $session_data = $this->session->userdata('logged_in');
            $data['login_user_id'] = $session_data['user_id'];
            $data['login_id'] = $session_data['id'];
            
            if ($this->session->userdata('account_type') == 1 || $data['login_id'] === $id)
            {
                $person = $this->person_model->read($id);

                $data = array(
                    'id' => $person[0]->id           
                );
                $data['login_user_id'] = $session_data['user_id'];
                $data['login_id'] = $session_data['id'];
                $data['main_content'] = 'person/person_password_view';
                $data['pagetitle'] = $this->lang->line('title_change_password');
                $data['add'] = FALSE;
                $this->load->view('template', $data);
            }
            else
            {
                $error_message = $this->lang->line('not_allowed');
                $this->session->set_flashdata('$error_message', $error_message);
                redirect('home');
            }
        }
        else
        {
            redirect('login');
        }
               
    }
    
    /*
     * Save person's password if it is not the same as the old password.
     */
    public function save_password() 
    {     
        if ($this->session->userdata('logged_in'))
        {
            $session_data = $this->session->userdata('logged_in');
            $old_password_ui = md5($this->input->post('pwd_old_password'));
            $new_password_ui = md5($this->input->post('pwd_new_password'));
            
            // data to be sent back to ui if there is  an error
            $data = array(
                'id' => $this->input->post('txt_id')
            );

            // new password data to be saved into the database
            $data2 = array(
                'id' => $this->input->post('txt_id'),
                'password' => md5($this->input->post('pwd_new_password'))
            );

            $this->load->library('form_validation');
            $this->form_validation->set_error_delimiters('<span class="error">', '</span>');

            $this->form_validation->set_rules(
                    'pwd_confirm_password', $this->lang->line('missing_confirm_password'), 'required|matches[pwd_new_password]|md5');
            $this->form_validation->set_rules(
                    'pwd_old_password', $this->lang->line('missing_old_password'), 'trim|required|md5');
            $this->form_validation->set_rules(
                    'pwd_new_password', $this->lang->line('missing_new_password'), 'min_length[6]|trim|required|md5');


            if ($this->form_validation->run() == FALSE) 
            {
                $data['login_user_id'] = $session_data['user_id'];
                $data['login_id'] = $session_data['id'];
                $data['main_content'] = 'person/person_password_view';
                $data['pagetitle'] = $this->lang->line('title_change_password');
                $this->load->view('template', $data);
            }
            else
            {          

                $data['login_user_id'] = $session_data['user_id'];
                $data['login_id'] = $session_data['id'];
                $data['main_content'] = 'person/person_password_view';
                $data['pagetitle'] = $this->lang->line('title_change_password');                 

                $person = $this->person_model->read($data['id']);

                if (isset($person[0]))
                {
                    $current_data = array(
                      'id' => $person[0]->id,
                      'password' => $person[0]->password
                    );                     
                    
                    // current password match ui old password
                    if ($current_data['password'] == $old_password_ui) 
                    {
                        // new password cannot be the same as old password
                        if ($old_password_ui == $new_password_ui)
                        {
                            $data['error_message'] = $this->lang->line('invalid_password');
                            $this->load->view('template', $data);
                        }
                        else
                        {
                            $this->person_model->update_password($data2);
                            $data['error_message'] = $this->lang->line('password_changed');
                            $this->load->view('template', $data);
                        }
                    }
                    else
                    {
                        $data['error_message'] = $this->lang->line('wrong_password');
                        $this->load->view('template', $data);
                    }
                }

                else
                {
                    $error_message = $this->lang->line('missing_person');
                    $this->load->view('template', $data);
                }
            }   
        }
        else
        {
            redirect('login','refresh');
        }
    }
    
    /*
     * Resets person's password.
     */
    public function reset_password()
    {
        if ($this->session->userdata('logged_in'))
        {
            $session_data = $this->session->userdata('logged_in');
            
            if ($this->session->userdata('account_type') == 1)
            {
                $id = $this->input->post('txt_id');
                $data = array(
                'id' => $this->input->post('txt_id'),
                'password' => md5('opix123')
                 );
                $this->person_model->update_password($data);
                redirect('person');
            }
            else
            {
                $error_message = $this->lang->line('not_allowed');
                $this->session->set_flashdata('$error_message', $error_message);
                redirect('home');
            }
        }
        else
        {
            redirect('login');
        }
    }
}

?>
