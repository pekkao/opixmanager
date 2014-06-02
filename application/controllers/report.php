<?php
/**
 * @package opix
 * @copyright Oulu University of Applied Sciences(OUAS)
 * @license MIT
 * @version 0.1
 */

/**
 * Class definition for Report controller extends CI_Controller.
 *
 * Class definition for Report controller. Controller includes methods
 * to show reports containing information from database tables.
 * Extends CI_Controller.
 * 
 * @author Roni Kokkonen, Tuukka Kiiskinen
 * @package opix
 * @subpackage controllers
 * @category project_type
 */

class Report extends CI_Controller 
{
    CONST TRADITIONAL = 1;
    CONST SCRUM = 2;
    
    CONST ACTIVE = 2;
    CONST FINISHED = 1;
      
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
     * Constructor of a Report class.
     * 
     * Constructor of a Report class. Loads person_model,
     * customer_mode, contact_person_model,
     * project_model, project_staff_model,
     * product_backlog_model, product_backlog_item_model,
     * sprint_backlog_model, sprint_backlog_item_model,
     * sprint_task_model and language packages.
     */
    public function __construct() 
    {
        parent::__construct();
        $this->load->model('customer_model');
        $this->load->model('contact_person_model');
        $this->load->model('project_model');
        $this->load->model('person_model');
        $this->load->model('project_staff_model');
        $this->load->model('product_backlog_model');
        $this->load->model('product_backlog_item_model');
        $this->load->model('sprint_backlog_model');
        $this->load->model('sprint_backlog_item_model');
        $this->load->model('sprint_task_model');
        $this->load->model('project_period_model');
        $this->load->model('task_model');
        $this->load->model('sprint_work_model');
        $this->load->model('task_work_model');
        $this->lang->load('report');
        $this->load->library('session');
    }
    
    /**
     * Reads customers and contact persons and shows them via
     * report/customers_contacts_view
     */
    public function customers_contacts()
    {   
        if ($this->session->userdata('logged_in'))
        {
            $session_data = $this->session->userdata('logged_in');
            $all_customers = $this->customer_model->read_all();
            $customer_persons = array();

            if (isset ($all_customers[0]))
            {
                foreach($all_customers as $one_customer)
                {
                    $contact_persons = $this->contact_person_model->read_all($one_customer->id);
                    foreach ($contact_persons as $one_person)
                    {
                        $customer_person['customer_name'] = $one_customer->customer_name;
                        $customer_person['street_address'] = $one_customer->street_address;
                        $customer_person['post_code'] = $one_customer->post_code;
                        $customer_person['city'] = $one_customer->city;
                        $customer_person['surname'] = $one_person->surname;
                        $customer_person['firstname'] = $one_person->firstname;
                        $customer_person['phone_number'] = $one_person->phone_number;
                        $customer_person['email'] = $one_person->email;
                        $customer_persons[] = $customer_person;
                    }
                }
            }
            $data['customer_persons'] = $customer_persons;
            $data['main_content'] = 'report/customers_contacts_view';
            $data['pagetitle'] = $this->lang->line('title_customers');

            $data['login_user_id'] = $session_data['user_id'];
            $data['login_id'] = $session_data['id'];
            $data['error_message'] = $this->session->flashdata('$error_message');
            $data['heading'] = $this->lang->line('title_db_error');
            $this->load->view('template', $data);
        }
        else
        {
            redirect('login','refresh');
        }
    }
    
