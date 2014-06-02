<?php 
/**
 * Class definition for Projet controller extends CI_Controller.
 *
 * Class definition for Project controller. Controller includes methods
 * to handle project listing, inserting, editing and deleting customers.
 * Extends CI_Controller.
 * 
 * @author  Antti Aho, Arto Ruonala, Pipsa Korkiakoski, Liisa Auer, Tuukka Kiiskinen,
 * @author Roni Kokkonen
 * @package opix
 * @subpackage controllers
 * @category project
 */
class Project extends CI_Controller 
{	
    CONST TRADITIONAL = 1;
    CONST SCRUM = 2;
    
    CONST ACTIVE = 2;
    CONST FINISHED = 1;
    
    CONST SELECTED = TRUE;
    
    private static $enum = array(1 => "Traditional", 2 => "Scrum");
    private static $enum2 = array(1 => "Finished", 2 => "Active");
    
    /**
     * Converts project_type to string.
     */
    public function toString($project_type)
    {
        return self::$enum[$project_type];
    }
    
    /**
     * Converts active to string.
     */
    public function toString2($active)
    {
        return self::$enum2[$active];
    }
    
    /**
     * Constructor of a project model.
     * 
     * Constructor of a project model. Loads project_model,
     * customer_model, and language package.
     */
    public function __construct()
    {
        parent::__construct();
        $this->lang->load('project');
        $this->load->model('project_period_model');
        $this->load->model('product_backlog_model');
        $this->load->model('project_model');
        $this->load->model('customer_model');
        $this->load->library('session'); // to send error message with redirect
    }
    
