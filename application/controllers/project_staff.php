<?php
/**
 * @package opix
 * @copyright Oulu University of Applied Sciences(OUAS)
 * @license MIT
 * @version 0.1
 */

/**
 * Class definition for project_staff controller extends CI_Controller.
 *
 * Class definition for project_staff controller. Controller includes methods
 * to handle Project_staff listing, inserting, editing and deleting project_staffs.
 * Extends CI_Controller.
 * 
 * @author Wang Yuqing, Roni Kokkonen, Tuukka Kiiskinen
 * @package opix
 * @subpackage controllers
 * @category project_staff
 */
class Project_Staff extends CI_Controller
{
    /**
     * Constructor of a project_staff model.
     * 
     * Constructor of a project_staff model. Loads person_role_model,
     * project_model, project_staff_model and language package.
     */
    public function __construct() 
    {
        parent::__construct();
        $this->load->model('project_model');
        $this->load->model('person_role_model');
        $this->load->model('project_staff_model');
        $this->lang->load('project_staff');
        $this->load->library('session');
       
    }
    /**
     * Listing of all project staffs.
     * 
     * Reads all project staffs or of a specific project
     * from the project_staff table in the database. 
     * Uses the project staffs.
     * 
     * @param int $projectid Primary key of a project, optional. 
     */
    public function index($projectid = 0) 
    {

        if ($this->session->userdata('logged_in'))
        {
            $session_data = $this->session->userdata('logged_in');
            
            $project_staffs = $this->project_staff_model->read_project_staffs($projectid);
            $data['project_staffs'] = $project_staffs; 
            
            // is the logged in person allowed to edit project staff
            $data['editor'] = FALSE;
            if (isset($project_staffs[0]))
            {
                foreach($project_staffs as $editor)
                {
                    // can edit
                    if ($editor->can_edit_project_staff == 1)
                    {
                        // same as logged in person
                        if ($session_data['id'] == $editor->person_id)
                        {
                            $data['editor'] = TRUE;
                        }
                    }
                }
            }
            
            $data['currentid'] = $projectid;
            $data['main_content'] = 'project_staff/project_staffs_view';
            $data['login_user_id'] = $session_data['user_id'];
            $data['login_id'] = $session_data['id'];
            $data['error_message'] = $this->session->flashdata('$error_message');
            $data['heading'] = $this->lang->line('title_db_error');
                    
            if ($projectid > 0)
            {
                $project = $this->project_model->read($projectid);
                $data['pagetitle'] = $project[0]->project_name . ': ' .
                        $this->lang->line('title_project_staffs');
            }

            else
            {
                $data['pagetitle'] = $this->lang->line('title_project_staffs');
            }

            $this->load->view('template', $data);
        }
        else
        {
            redirect('login','refresh');
        }
    }
    
    /**
     * Add a project_staff to the database.
     * 
     * Creates an empty project_staff and shows it via project_staff_view.
     * 
     * @param int $projectid Primary key of a project
     * 
     */
    public function add($id)
    {
        if ($this->session->userdata('logged_in'))
        {
            $session_data = $this->session->userdata('logged_in');
            $persons_not_in_project = $this->project_staff_model->read_not_project_staffs($id);
            
            $data['login_user_id'] = $session_data['user_id'];
            $data['login_id'] = $session_data['id'];
            
            $current_person = $this->project_staff_model->read($data['login_id']);
           
            if (isset ($current_person[0]))
            {               
                $data['person_role_id'] = $current_person[0]->person_role_id;         
            }
            else
            {
                $data['person_role_id'] = 1;
            }
             
            // is logged in user allowed to edit staff data
            $result = $this->project_staff_model->can_edit_project_staff(
                        $session_data['id'], $id);

            // admin account type = 1
            // this is just to make sure that user cannot start editing by 
            // writing the edit command in an address bar
            if ($result == TRUE || $this->session->userdata('account_type') == 1)

            {
                // an empty array
                $persons = array();

                // fill the array with person data + not selected checkbox
                if (isset ($persons_not_in_project[0])) // is there any
                {
                    foreach ($persons_not_in_project as $one_person)
                    {                
                        $person['person_id'] = $one_person->person_id;
                        $person['surname'] = $one_person->surname;
                        $person['firstname'] = $one_person->firstname;
                        $person['selected'] = FALSE;
                        $persons[] = $person;
                    }
                }
                $data['error_message'] = $this->session->flashdata('$error_message');
                $data['persons'] = $persons;              
                $data['start_date'] = '';
                $data['selected_role'] = 0;
                $data['project_id'] = $id;

                $roles_from_db = $this->person_role_model->read_names();         
                $this->load->helper("form_input_helper");
                $roles = convert_db_result_to_dropdown(
                $roles_from_db, 'id', 'role_name');        
                $data['roles'] = $roles;

                if ($id > 0)
                {
                    $project = $this->project_model->read($id);
                    $data['pagetitle'] = $project[0]->project_name . ": " .
                            $this->lang->line('title_add_project_staff');
                }
                else 
                {
                    $data['pagetitle'] = $this->lang->line('title_add_project_staff');
                }

                $data['main_content'] = 'project_staff/add_project_staff_view';
                $this->load->view('template', $data);
            }
            else
            {
                $data['project_id'] = $id;
                $error_message = $this->lang->line('not_allowed');
                $this->session->set_flashdata('$error_message', $error_message);
                redirect('project_staff/index/' . $id);
            }
        }
        else
        {
            redirect('login','refresh');
        }
    }
    