    /**
     * Reads customers and projects and shows them via
     * report/customers_projects_view
     */
    public function customers_projects()
    {
        if ($this->session->userdata('logged_in'))
        {
            $session_data = $this->session->userdata('logged_in');
            $all_customers = $this->customer_model->read_all();
            $customer_projects = array();

            if (isset ($all_customers[0]))
            {
                foreach($all_customers as $one_customer)
                {
                    $projects = $this->project_model->read_by_customerid($one_customer->id);
                    foreach ($projects as $project)
                    {
                        $customer_project['customer_name'] = $one_customer->customer_name;
                        $customer_project['street_address'] = $one_customer->street_address;
                        $customer_project['post_code'] = $one_customer->post_code;
                        $customer_project['city'] = $one_customer->city;
                        $customer_project['project_name'] = $project->project_name;
                        $customer_project['project_start_date'] = $project->project_start_date;
                        $customer_project['project_end_date'] = $project->project_end_date;
                        $customer_project['project_type'] = $project->project_type;
                        $customer_project['active'] = $project->active;
                        $customer_projects[] = $customer_project;
                    }
                }
            }
            $data['customer_projects'] = $customer_projects;
            $data['main_content'] = 'report/customers_projects_view';
            $data['pagetitle'] = $this->lang->line('title_customers_projects');

            $data['login_user_id'] = $session_data['user_id'];
            $data['login_id'] = $session_data['id'];
            $data['error_message'] = $this->session->flashdata('$error_message');
            $data['heading'] = $this->lang->line('title_db_error');
            $this->load->view('template', $data);
        }
        else
        {
            redirect('login','refresh');
        }
    }
    
    /**
     * Reads projects and persons and shows them via
     * report/projects_persons_view
     */
    public function projects_persons()
    {
        if ($this->session->userdata('logged_in'))
        {
            $session_data = $this->session->userdata('logged_in');
            $all_projects = $this->project_model->read_all();
            $project_persons = array();

            if (isset ($all_projects[0]))
            {
                foreach($all_projects as $project)
                {
                    $persons = $this->project_staff_model->read_project_staffs($project->id);
                    if (count($persons) > 0) // is there any staff in a project?
                    {
                        foreach ($persons as $person)
                        {
                            $project_person['project_name'] = $project->project_name;
                            $project_person['project_start_date'] = $project->project_start_date;
                            $project_person['project_end_date'] = $project->project_end_date;
                            $project_person['project_type'] = $project->project_type;
                            $project_person['active'] = $project->active;
                            $project_person['surname'] = $person->surname;
                            $project_person['firstname'] = $person->firstname;
                            $project_person['role_name'] = $person->role_name;
                            $project_persons[] = $project_person;
                        }
                    }
                    else 
                    {
                            $project_person['project_name'] = $project->project_name;
                            $project_person['project_start_date'] = $project->project_start_date;
                            $project_person['project_end_date'] = $project->project_end_date;
                            $project_person['project_type'] = $project->project_type;
                            $project_person['active'] = $project->active;
                            $project_person['surname'] = "";
                            $project_person['firstname'] = "";
                            $project_person['role_name'] = "";
                            $project_persons[] = $project_person;                        
                    }
                }
            }
            $data['project_persons'] = $project_persons;
            $data['main_content'] = 'report/projects_persons_view';
            $data['pagetitle'] = $this->lang->line('title_projects_persons');

            $data['login_user_id'] = $session_data['user_id'];
            $data['login_id'] = $session_data['id'];
            $data['error_message'] = $this->session->flashdata('$error_message');
            $data['heading'] = $this->lang->line('title_db_error');
            $this->load->view('template', $data);
        }
        else
        {
            redirect('login','refresh');
        }
    }
    