    /**
     * Listing of all active projects. 
     * 
     * Reads all active projects from the project table in the database. 
     * Uses the project/project_view.
     * 
     */
    public function index()
    {
        if ($this->session->userdata('logged_in'))
        {
            $session_data = $this->session->userdata('logged_in');
            if ($this->session->userdata('account_type') == 1)
            {
                $data = array(
                    'id' => '',
                    'project_name' => '',
                    'project_description' => '',
                    'project_start_date' => '',
                    'project_end_date' => '',
                    'customer_id' => '',
                    'customer_name' => '',
                    'project_type' => '',
                    'active' => ''
                );

                $data['projects'] = $this->project_model->read_all_active_projects();
                $data['main_content'] = 'project/projects_view';
                $data['pagetitle'] = $this->lang->line('title_project');
                $data['start_date'] = "";
                $data['end_date'] = "";
                $data['login_user_id'] = $session_data['user_id'];
                $data['login_id'] = $session_data['id'];

                $data['error_message'] = $this->session->flashdata('$error_message');
                $data['heading'] = $this->lang->line('title_db_error');
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
            redirect('login','refresh');
        }
    }
    
    /**
     * Listing of all projects.
     * 
     * Reads all projects from the project table in the database. 
     * Uses the project/project_view.
     * 
     */
    public function index2()
    {
        if ($this->session->userdata('logged_in'))
        {
            $session_data = $this->session->userdata('logged_in');
            if ($this->session->userdata('account_type') == 1)
            {
                $data = array(
                    'id' => '',
                    'project_name' => '',
                    'project_description' => '',
                    'project_start_date' => '',
                    'project_end_date' => '',
                    'customer_id' => '',
                    'customer_name' => '',
                    'project_type' => '',
                    'active' => ''
                );

                $data['projects'] = $this->project_model->read_all();
                $data['main_content'] = 'project/projects_view';
                $data['pagetitle'] = $this->lang->line('title_project');
                $data['start_date'] = "";
                $data['end_date'] = "";
                $data['login_user_id'] = $session_data['user_id'];
                $data['login_id'] = $session_data['id'];

                $data['error_message'] = $this->session->flashdata('$error_message');
                $data['heading'] = $this->lang->line('title_db_error');
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
            redirect('login','refresh');
        }
    }
    
    /**
     * Listing of all finished projects.
     * 
     * Reads all finished projects from the project table in the database. 
     * Uses the project/project_view.
     * 
     */
    public function index3()
    {
        if ($this->session->userdata('logged_in'))
        {
            $session_data = $this->session->userdata('logged_in');
            if ($this->session->userdata('account_type') == 1)
            {
                $data = array(
                    'id' => '',
                    'project_name' => '',
                    'project_description' => '',
                    'project_start_date' => '',
                    'project_end_date' => '',
                    'type_id' => '',
                    'customer_id' => '',
                    'type_name' => '',
                    'customer_name' => '',
                    'project_type' => '',
                    'active' => ''
                );

                $data['projects'] = $this->project_model->read_all_finished_projects();
                $data['main_content'] = 'project/projects_view';
                $data['pagetitle'] = $this->lang->line('title_project');
                $data['start_date'] = "";
                $data['end_date'] = "";
                $data['login_user_id'] = $session_data['user_id'];
                $data['login_id'] = $session_data['id'];

                $data['error_message'] = $this->session->flashdata('$error_message');
                $data['heading'] = $this->lang->line('title_db_error');
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
            redirect('login','refresh');
        }
    }
     
    /**
     * Add a project to the database.
     * 
     * Creates an empty project and shows it via project/project_view.
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
                    'project_name' => '',
                    'project_description' => '',
                    'project_start_date' => '',
                    'project_end_date' => '',
                    'type_id' => '',
                    'customer_id' => '',
                    'project_type' => '',
                    'active' => ''
                );

                $data['error_message'] = $this->session->flashdata('$error_message');

                // helper of this project for dropdown listbox
                $this->load->helper("form_input_helper");

                // dropdown listbox of customer_ids and names
                $customers_from_db = $this->customer_model->read_names();
                // new text in the beginning of array
                $a = array('id' => "0", 'customer_name' => $this->lang->line('select_customer') );
                array_unshift($customers_from_db, $a);
                $customers = convert_db_result_to_dropdown(
                        $customers_from_db, 'id', 'customer_name');        
                $data['customers'] = $customers;             

                $data['main_content'] = 'project/project_view';
                $data['pagetitle'] = $this->lang->line('title_insert_project');
                $data['add'] = TRUE; // show reset button
                $data['login_user_id'] = $session_data['user_id'];
                $data['login_id'] = $session_data['id'];
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
            redirect('login','refresh');
        }
    }
    
    /**
     * Edit a project.
     * 
     * Reads a project from the database using the primary key. 
     * If no customer is found redirects to index with error message in flash data.
     * 
     * @param int $id Primary key of the project 
     */
    function edit($id)
    {
        if ($this->session->userdata('logged_in'))
        {
            $session_data = $this->session->userdata('logged_in');
            if ($this->session->userdata('account_type') == 1)
            {
                $project = $this->project_model->read($id);

                if (isset($project[0])) 
                {
                    $data = array(
                        'id' => $project[0]->id,
                        'project_name' => $project[0]->project_name,
                        'project_description' => $project[0]->project_description,
                        'project_start_date' => $project[0]->project_start_date,
                        'project_end_date' => $project[0]->project_end_date,
                        'customer_id' => $project[0]->customer_id,
                        'project_type' => $project[0]->project_type,
                        'active' => $project[0]->active
                    );       

                    $data['error_message'] = $this->session->flashdata('$error_message');

                    // helper of this project for dropdown listbox
                    $this->load->helper("form_input_helper");

                    // dropdown listbox of customer_ids and names
                    $customers_from_db = $this->customer_model->read_names();
                    // new text in the beginning of array
                    $a = array('id' => "0", 'customer_name' => $this->lang->line('select_customer') );
                    array_unshift($customers_from_db, $a);
                    $customers = convert_db_result_to_dropdown(
                            $customers_from_db, 'id', 'customer_name');        
                    $data['customers'] = $customers;        

                    $data['main_content'] = 'project/project_view';
                    $data['pagetitle'] = $this->lang->line('title_edit_project');
                    $data['add'] = FALSE; // not show reset button
                    $data['login_user_id'] = $session_data['user_id'];
                    $data['login_id'] = $session_data['id'];
                    $this->load->view('template', $data);
                } 

                else 
                {
                    // error message if not found and redirected to index
                    // uses flash data for error_message
                    $error_message = $this->lang->line('missing_project');
                    $this->session->set_flashdata('$error_message', $error_message);
                    redirect('project');
                }
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
            redirect('login','refresh');
        }
    }    
    
    /**
     * Insert or update project into the database.
     * 
     * Inserts or updates the project into the project table. 
     * Validates the input data. 
     */
    public function save()
    {
        if ($this->session->userdata('logged_in'))
        {
            $session_data = $this->session->userdata('logged_in');
            
            // data from a page
            $data = array(
                'id' => $this->input->post('txt_id'),
                'project_name' => $this->input->post('txt_project_name'),
                'project_description' => $this->input->post('txt_project_description'),
                'project_start_date' => $this->input->post('dtm_project_start_date'),
                'project_end_date' => $this->input->post('dtm_project_end_date'),
                'customer_id' => $this->input->post('ddl_customer'),
                'project_type' => $this->input->post('rdo_project_type'),
                'active' => $this->input->post('rdo_active')
            );               

            $update = FALSE; // assume it it add new
            // is there an id value
            if (strlen($this->input->post("txt_id")) > 0)
            {
                $update = TRUE; // it is update
            }

            $this->load->library('form_validation');
            $this->form_validation->set_error_delimiters('<span class="error">', 
                    '</span>');

            $this->form_validation->set_rules('txt_project_name', 
                    $this->lang->line('label_project_name'), 'trim|required|max_length[255]|xss_clean');
            $this->form_validation->set_rules('txt_project_description', 
                    $this->lang->line('label_project_description'), 'trim|max_length[1000]|xss_clean');
            $this->form_validation->set_rules('dtm_project_start_date', 
                    $this->lang->line('label_project_start_date'), 'xss_clean|check_date');
            $this->form_validation->set_rules('dtm_project_end_date', 
                    $this->lang->line('label_project_end_date'), 'xss_clean|check_date');               

            if ($this->form_validation->run() == FALSE)
            {
                $data['main_content'] = 'project/project_view';
                $data['error_message'] = $this->session->flashdata('$error_message');
                if ($update == TRUE)
                {
                    $data['add'] = FALSE; // not show reset button
                    $data['pagetitle'] = $this->lang->line('title_edit_project');
                }

                else
                {
                    $data['add'] = TRUE; // show reset button
                    $data['pagetitle'] = $this->lang->line('title_insert_project');
                }

                // helper of this project for dropdown listbox
                $this->load->helper("form_input_helper");

                // dropdown listbox of customer_ids and names
                $customers_from_db = $this->customer_model->read_names();
                // new text in the beginning of array
                $a = array('id' => "0", 'customer_name' => $this->lang->line('select_customer') );
                array_unshift($customers_from_db, $a);
                $customers = convert_db_result_to_dropdown(
                        $customers_from_db, 'id', 'customer_name');        
                $data['customers'] = $customers;        
 
                $data['login_user_id'] = $session_data['user_id'];
                $data['login_id'] = $session_data['id'];
                $this->load->view('template', $data);            
            }        
            else
            {
                if (!empty($data['project_start_date']) && !empty($data['project_end_date']))
                {                                
                    if ($data['project_start_date'] < $data['project_end_date'])
                    {
                        if ($update == TRUE)  // update the database
                        {
                            $data['id'] = intval($this->input->post('txt_id'));
                            $this->project_model->update($data);     
                        }

                        else  // insert new
                        {
                            $this->project_model->create($data);
                        }
                        redirect('project'); 
                    }
                    else
                    {
                        if ($update == TRUE)
                        {
                            $error_message = $this->lang->line('invalid_dates');
                            $this->session->set_flashdata('$error_message', $error_message);
                            redirect('project/edit' . '/' . $data['id']);
                        }
                        else
                        {
                            $error_message = $this->lang->line('invalid_dates');
                            $this->session->set_flashdata('$error_message', $error_message);
                            redirect('project/add');
                        }
                    }                
                }
                else
                {
                    if ($update == TRUE)  // update the database
                    {
                        $data['id'] = intval($this->input->post('txt_id'));
                        $this->project_model->update($data);     
                    }

                    else  // insert new
                    {
                        $this->project_model->create($data);
                    }
                    redirect('project');
                }
            }
        }
        else
        {
            redirect('login','refresh');
        }
    }


    /**
    * search project between start and end date
    */
    public function find() 
    {
        if ($this->session->userdata('logged_in'))
        {
            $session_data = $this->session->userdata('logged_in');
            if ($this->session->userdata('account_type') == 1)
            {
                $data = array(
                    'id' => '',
                    'project_name' => '',
                    'project_description' => '',
                    'project_start_date' => '',
                    'project_end_date' => '',
                    'customer_id' => '',
                    'customer_name' => '',
                    'project_type' => '',
                    'active' => ''
                );

                $date_start = $this->input->post('dtm_start_date');
                $date_end = $this->input->post('dtm_end_date');

                $this->load->library('form_validation');
                $this->form_validation->set_error_delimiters('<span class="error">', 
                        '</span>');

                $this->form_validation->set_rules('dtm_start_date', 
                        $this->lang->line('label_project_start_date'), 'trim|required|xss_clean|check_date');

                $this->form_validation->set_rules('dtm_end_date', 
                        $this->lang->line('label_project_end_date'), 'trim|required|xss_clean|check_date');      


                $data['main_content'] = 'project/projects_view';
                $data['pagetitle'] = $this->lang->line('title_project');
                $data['error_message'] = "";
                $data['start_date'] = $date_start;
                $data['end_date'] = $date_end;
                $data['login_user_id'] = $session_data['user_id'];
                $data['login_id'] = $session_data['id'];

                if ($this->form_validation->run() != FALSE)
                {
                    $data['projects'] = $this->project_model->find_project_by_date(
                            $date_start, $date_end);
                    if (empty($data['projects']))
                    {
                        $data['heading'] = $this->lang->line('search_results');
                        $data['error_message'] = $this->lang->line('no_results');
                    }
                }

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
            redirect('login','refresh');
        }
    }    
    
    /**
     * Delete a project.
     * 
     * Deletes a project using the primary key.
     * 
     */
    function delete() 
    {
        if ($this->session->userdata('logged_in'))
        {
            $session_data = $this->session->userdata('logged_in');
            $data['login_user_id'] = $session_data['user_id'];
            $data['login_id'] = $session_data['id'];
            
            if ($this->session->userdata('account_type') == 1)
            {
                $id = $this->input->post('txt_id');

                if ($this->project_model->delete(intval($id)) == FALSE)
                {
                    $error_message = $this->lang->line('cannot_delete');
                    $this->session->set_flashdata('$error_message', $error_message);
                    redirect('project'); 
                }
                else
                {
                    $this->project_model->delete(intval($id));
                    redirect('project'); 
                } 
            }
            else
            {
                $error_message = $this->lang->line('not_allowed_delete');
                $this->session->set_flashdata('$error_message', $error_message);
                redirect('person/read_projects/' . $data['id']); 
            }
        }
        else
        {
            redirect('login', 'refresh');
        }
    }
    
    /**
    * show the page with no project data
    */
    public function clear()
    {
        if ($this->session->userdata('logged_in'))
        {
            $session_data = $this->session->userdata('logged_in');
            if ($this->session->userdata('account_type') == 1)
            {
                $data = array(
                    'project_name' => '',
                    'project_description' => '',
                    'project_start_date' => '',
                    'project_end_data' => '',
                    'customer_id' => '',
                    'customer_name' => '',
                    'project_type' => '',
                    'active' => ''
                );

                $data['main_content'] = 'project/projects_view';
                $data['pagetitle'] = $this->lang->line('title_project');
                $data['error_message'] = "";
                $data['start_date'] = "";
                $data['end_date'] = "";
                $data['login_user_id'] = $session_data['user_id'];
                $data['login_id'] = $session_data['id'];
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
            redirect('login','refresh');
        }
    }

}
?>