    /**
     * Insert project_staff into the database.
     * 
     * Inserts the project_staff into the project_staff table. 
     * 
     */
     public function save()
    {
        if ($this->session->userdata('logged_in'))
        {
            $session_data = $this->session->userdata('logged_in');
            $data['login_user_id'] = $session_data['user_id'];
            $data['login_id'] = $session_data['id'];
            
            $data['error_message'] = $this->session->flashdata('$error_message'); 
            $project_id = $this->input->post('project_id');
            $new_persons = $this->input->post('chk_new_staff'); 
            $start_date = $this->input->post('dtm_startdate');
            $person_role_id = $this->input->post('ddl_role'); 

            $this->load->library('form_validation');
            $this->form_validation->set_error_delimiters('<span class="error">', '</span>');
            $this->form_validation->set_rules(
                     'dtm_startdate',$this->lang->line('label_start_date'),'trim|required|xss_clean|check_date');

            if ($this->form_validation->run() == TRUE)
            {
                if (!empty($new_persons)) 
                {
                    $project = $this->project_model->read($project_id);

                    if (!empty($project[0]->project_end_date))
                    {
                        if ($start_date < $project[0]->project_end_date)
                        {
                            foreach ($new_persons as $person)
                            {
                                 $data = array(
                                    'project_id'  => $project_id,
                                    'start_date' => $start_date,
                                    'person_role_id' => $person_role_id,
                                    'person_id' => $person
                                 );
                                $this->project_staff_model->create($data);
                            }
                            redirect('project_staff/index/' . $project_id);
                        }
                        else
                        {
                            $project = $this->project_model->read($project_id);
                            $error_message = $this->lang->line('invalid_dates') . '</br>' .
                                    $this->lang->line('label_project_end_date') .
                                    $project[0]->project_end_date;
                            $this->session->set_flashdata('$error_message', $error_message);                    
                            $data['pagetitle'] = $project[0]->project_name . ': ' .
                                $this->lang->line('title_add_project_staff');
                            redirect('project_staff/add/' . $project_id);
                        }
                    }
                    else
                    {
                        foreach ($new_persons as $person)
                        {
                             $data = array(
                                'project_id'  => $project_id,
                                'start_date' => $start_date,
                                'person_role_id' => $person_role_id,
                                'person_id' => $person
                             );
                            $this->project_staff_model->create($data);
                        }
                        redirect('project_staff/index/' . $project_id);
                    }
                }
                else
                {
                    $project = $this->project_model->read($project_id);
                    $data['error_message'] = '';                    
                    $data['pagetitle'] = $project[0]->project_name . ': ' .
                        $this->lang->line('title_add_project_staff');
                    redirect('project_staff/add/' . $project_id);
                }            
            }

            else
            {
                $persons_not_in_project = $this->project_staff_model->read_not_project_staffs($project_id);

                $data['project_id'] = $project_id;
                $data['start_date'] = '';
                $data['selected_role'] = $person_role_id;

                $roles_from_db = $this->person_role_model->read_names();         
                $this->load->helper("form_input_helper");
                $roles = convert_db_result_to_dropdown(
                $roles_from_db, 'id', 'role_name');        
                $data['roles'] = $roles;

                $persons = array();

                foreach ($persons_not_in_project as $one_person)
                {
                    $person['person_id'] = $one_person->person_id;
                    $person['surname'] = $one_person->surname;
                    $person['firstname'] = $one_person->firstname;
                    $person['selected'] = FALSE;

                    if (isset($new_persons[0]))
                    {
                        foreach($new_persons as $select_person)
                        {
                            $data['select_person'] = $select_person;
                            if ($person['person_id'] == $data['select_person'])
                            {
                                $person['selected'] = TRUE;
                            }
                        }

                     }
                     $persons[] = $person;     
                 }
                 $data['persons'] = $persons;

                 $project = $this->project_model->read($project_id);
                 $data['pagetitle'] = $project[0]->project_name . ': ' .
                        $this->lang->line('title_add_project_staff');

                 $data['main_content'] = 'project_staff/add_project_staff_view';
                 $this->load->view('template', $data);
            }
        }
        else
        {
            redirect('login', 'refresh');
        }
    }
    