    /**
     * Reads active projects and persons and shows them via
     * report/projects_persons_view
     */
    public function active_projects_persons()
    {
        if ($this->session->userdata('logged_in'))
        {
            $session_data = $this->session->userdata('logged_in');
            $all_projects = $this->project_model->read_all_active_projects();
            $project_persons = array();

            if (isset ($all_projects[0]))
            {
                foreach($all_projects as $project)
                {
                    $persons = $this->project_staff_model->read_project_staffs($project->id);
                    if (count($persons) > 0) // is there any staff in a project?
                    {
                        foreach ($persons as $person)
                        {
                            $project_person['project_name'] = $project->project_name;
                            $project_person['project_start_date'] = $project->project_start_date;
                            $project_person['project_end_date'] = $project->project_end_date;
                            $project_person['project_type'] = $project->project_type;
                            $project_person['active'] = $project->active;
                            $project_person['surname'] = $person->surname;
                            $project_person['firstname'] = $person->firstname;
                            $project_person['role_name'] = $person->role_name;
                            $project_persons[] = $project_person;
                        }
                    }
                    else
                    {
                            $project_person['project_name'] = $project->project_name;
                            $project_person['project_start_date'] = $project->project_start_date;
                            $project_person['project_end_date'] = $project->project_end_date;
                            $project_person['project_type'] = $project->project_type;
                            $project_person['active'] = $project->active;
                            $project_person['surname'] = "";
                            $project_person['firstname'] = "";
                            $project_person['role_name'] = "";
                            $project_persons[] = $project_person;                        
                    }
                }
            }
            $data['project_persons'] = $project_persons;
            $data['main_content'] = 'report/projects_persons_view';
            $data['pagetitle'] = $this->lang->line('title_projects_persons');

            $data['login_user_id'] = $session_data['user_id'];
            $data['login_id'] = $session_data['id'];
            $data['error_message'] = $this->session->flashdata('$error_message');
            $data['heading'] = $this->lang->line('title_db_error');
            $this->load->view('template', $data);
        }
        else
        {
            redirect('login','refresh');
        }
    }
    
    /**
     * Reads finished projects and persons and shows them via
     * report/projects_persons_view
     */
    public function finished_projects_persons()
    {
        if ($this->session->userdata('logged_in'))
        {
            $session_data = $this->session->userdata('logged_in');
            $all_projects = $this->project_model->read_all_finished_projects();
            $project_persons = array();

            if (isset ($all_projects[0]))
            {
                foreach($all_projects as $project)
                {
                    $persons = $this->project_staff_model->read_project_staffs($project->id);
                    if (count($persons) > 0) // is there any staff in a project?
                    {
                        foreach ($persons as $person)
                        {
                            $project_person['project_name'] = $project->project_name;
                            $project_person['project_start_date'] = $project->project_start_date;
                            $project_person['project_end_date'] = $project->project_end_date;
                            $project_person['project_type'] = $project->project_type;
                            $project_person['active'] = $project->active;
                            $project_person['surname'] = $person->surname;
                            $project_person['firstname'] = $person->firstname;
                            $project_person['role_name'] = $person->role_name;
                            $project_persons[] = $project_person;
                        }
                    }
                    else 
                    {
                            $project_person['project_name'] = $project->project_name;
                            $project_person['project_start_date'] = $project->project_start_date;
                            $project_person['project_end_date'] = $project->project_end_date;
                            $project_person['project_type'] = $project->project_type;
                            $project_person['active'] = $project->active;
                            $project_person['surname'] = "";
                            $project_person['firstname'] = "";
                            $project_person['role_name'] = "";
                            $project_persons[] = $project_person;                        
                    }
                }
            }
            $data['project_persons'] = $project_persons;
            $data['main_content'] = 'report/projects_persons_view';
            $data['pagetitle'] = $this->lang->line('title_projects_persons');

            $data['login_user_id'] = $session_data['user_id'];
            $data['login_id'] = $session_data['id'];
            $data['error_message'] = $this->session->flashdata('$error_message');
            $data['heading'] = $this->lang->line('title_db_error');
            $this->load->view('template', $data);
        }
        else
        {
            redirect('login','refresh');
        }
    }
    
