<?php
/**
 * @package opix
 * @copyright Oulu University of Applied Sciences(OUAS)
 * @license MIT
 * @version 0.1
 */

/**
 * Class definition for Contact_person controller extends CI_Controller.
 *
 * Class definition for Contact_person controller. Controller includes methods
 * to handle contact persons listing, inserting, editing and deleting contacts.
 * Extends CI_Controller.
 * 
 * @author Liisa Auer
 * @package opix
 * @subpackage controllers
 * @category customer
 */
class Contact_Person extends CI_Controller 
{
    /**
     * Constructor of a contact_person model.
     * 
     * Constructor of a contact_person model. Loads contact_person_model and language package.
     */
    public function __construct() 
    {
        parent::__construct();
        $this->load->model('contact_person_model');
        $this->load->model('customer_model');
        $this->lang->load('contact_person');
        $this->load->library('session'); // to send error message with redirect
    }

    /**
     * Listing of all contact persons.
     * 
     * Reads all contact persons or of a specific company
     * from the contact_person table in the database. 
     * Uses the contact_persons_view.
     * 
     * @param int $customerid Selected customerid, default is zero. 
     */
    
    public function index($customerid = 0) 
    {
        if ($this->session->userdata('logged_in'))
        {
            $session_data = $this->session->userdata('logged_in');
            $data = array(
                'id' => '',
                'surname' => '',
                'firstname' => '',
                'title' => '',
                'phone_number' => '',
                'email' => '',
                'customer_id' => '', 
                'customer_name' => ''
            );

            $data['contact_persons'] = $this->contact_person_model->read_all($customerid);
            $data['currentcustomerid'] = $customerid;
            $data['main_content'] = 'contact_person/contact_persons_view';

            // read all or specific customer contacts
            if ($customerid > 0)
            {
                $customer = $this->customer_model->read($customerid);
                $data['pagetitle'] = $customer[0]->customer_name  . ': ' .
                        $this->lang->line('title_contacts');
            }
            else
            {
                $data['pagetitle'] = $this->lang->line('title_contacts');
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
     * Add a contact_person to the database.
     * 
     * Creates an empty contact_person and shows it via contact_person_view.
     */
    public function add($currentcustomerid = 0)
    {
        if ($this->session->userdata('logged_in'))
        {
            $session_data = $this->session->userdata('logged_in');
            
            if ($this->session->userdata('account_type') == 1)
            {
                $data = array(
                      'id'            => '',
                      'surname'       => '',
                      'firstname'     => '',
                      'title'         => '',
                      'phone_number'  => '',
                      'email'         => '',
                      'customer_id'   => $currentcustomerid,
                      'customer_name' =>''
                    );
                $data['main_content'] = 'contact_person/contact_person_view';
                $data['pagetitle'] = $this->lang->line('title_add_contact_person');
                $data['add'] = TRUE; // show reset button
                $data['login_user_id'] = $session_data['user_id'];
                $data['login_id'] = $session_data['id'];

                if ($currentcustomerid == 0)
                {
                    // dropdown listbox of customerids and names
                    $customers_from_db = $this->customer_model->read_names();
                    // new text in the beginning of array
                    $a = array('id' => "0", 'customer_name' => $this->lang->line('select_customer') );
                    array_unshift($customers_from_db, $a);
                    // helper of this project
                    $this->load->helper("form_input_helper");
                    $customers = convert_db_result_to_dropdown(
                            $customers_from_db,'id','customer_name');        
                    $data['customers'] = $customers;
                }
                else
                {
                    $data['customers'] = NULL;
                    $customer = $this->customer_model->read($currentcustomerid);
                    $data['customer_name'] = $customer[0]->customer_name;
                }
                $this->load->view('template', $data);
            }
            else
            {
                $error_message = $this->lang->line('not_allowed');
                $this->session->set_flashdata('$error_message', $error_message);
                redirect('contact_person/index/' . $currentcustomerid);
            }
        }
        else
        {
            redirect('login','refresh');
        }
    }
    
    /**
     * Edit a contact_person.
     * 
     * Reads a contact_person from the database using the primary key. 
     * If no contact_person is found redirects to the index page 
     * with error message in flash data.
     * 
     * @param int $id Primary key of the contact_person 
     */
    public function edit($id, $currentcustomerid)
    {
        if ($this->session->userdata('logged_in'))
        {
            $session_data = $this->session->userdata('logged_in');
            if ($this->session->userdata('account_type') == 1)
            {
                $contact_person = $this->contact_person_model->read($id);
                if (isset($contact_person[0])) 
                {
                    $data = array(
                        'id'         => $contact_person[0]->id,
                        'surname'    => $contact_person[0]->surname,
                        'firstname'  => $contact_person[0]->firstname,
                        'title'      => $contact_person[0]->title,
                        'phone_number' => $contact_person[0]->phone_number,
                        'email'      => $contact_person[0]->email,
                        'customer_id' => $contact_person[0]->customer_id,
                        'customer_name' => $contact_person[0]->customer_name

                    );
                    $data['main_content'] = 'contact_person/contact_person_view';
                    $data['pagetitle'] = $this->lang->line('title_edit_contact_person');
                    $data['add'] = FALSE; // not show reset button
                    $data['login_user_id'] = $session_data['user_id'];
                    $data['login_id'] = $session_data['id'];

                    if ($data['customer_id'] == 0)
                    {
                        // dropdown listbox of customerids and names
                        $customers_from_db = $this->customer_model->read_names();
                        // helper of this project
                        $this->load->helper("form_input_helper");
                        $customers = convert_db_result_to_dropdown(
                                $customers_from_db,'id','customer_name');        
                        $data['customers'] = $customers;
                    }
                    else
                    {
                        $data['customers'] = NULL;
                    }
                    $this->load->view('template', $data);
                } 
                else 
                {
                    // error message if not found and redirected to index
                    // uses flash data for error_message
                    $error_message = $this->lang->line('missing_contact_person');
                    $this->session->set_flashdata('$error_message', $error_message);
                    redirect('contact_person/index/' . $currentcustomerid);
                }
            }
            else
            {
                $error_message = $this->lang->line('not_allowed');
                $this->session->set_flashdata('$error_message', $error_message);
                redirect('contact_person/index/' . $currentcustomerid);
            }
        }
        else
        {
            redirect('login','refresh');
        }
    }
    
    /**
     * Insert or update contact_person into the database.
     * 
     * Inserts or updates the contact_person into the contact_person table. 
     * Validates the input data; contact_person name must exist.
     */
    public function save()
    {
        if ($this->session->userdata('logged_in'))
        {
            $session_data = $this->session->userdata('logged_in');
            if ($this->session->userdata('account_type') == 1)
            {
                // data from a page
                $data = array(
                      'id'          => $this->input->post('txt_id'),
                      'surname'     => $this->input->post('txt_surname'),
                      'firstname'   => $this->input->post('txt_firstname'),
                      'title'       => $this->input->post('txt_title'),
                      'phone_number' => $this->input->post('tel_phonenumber'),
                      'email'       => $this->input->post('eml_email'),
                      'customer_id'  => $this->input->post('ddl_customer')
                    );

                $update = FALSE; // assume it is add new
                // is there an id value
                if (strlen($this->input->post("txt_id")) > 0)
                {
                    $update = TRUE; // it is update
                }

                $this->load->library('form_validation');
                $this->form_validation->set_error_delimiters('<span class="error">', '</span>');

                $this->form_validation->set_rules(
                        'txt_surname', $this->lang->line('missing_surname'), 'trim|required|max_length[255]|xss_clean');
                $this->form_validation->set_rules(
                        'txt_firstname', $this->lang->line('missing_firstname'), 'trim|required|max_length[255]|xss_clean');
                $this->form_validation->set_rules(
                        'eml_email', $this->lang->line('invalid_email'), 'trim|valid_email|max_length[255]|xss_clean');
                $this->form_validation->set_rules(
                        'txt_title', 'trim|max_length[255]|xss_clean');
                $this->form_validation->set_rules(
                        'tel_phonenumber', $this->lang->line('invalid_phonenumber'), 'numeric|max_length[255]');

                // CI catches the run time error !!!
                $this->form_validation->set_rules(
                        'txt_customer_id', $this->lang->line('missing_customer'), 'greater_than[0]');  

                if ($this->form_validation->run() == FALSE) 
                {
                    $data['login_user_id'] = $session_data['user_id'];
                    $data['login_id'] = $session_data['id'];
                    $data['main_content'] = 'contact_person/contact_person_view';
                    $data['pagetitle'] = $this->lang->line('title_add_contact_person');

                    if ($update == TRUE)
                    {
                        $data['add'] = FALSE; // not show reset button
                    }
                    else
                    {
                        $data['add'] = TRUE; // show reset button
                    }

                    // dropdown listbox of customerids and names
                    $customers_from_db = $this->customer_model->read_names();
                    if ($update == FALSE)
                    {
                        // new text in the beginning of array
                        $a = array('id' => "0", 'customer_name' => $this->lang->line('select_customer') );
                        array_unshift($customers_from_db, $a);
                    }

                    // helper of this project
                    $this->load->helper("form_input_helper");
                    $customers = convert_db_result_to_dropdown(
                            $customers_from_db,'id','customer_name');        
                    $data['customers'] = $customers;

                    // current customer
                    $customer = $this->customer_model->read($data['customer_id']);
                    $data['customer_name'] = $customer[0]->customer_name;            

                    $this->load->view('template', $data);
                }
                else
                {
                    if ($update == TRUE)  // update the database
                    {
                        $data['id'] = intval($this->input->post('txt_id'));
                        $this->contact_person_model->update($data);     
                    }
                    else  // insert new
                    {
                        $this->contact_person_model->create($data);
                    }
                    // show contacts of a company 
                    redirect('contact_person/index/' . $data['customer_id']);
                }
            }
            else
            {
                $error_message = $this->lang->line('not_allowed');
                $this->session->set_flashdata('$error_message', $error_message);
                redirect('contact_person/index/' . $currentcustomerid);
            }
        }
        else
        {
            redirect('login','refresh');
        }
    }

    /**
     * Delete a contact_person.
     * 
     * Deletes a contact_person using the primary key.
     * 
     * @param int $id Primary key of the contact_person. 
     */
    public function delete()
    {
        if ($this->session->userdata('logged_in'))
        {
            $session_data = $this->session->userdata('logged_in');
            $data['login_user_id'] = $session_data['user_id'];
            $data['login_id'] = $session_data['id'];
            if ($this->session->userdata('account_type') == 1)
            {
                $id = $this->input->post('txt_id');
                $customer_id  = $this->input->post('txt_customer_id');

                $this->contact_person_model->delete(intval($id));
                redirect('contact_person/index/' . $customer_id);
            }
            else
            {
                $customer_id  = $this->input->post('txt_customer_id');
                $error_message = $this->lang->line('not_allowed');
                $this->session->set_flashdata('$error_message', $error_message);
                redirect('contact_person/index/' . $customer_id);
            }
        }
    }    
}

?>