    /**
     * Edit a project_staff.
     * 
     * Reads a project_staff from the database using the primary key. 
     * If no project_staff is found redirects to index with error message in flash data.
     * 
     * @param int $id Primary key of the project_staff. 
     */
    
    public function edit($id)
    {
        if ($this->session->userdata('logged_in'))
        {
            $session_data = $this->session->userdata('logged_in');
            
            $project_staffs = $this->project_staff_model->read($id);        

            if (isset($project_staffs[0])) 
            {
                    $data = array(
                        'project_staff_id' => $project_staffs[0]->project_staff_id,
                        'project_id' => $project_staffs[0]->project_id,
                        'person_id' => $project_staffs[0]->person_id,
                        'start_date' => $project_staffs[0]->start_date,
                        'end_date' => $project_staffs[0]->end_date,
                        'project_name' => $project_staffs[0]->project_name,
                        'person_role_id' => $project_staffs[0]->id,
                        'surname' => $project_staffs[0]->surname,
                        'firstname' => $project_staffs[0]->firstname,
                        'can_edit_project_staff' => $project_staffs[0]->can_edit_project_staff,
                        'can_edit_project_data' => $project_staffs[0]->can_edit_project_data
                    );

                $data['login_user_id'] = $session_data['user_id'];
                $data['login_id'] = $session_data['id'];
                
                if (is_null($project_staffs[0]->person_role_id))
                {
                    $data['person_role_id'] = 0;
                }
                else 
                {
                    $data['person_role_id'] = $project_staffs[0]->person_role_id;
                }

                // is logged in user allowed to edit staff data
                $result = $this->project_staff_model->can_edit_project_staff(
                            $session_data['id'], $project_staffs[0]->project_id);
                
                // admin account type = 1
                // this is just to make sure that user cannot start editing by 
                // writing the edit command in an address bar
                if ($result == TRUE || $this->session->userdata('account_type') == 1)
                {
                    $data['error_message'] = $this->session->flashdata('$error_message');  
                    
                    // roles from db
                    $roles_from_db = $this->person_role_model->read_names(); 
                    
                    // new text in the beginning of array
                    $a = array('id' => "0", 'role_name' => $this->lang->line('select_role') );
                    array_unshift($roles_from_db, $a);
                    
                    $this->load->helper("form_input_helper");
                    
                    $roles = convert_db_result_to_dropdown(
                    $roles_from_db, 'id', 'role_name');        
                    $data['roles'] = $roles;

                    $project = $this->project_model->read(
                            $project_staffs[0]->project_id);        

                    $data['pagetitle'] = $project[0]->project_name . ": " . 
                        $this->lang->line('title_edit_project_staff');

                    $data['main_content'] = 'project_staff/edit_project_staff_view';
                    $this->load->view('template', $data);
                } 
                else
                {              
                    $error_message = $this->lang->line('not_allowed');
                    $this->session->set_flashdata('$error_message', $error_message);
                    redirect('project_staff/index/' . $data['project_id']);
                }
            
            }
        }
        else
        {
            redirect('login','refresh');
        }
    }
    