    /**
     * Reads persons and projects and shows them via
     * report/persons_projects_view
     */
    public function persons_projects()
    {
        if ($this->session->userdata('logged_in'))
        {
            $session_data = $this->session->userdata('logged_in');
            $all_persons = $this->project_staff_model->read_all();
            $person_projects = array();

            if (isset ($all_persons[0]))
            {
                foreach($all_persons as $person)
                {
                    $projects = $this->project_model->read($person->project_id);
                    foreach ($projects as $project)
                    {
                        $person_project['surname'] = $person->surname;
                        $person_project['firstname'] = $person->firstname;
                        $person_project['role_name'] = $person->role_name;
                        $person_project['project_name'] = $project->project_name;
                        $person_project['project_start_date'] = $project->project_start_date;
                        $person_project['project_end_date'] = $project->project_end_date;
                        $person_project['project_type'] = $project->project_type;
                        $person_project['active'] = $project->active;                   
                        $person_projects[] = $person_project;
                    }
                }
            }

            $data['person_projects'] = $person_projects;
            $data['main_content'] = 'report/persons_projects_view';
            $data['pagetitle'] = $this->lang->line('title_persons_projects');

            $data['login_user_id'] = $session_data['user_id'];
            $data['login_id'] = $session_data['id'];
            $data['error_message'] = $this->session->flashdata('$error_message');
            $data['heading'] = $this->lang->line('title_db_error');
            $this->load->view('template', $data);
        }
        else
        {
            redirect('login','refresh');
        }
    }
    
    /**
     * Reads projects and converts them to a dropdownlist.
     */
    public function choose_project()
    {
        if ($this->session->userdata('logged_in'))
        {
            $session_data = $this->session->userdata('logged_in');
            $data['selected_project'] = 0;
            $projects_from_db = $this->project_model->read_projects();
            $this->load->helper("form_input_helper");
            $projects = convert_db_result_to_dropdown(
            $projects_from_db, 'id', 'project_name');        
            $data['projects'] = $projects;

            $data['pagetitle'] = $this->lang->line('title_choose_project');
            $data['login_user_id'] = $session_data['user_id'];
            $data['login_id'] = $session_data['id'];
            $data['main_content'] = 'report/choose_project_view';
            $this->load->view('template', $data);
        }
        else
        {
            redirect('login','refresh');
        }
    }
    
    /*
     * Reads project_backlogs and backlog_items from selected project and shows them via
     * report/project_backlogs_items_view
     */
    public function project_backlogs_items()
    {
        if ($this->session->userdata('logged_in'))
        {
            $session_data = $this->session->userdata('logged_in');
            $project_id = $this->input->post('ddl_project');

            $product_backlogs = $this->product_backlog_model->read_all($project_id);
           
            $ppbis = array(); // $ppbis = project_product_backlogs_items

            if (isset ($product_backlogs[0]))
            {
                foreach($product_backlogs as $product_backlog)
                {
                    $backlog_items = $this->product_backlog_item_model->read_all($product_backlog->id);
                    if (isset ($backlog_items[0]))
                    {
                        foreach ($backlog_items as $backlog_item)
                        {
                            $ppbi['backlog_name'] = $product_backlog->backlog_name;
                            $ppbi['product_visio'] = $product_backlog->product_visio;
                            $ppbi['product_current_state'] = $product_backlog->product_current_state;
                            if (!(is_null($product_backlog->product_owner)))
                            {
                                $name = $this->person_model->read_name($product_backlog->product_owner); 
                                $ppbi['product_owner'] = $name[0]->name;
                            }
                            else 
                            {
                                $ppbi['product_owner'] = "";
                            }
                            $ppbi['item_name'] = $backlog_item->item_name;
                            $ppbi['item_description'] = $backlog_item->item_description;
                            $ppbi['start_date'] = $backlog_item->start_date;
                            $ppbi['priority'] = $backlog_item->priority;
                            $ppbi['business_value'] = $backlog_item->business_value;
                            $ppbi['estimate_points'] = $backlog_item->estimate_points;
                            $ppbi['effort_estimate_hours'] = $backlog_item->effort_estimate_hours;
                            $ppbi['acceptance_criteria'] = $backlog_item->acceptance_criteria;
                            $ppbi['release_target'] = $backlog_item->release_target;
                            $ppbis[] = $ppbi;
                        }
                     }
                     else  // backlog has no items
                     {
                            $ppbi['backlog_name'] = $product_backlog->backlog_name;
                            $ppbi['product_visio'] = $product_backlog->product_visio;
                            $ppbi['product_current_state'] = $product_backlog->product_current_state;
                            if (!(is_null($product_backlog->product_owner)))
                            {
                                $name = $this->person_model->read_name($product_backlog->product_owner); 
                                $ppbi['product_owner'] = $name[0]->name;
                            }
                            else 
                            {
                                $ppbi['product_owner'] = "";
                            }
                            $ppbi['item_name'] = "";
                            $ppbi['item_description'] = "";
                            $ppbi['start_date'] = "";
                            $ppbi['priority'] = "";
                            $ppbi['business_value'] = "";
                            $ppbi['estimate_points'] = "";
                            $ppbi['effort_estimate_hours'] = "";
                            $ppbi['acceptance_criteria'] = "";
                            $ppbi['release_target'] = "";
                            $ppbis[] = $ppbi;
                     }
                }
            }

            $data['ppbis'] = $ppbis;
            $data['main_content'] = 'report/project_backlogs_items_view';
            $project = $this->project_model->read($project_id);
            $data['pagetitle'] = $project[0]->project_name;

            $data['login_user_id'] = $session_data['user_id'];
            $data['login_id'] = $session_data['id'];
            $data['error_message'] = $this->session->flashdata('$error_message');
            $data['heading'] = $this->lang->line('title_db_error');
            $this->load->view('template', $data);
        }
        else
        {
            redirect('login','refresh');
        }
    }
    
    /**
     * Reads customers and converts them to a dropdownlist.
     */
    public function choose_customer()
    {
        if ($this->session->userdata('logged_in'))
        {
            $session_data = $this->session->userdata('logged_in');
            $data['selected_customer'] = 0;
            $customers_from_db = $this->customer_model->read_names();
            $this->load->helper("form_input_helper");
            $customers = convert_db_result_to_dropdown(
            $customers_from_db, 'id', 'customer_name');        
            $data['customers'] = $customers;

            $data['pagetitle'] = $this->lang->line('title_choose_customer');
            $data['login_user_id'] = $session_data['user_id'];
            $data['login_id'] = $session_data['id'];
            $data['main_content'] = 'report/choose_customer_view';
            $this->load->view('template', $data);

        }
        else
        {
            redirect('login','refresh');
        }
    }
    
    /**
     * Reads contacts from selected customer and shows them via
     * report/customer_contacts_view
     */
    public function customer_contacts()
    {
        if ($this->session->userdata('logged_in'))
        {
            $session_data = $this->session->userdata('logged_in');
            $customer_id = $this->input->post('ddl_customer');

            $contacts = $this->contact_person_model->read_all($customer_id);

            $customer_contacts = array();

            if (isset ($contacts[0]))
            {
                foreach($contacts as $contact)
                {
                    $customer_contact['surname'] = $contact->surname;
                    $customer_contact['firstname'] = $contact->firstname;
                    $customer_contact['phone_number'] = $contact->phone_number;
                    $customer_contact['email'] = $contact->email;
                    $customer_contacts[] = $customer_contact;

                }
            }

            $data['customer_contacts'] = $customer_contacts;
            $data['main_content'] = 'report/customer_contacts_view';
            $customer = $this->customer_model->read($customer_id);
            $data['pagetitle'] = $customer[0]->customer_name;

            $data['login_user_id'] = $session_data['user_id'];
            $data['login_id'] = $session_data['id'];
            $data['error_message'] = $this->session->flashdata('$error_message');
            $data['heading'] = $this->lang->line('title_db_error');
            $this->load->view('template', $data);
        }
        else
        {
            redirect('login','refresh');
        }
    }
    