    /**
     * Update project_staff into the database.
     * 
     * Updates the project_staff into the project_staff table. 
     * 
     */
    public function save_edit()
    {
        if ($this->session->userdata('logged_in'))
        {
            $session_data = $this->session->userdata('logged_in');
            $project_id = $this->input->post('txt_project_id');
            $project_staff_id =  $this->input->post('txt_id');

            $data = array(
                 'id' => $this->input->post('txt_id'),
                 'person_role_id'=>$this->input->post('ddl_role'),
                 'start_date' => $this->input->post('dtm_startdate'),
                 'end_date' => $this->input->post('dtm_enddate'),
                 'can_edit_project_staff' => $this->input->post('chk_can_edit'),
                 'can_edit_project_data' => $this->input->post('chk_can_edit_project')
             );

            $project = $this->project_model->read(
                            $project_id);
            
             $this->load->library('form_validation');
             $this->form_validation->set_error_delimiters('<span class="error">', '</span>');

             $this->form_validation->set_rules(
                     'dtm_startdate', $this->lang->line('label_start_date'), 'trim|required|xss_clean|check_date');
             $this->form_validation->set_rules(
                     'dtm_enddate', $this->lang->line('label_end_date'), 'trim|xss_clean|check_date');

             if ($this->form_validation->run() == FALSE)
             {
                 $project_staffs = $this->project_staff_model->read($project_staff_id);        

                if (isset($project_staffs[0])) 
                {
                    $data = array(
                        'project_staff_id' => $project_staffs[0]->project_staff_id,
                        'project_id' => $project_staffs[0]->project_id,
                        'person_id' => $project_staffs[0]->person_id,
                        'start_date' => $project_staffs[0]->start_date,
                        'end_date' => $project_staffs[0]->end_date,
                        'project_name' => $project_staffs[0]->project_name,
                        'role_name' => $project_staffs[0]->role_name,
                        'id' => $project_staffs[0]->id,
                        'surname' => $project_staffs[0]->surname,
                        'firstname' => $project_staffs[0]->firstname,
                    );

                    $data['error_message'] = $this->session->flashdata('$error_message');
                    $roles_from_db = $this->person_role_model->read_names();         
                    $this->load->helper("form_input_helper");
                    // new text in the beginning of array
                    $a = array('id' => "0", 'role_name' => $this->lang->line('select_role') );
                    array_unshift($roles_from_db, $a);
                    $roles = convert_db_result_to_dropdown(
                    $roles_from_db, 'id', 'role_name');        
                    $data['roles'] = $roles;


                    $data['login_user_id'] = $session_data['user_id'];
                    $data['login_id'] = $session_data['id'];
                    $data['pagetitle'] = $project[0]->project_name . ': ' .
                                $this->lang->line('title_edit_project_staff');
                    $data['main_content'] = 'project_staff/edit_project_staff_view';
                    $this->load->view('template', $data);
                }
             }

                else
                {
                    $project = $this->project_model->read($project_id);
                    if (!empty($project[0]->project_end_date))
                    {
                        if ($data['start_date'] < $project[0]->project_end_date)
                        {
                            if (!empty($data['end_date']))
                            {
                                if ($data['start_date'] < $data['end_date'])
                                {
                                    $this->project_staff_model->update($data);
                                    redirect('project_staff/index/' . $project_id);
                                }
                                else
                                {
                                    $error_message = $this->lang->line('invalid_dates');
                                    $this->session->set_flashdata('$error_message', $error_message);
                                    redirect('project_staff/edit' . '/' . $project_staff_id);
                                }
                            }
                            else
                            {
                                $this->project_staff_model->update($data);                        
                                redirect('project_staff/index/' . $project_id);
                            }
                        }
                        else
                        {
                            $project = $this->project_model->read($project_id);
                            $error_message = $this->lang->line('invalid_dates') . '</br>' .
                                    $this->lang->line('label_project_end_date') .
                                    $project[0]->project_end_date;
                            $this->session->set_flashdata('$error_message', $error_message);                    
                            $data['pagetitle'] = $project[0]->project_name . ': ' .
                                $this->lang->line('title_edit_project_staff');
                            redirect('project_staff/edit/' . $project_staff_id);
                        }
                    }
                    else
                    {
                        if (!empty($data['end_date']))
                        {
                            if ($data['start_date'] < $data['end_date'])
                            {
                                $this->project_staff_model->update($data);
                                redirect('project_staff/index/' . $project_id);
                            }
                            else
                            {
                                $error_message = $this->lang->line('invalid_dates');
                                $this->session->set_flashdata('$error_message', $error_message);
                                redirect('project_staff/edit' . '/' . $project_staff_id);
                            }
                        }
                        else
                        {
                            $this->project_staff_model->update($data);
                            redirect('project_staff/index/' . $project_id);
                        }
                    }

                }
        }
        else
        {
            redirect('login','refresh');
        }
    }
     
    /**
     * Delete a project_staff.
     * 
     * Deletes a project_staff using the primary key.
     * 
     */
    public function delete()
    {
        if ($this->session->userdata('logged_in'))
        {
            $session_data = $this->session->userdata('logged_in');
            $data['login_user_id'] = $session_data['user_id'];
            $data['login_id'] = $session_data['id'];
            
            $id = $this->input->post('txt_id');
            $project_id = $this->input->post('txt_project_id');
            $current_person = $this->project_staff_model->read($data['login_id']);
            
             if (isset ($current_person[0]))
             {               
                $data['person_role_id'] = $current_person[0]->person_role_id;         
             }
             else
             {
                $data['person_role_id'] = 1;
             }

            // is logged in user allowed to edit staff data
                $result = $this->project_staff_model->can_edit_project_staff(
                            $session_data['id'], $project_id);
                
             // admin account type = 1
             // this is just to make sure that user cannot start editing by 
             // writing the edit command in an address bar
             if ($result == TRUE || $this->session->userdata('account_type') == 1)
             {
                $this->project_staff_model->delete(intval($id));
                redirect('project_staff/index/' . $project_id );
             }
             else
             {              
                $error_message = $this->lang->line('not_allowed');
                $this->session->set_flashdata('$error_message', $error_message);
                redirect('project_staff/index/' . $project_id);
             }
        }
        else
        {
            redirect('login', 'refresh');
        }
    }  
}

?>