    /**
     * Reads customers and converts them to a dropdownlist.
     */
    public function choose_customer_project()
    {
        if ($this->session->userdata('logged_in'))
        {
            $session_data = $this->session->userdata('logged_in');
            $data['selected_customer'] = 0;
            $customers_from_db = $this->customer_model->read_names();
            $this->load->helper("form_input_helper");
            $customers = convert_db_result_to_dropdown(
            $customers_from_db, 'id', 'customer_name');        
            $data['customers'] = $customers;

            $data['pagetitle'] = $this->lang->line('title_choose_customer');

            $data['login_user_id'] = $session_data['user_id'];
            $data['login_id'] = $session_data['id'];
            $data['main_content'] = 'report/choose_customer_project_view';
            $this->load->view('template', $data);

        }
        else
        {
            redirect('login','refresh');
        }
    }
    
    /**
     * Reads projects from selected customer and shows them via
     * report/customer_projects_view
     */
    public function customer_projects()
    {
        if ($this->session->userdata('logged_in'))
        {
            $session_data = $this->session->userdata('logged_in');
            $customer_id = $this->input->post('ddl_customer');

            $projects = $this->project_model->read_by_customerid($customer_id);
           
            $customer_projects = array();

            if (isset ($projects[0]))
            {
                foreach($projects as $project)
                {
                    $customer_project['project_name'] = $project->project_name;
                    $customer_project['project_start_date'] = $project->project_start_date;
                    $customer_project['project_end_date'] = $project->project_end_date;
                    $customer_project['project_type'] = $project->project_type;
                    $customer_project['active'] = $project->active;
                    $customer_projects[] = $customer_project;

                }
            }

            $data['customer_projects'] = $customer_projects;
            $data['main_content'] = 'report/customer_projects_view';
            $customer = $this->customer_model->read($customer_id);
            $data['pagetitle'] = $customer[0]->customer_name;

            $data['login_user_id'] = $session_data['user_id'];
            $data['login_id'] = $session_data['id'];
            $data['error_message'] = $this->session->flashdata('$error_message');
            $data['heading'] = $this->lang->line('title_db_error');
            $this->load->view('template', $data);
        }
        else
        {
            redirect('login','refresh');
        }
    }
    
    /**
     * Reads projects and converts them to a dropdownlist.
     */
    public function choose_project_sprint()
    {
        if ($this->session->userdata('logged_in'))
        {
            $session_data = $this->session->userdata('logged_in');
            $data['selected_project'] = 0;
            $projects_from_db = $this->project_model->read_projects();
            $this->load->helper("form_input_helper");
            $projects = convert_db_result_to_dropdown(
            $projects_from_db, 'id', 'project_name');        
            $data['projects'] = $projects;

            $data['pagetitle'] = $this->lang->line('title_choose_project');

            $data['login_user_id'] = $session_data['user_id'];
            $data['login_id'] = $session_data['id'];
            $data['main_content'] = 'report/choose_project_sprint_view';
            $this->load->view('template', $data);

        }
        else
        {
            redirect('login','refresh');
        }
    }
    
    /*
     * Reads sprint_backlogs and sprint_tasks from selected project
     * and shows them via report/project_sprints_tasks_view
     */
    public function project_sprints_tasks()
    {
        if ($this->session->userdata('logged_in'))
        {
            $session_data = $this->session->userdata('logged_in');
            $project_id = $this->input->post('ddl_project');

            $product_backlogs = $this->product_backlog_model->read_all($project_id);
           
            $psts = array(); // $psts = project_sprints_tasks_items

            if (isset ($product_backlogs[0]))
            {
                foreach($product_backlogs as $product_backlog)
                {
                    $sprint_backlogs = $this->sprint_backlog_model->read_all($product_backlog->id);
                    foreach ($sprint_backlogs as $sprint_backlog)
                    {
                        $sprint_backlog_items = $this->sprint_backlog_item_model->read_all($sprint_backlog->id);
                        foreach ($sprint_backlog_items as $sprint_backlog_item)
                        {
                            $sprint_tasks = $this->sprint_task_model->read_all($sprint_backlog_item->id);
                            if (isset($sprint_tasks[0]))
                            {
                                foreach ($sprint_tasks as $sprint_task)
                                {
                                    $pst['sprint_name'] = $sprint_backlog->sprint_name;
                                    $pst['sprint_description'] = $sprint_backlog->sprint_description;
                                    $pst['start_date'] = $sprint_backlog->start_date;
                                    $pst['end_date'] = $sprint_backlog->end_date;
                                    $pst['item_name'] = $sprint_backlog_item->item_name;
                                    $pst['task_name'] = $sprint_task->task_name;
                                    $pst['task_description'] = $sprint_task->task_description;
                                    $pst['effort_estimate_hours'] = $sprint_task->effort_estimate_hours;
                                    $psts[] = $pst;
                                }
                            }
                            else // no tasks defined
                            {
                                $pst['sprint_name'] = $sprint_backlog->sprint_name;
                                $pst['sprint_description'] = $sprint_backlog->sprint_description;
                                $pst['start_date'] = $sprint_backlog->start_date;
                                $pst['end_date'] = $sprint_backlog->end_date;
                                $pst['item_name'] = $sprint_backlog_item->item_name;
                                $pst['task_name'] = ""; 
                                $pst['task_description'] = "";
                                $pst['effort_estimate_hours'] = $sprint_backlog_item->effort_estimate_hours;;
                                $psts[] = $pst;                                
                            }
                        }
                    }
                }
            }

            $data['psts'] = $psts;
            $data['main_content'] = 'report/project_sprints_tasks_view';
            $project = $this->project_model->read($project_id);
            $data['pagetitle'] = $project[0]->project_name;

            $data['login_user_id'] = $session_data['user_id'];
            $data['login_id'] = $session_data['id'];
            $data['error_message'] = $this->session->flashdata('$error_message');
            $data['heading'] = $this->lang->line('title_db_error');
            $this->load->view('template', $data);
        }
        else
        {
            redirect('login','refresh');
        }
    }
    
    /*
     * Reads project periods and converts them to a dropdownlist.
     */
    public function choose_project_period()
    {
        if ($this->session->userdata('logged_in'))
        {
            $session_data = $this->session->userdata('logged_in');
            $data['selected_project'] = 0;
            $projects_from_db = $this->project_model->read_traditional_projects();
            $this->load->helper("form_input_helper");
            $projects = convert_db_result_to_dropdown(
            $projects_from_db, 'id', 'project_name');        
            $data['projects'] = $projects;

            $data['pagetitle'] = $this->lang->line('title_choose_project');

            $data['login_user_id'] = $session_data['user_id'];
            $data['login_id'] = $session_data['id'];
            $data['main_content'] = 'report/choose_project_period_view';
            $this->load->view('template', $data);
        }
        else
        {
            redirect('login','refresh');
        }
    }
    
    /*
     * Reads project periods and period tasks and shows them via 
     * report/project_periods_tasks_view
     */
    public function project_periods_tasks()
    {
        if ($this->session->userdata('logged_in'))
        {
            $session_data = $this->session->userdata('logged_in');
            $project_id = $this->input->post('ddl_project');

            $project_periods = $this->project_period_model->read_all($project_id);
          
            $ppts = array(); // $ppts = project_period_tasks

            if (isset ($project_periods[0]))
            {
                foreach($project_periods as $project_period)
                {
                    $tasks = $this->task_model->read_all($project_period->id);

                    foreach ($tasks as $task)
                    {
                        $ppt['period_name'] = $project_period->period_name;
                        $ppt['period_start_date'] = $project_period->period_start_date;
                        $ppt['period_end_date'] = $project_period->period_end_date;
                        $ppt['milestone'] = $project_period->milestone;
                        $ppt['period_description'] = $project_period->period_description;
                        $ppt['task_name'] = $task->task_name;
                        $ppt['task_description'] = $task->task_description;
                        $ppt['task_start_date'] = $task->task_start_date;
                        $ppt['task_end_date'] = $task->task_end_date;
                        $ppt['effort_estimate_hours'] = $task->effort_estimate_hours;
                        $ppt['status_name'] = $task->status_name;
                        $ppt['task_type_name'] = $task->task_type_name;
                        $ppts[] = $ppt;
                    }
                }
            }

            $data['ppts'] = $ppts;
            $data['main_content'] = 'report/project_periods_tasks_view';
            $project = $this->project_model->read($project_id);
            $data['pagetitle'] = $project[0]->project_name;

            $data['login_user_id'] = $session_data['user_id'];
            $data['login_id'] = $session_data['id'];
            $data['error_message'] = $this->session->flashdata('$error_message');
            $data['heading'] = $this->lang->line('title_db_error');
            $this->load->view('template', $data);
        }
        else
        {
            redirect('login','refresh');
        }
    }
    
    /*
     * Reads persons and converts them to a dropdownlist.
     */
    public function choose_person()
    {
        if ($this->session->userdata('logged_in'))
        {
            $session_data = $this->session->userdata('logged_in');
            $data['selected_person'] = 0;
            $persons_from_db = $this->person_model->read_names();
            $this->load->helper("form_input_helper");
            $persons = convert_db_result_to_dropdown(
            $persons_from_db, 'id', 'name');        
            $data['persons'] = $persons;

            $data['pagetitle'] = $this->lang->line('title_choose_person');
            $data['login_user_id'] = $session_data['user_id'];
            $data['login_id'] = $session_data['id'];
            $data['main_content'] = 'report/choose_person_view';
            $this->load->view('template', $data);

        }
        else
        {
            redirect('login','refresh');
        }
    }
    
    /*
     * Reads person's sprint and task works and shows them via
     * report/person_works_view
     */
    public function person_works()
    {
        if ($this->session->userdata('logged_in'))
        {
            $session_data = $this->session->userdata('logged_in');
            $person_id = $this->input->post('ddl_person');

            $person_sprint_works = $this->sprint_work_model->read_all($person_id);

            $person_task_works = $this->task_work_model->read_all($person_id);
            
            $psws = array(); // $psws = person_sprint_works
            $ptws = array(); // $ptws = person_task_works

            if (isset ($person_sprint_works[0]))
            {
                foreach($person_sprint_works as $person_sprint_work)
                {                
                    $psw['task_name'] = $person_sprint_work->task_name;
                    $psw['description'] = $person_sprint_work->description;
                    $psw['work_done_hours'] = $person_sprint_work->work_done_hours;
                    $psw['work_remaining_hours'] = $person_sprint_work->work_remaining_hours;
                    $psws[] = $psw;

                }
            }
            $data['psws'] = $psws;

            if (isset ($person_task_works[0]))
            {
                foreach($person_task_works as $person_task_work)
                {                
                    $ptw['task_name'] = $person_task_work->task_name;
                    $ptw['description'] = $person_task_work->description;
                    $ptw['work_hours'] = $person_task_work->work_hours;
                    $ptw['work_date'] = $person_task_work->work_date;
                    $ptws[] = $ptw;

                }
            }
            $data['ptws'] = $ptws;

            $data['main_content'] = 'report/person_works_view';
            $person = $this->person_model->read($person_id);
            $data['pagetitle'] = $person[0]->surname . ' ' . $person[0]->firstname;

            $data['login_user_id'] = $session_data['user_id'];
            $data['login_id'] = $session_data['id'];
            $data['error_message'] = $this->session->flashdata('$error_message');
            $data['heading'] = $this->lang->line('title_db_error');
            $this->load->view('template', $data);
        }
        else
        {
            redirect('login','refresh');
        }
    }
    
}