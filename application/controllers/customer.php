<?php
/**
 * @package opix
 * @copyright Oulu University of Applied Sciences(OUAS)
 * @license MIT
 * @version 0.1
 */

/**
 * Class definition for Customer controller extends CI_Controller.
 *
 * Class definition for Customer controller. Controller includes methods
 * to handle customer listing, inserting, editing and deleting customers.
 * Extends CI_Controller.
 * 
 * @author Liisa Auer
 * @package opix
 * @subpackage controllers
 * @category customer
 */

class Customer extends CI_Controller 
{
    /**
     * Constructor of a customer model.
     * 
     * Constructor of a customer model. Loads customer_model and language package.
     */
    public function __construct() 
    {
        parent::__construct();
        $this->load->model('customer_model');
        $this->lang->load('customer');
        $this->load->library('session'); // to send error message with redirect
    }

    /**
     * Listing of all customers.
     * 
     * Reads all customers from the customer table in the database. 
     * Uses the customer/customers_view.
     */
    
    public function index() 
    {
        if ($this->session->userdata('logged_in'))
        {
            $session_data = $this->session->userdata('logged_in');
            
            $data = array(
                'id' => '',
                'customer_name' => '',
                'customer_description' => '',
                'street_address' => '',
                'post_code' => '',
                'city' => '',
                'www' => ''
            );
            $data['customers'] = $this->customer_model->read_all();
            $data['main_content'] = 'customer/customers_view';
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
     * Add a customer to the database.
     * 
     * Creates an empty customer and shows it via customer/customer_view.
     */
    public function add()
    {
        if ($this->session->userdata('logged_in'))
        {
            $session_data = $this->session->userdata('logged_in');
            
            if ($this->session->userdata('account_type') == 1)
            {
                $data = array(
                      'id'                 => '',
                      'customer_name'      => '',
                      'customer_description'  => '',
                      'street_address'   => '',
                      'post_code'   => '',
                      'city'   => '',
                      'www'   => ''
                    );
                $data['main_content'] = 'customer/customer_view';
                $data['pagetitle'] = $this->lang->line('title_add_customer');
                $data['add'] = TRUE; // show reset button
                $data['login_user_id'] = $session_data['user_id'];
                $data['login_id'] = $session_data['id'];
                $this->load->view('template', $data);
            }
            else
            {
                $error_message = $this->lang->line('not_allowed');
                $this->session->set_flashdata('$error_message', $error_message);
                redirect('customer');
            }
        }
        else
        {
            redirect('login','refresh');
        }
    }
    
    /**
     * Edit a customer.
     * 
     * Reads a customer from the database using the primary key. 
     * If no customer is found redirects to index with error message in flash data.
     * Uses customer/customer_view
     * 
     * @param int $id Primary key of the customer. 
     */
    public function edit($id)
    {
        if ($this->session->userdata('logged_in'))
        {
            $session_data = $this->session->userdata('logged_in');
            
            if ($this->session->userdata('account_type') == 1)
            {
                $customer = $this->customer_model->read($id);
                if (isset($customer[0])) 
                {
                    $data = array(
                        'id' => $customer[0]->id,
                        'customer_name' => $customer[0]->customer_name,
                        'customer_description' => $customer[0]->customer_description,
                        'street_address' => $customer[0]->street_address,
                        'post_code' => $customer[0]->post_code,
                        'city' => $customer[0]->city,
                        'www' => $customer[0]->www
                    );
                    $data['main_content'] = 'customer/customer_view';
                    $data['pagetitle'] = $this->lang->line('title_edit_customer');
                    $data['add'] = FALSE; // not show reset button
                    $data['login_user_id'] = $session_data['user_id'];
                    $data['login_id'] = $session_data['id'];
                    $this->load->view('template', $data);
                } 
                else 
                {
                    // error message if not found and redirected to index
                    // uses flash data for error_message
                    $error_message = $this->lang->line('missing_customer');
                    $this->session->set_flashdata('$error_message', $error_message);
                    redirect('customer');
                }
            }
            else
            {
                $error_message = $this->lang->line('not_allowed');
                $this->session->set_flashdata('$error_message', $error_message);
                redirect('customer');
            }
        }
        else
        {
            redirect('login','refresh');
        }
    }
    
    /**
     * Insert or update customer into the database.
     * 
     * Inserts or updates the customer into the customer table. 
     * Validates the input data; customer name must exist.
     */
    public function save()
    {
        if ($this->session->userdata('logged_in'))
        {
            $session_data = $this->session->userdata('logged_in');
            // data from a page
            $data = array(
                  'id'                 => $this->input->post('txt_id'),
                  'customer_name'      => $this->input->post('txt_customer_name'),
                  'customer_description'  => $this->input->post('txt_customer_description'),
                  'street_address'   => $this->input->post('txt_street_address'),
                  'post_code'   => $this->input->post('txt_post_code'),
                  'city'   => $this->input->post('txt_city'),
                  'www'   => $this->input->post('txt_www')
                );

            $update = FALSE; // assume it it add new
            // is there an id value
            if (strlen($this->input->post("txt_id")) > 0)
            {
                $update = TRUE; // it is update
            }

            $this->load->library('form_validation');
            $this->form_validation->set_error_delimiters('<span class="error">', '</span>');

            $this->form_validation->set_rules(
                    'txt_customer_name', $this->lang->line('missing_name'), 'trim|required|max_length[255]|xss_clean');
            $this->form_validation->set_rules(
                    'txt_customer_description', 'trim|max_length[1000]|xss_clean');
            $this->form_validation->set_rules(
                    'txt_street_address', 'trim|max_length[255]|xss_clean');
            $this->form_validation->set_rules(
                    'txt_post_code', $this->lang->line('invalid_postcode'), 'max_length[255]');
            $this->form_validation->set_rules(
                    'txt_city', $this->lang->line('invalid_city'), 'trim|max_length[255]|xss_clean');
            $this->form_validation->set_rules(
                    'txt_www', 'trim|max_length[255]|xss_clean');

            if ($this->form_validation->run() == FALSE) 
            {
                $data['main_content'] = 'customer/customer_view';           

                if ($update == TRUE)
                {
                    $data['pagetitle'] = $this->lang->line('title_edit_customer');
                    $data['add'] = FALSE; // not show reset button                   
                }
                else
                {
                    $data['pagetitle'] = $this->lang->line('title_add_customer');
                    $data['add'] = TRUE; // show reset button                 
                }

                $data['login_user_id'] = $session_data['user_id'];
                $this->load->view('template', $data);
            }
            else
            {
                if ($update == TRUE)  // update the database
                {
                    $data['id'] = intval($this->input->post('txt_id'));
                    $this->customer_model->update($data);     
                    redirect('customer');
                }
                else  // insert new
                {
                    $this->customer_model->create($data);
                    redirect('customer');
                }
            }
        }
        else
        {
            redirect('login','refresh');
        }
        
    }

    /**
     * Delete a customer.
     * 
     * Deletes a customer using the primary key.
     * 
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
                $this->customer_model->delete(intval($id));
                redirect('customer');
            }
            else
            {
                $error_message = $this->lang->line('not_allowed');
                $this->session->set_flashdata('$error_message', $error_message);
                redirect('customer');
            }
        }
        else
        {
            redirect('login','refresh');
        }
    }  
    
    /**
     * Find customers.
     * 
     * Finds customers according to the start of the name.
     * Uses customer/customers_view
     * 
     */
    public function find()
    {
        if ($this->session->userdata('logged_in'))
        {
            $session_data = $this->session->userdata('logged_in');
            $data = array(
                'id' => '',
                'customer_name' => '',
                'customer_description' => '',
                'street_address' => '',
                'post_code' => '',
                'city ' => '',
                'www' => ''
            );
            $criteria = $this->input->post('src_search');

            $this->load->library('form_validation');
            $this->form_validation->set_error_delimiters('<span class="error">', 
                    '</span>');

            $this->form_validation->set_rules('src_search', 
                    $this->lang->line('missing_name'), 'trim|required|max_length[255]|xss_clean');

            $data['main_content'] = 'customer/customers_view';
            $data['pagetitle'] = $this->lang->line('title_customers');
            $data['error_message'] = "";
            $data['customer_name'] = $criteria;
            $data['login_user_id'] = $session_data['user_id'];
            $data['login_id'] = $session_data['id'];

            if ($this->form_validation->run() != FALSE)
            {
                $data['customers'] = $this->customer_model->find_customer_by_name(
                        'customer.customer_name', $criteria);            
            }
            $this->load->view('template', $data); 
        }
        else
        {
            redirect('login','refresh');
        }
    }
    
    
    /**
     * Show the page with no customer data.
     * Uses customer/customers_view'
     * 
     */
    public function clear()
    {
        if ($this->session->userdata('logged_in'))
        {
            $session_data = $this->session->userdata('logged_in');
            $data = array(
                'customer_name' => '',
                'customer_description' => '',
                'street_address' => '',
                'post_code' => '',
                'city ' => '',
                'www' => ''
            );

            $data['main_content'] = 'customer/customers_view';
            $data['pagetitle'] = $this->lang->line('title_customers');
            $data['error_message'] = "";
            $data['login_user_id'] = $session_data['user_id'];
            $this->load->view('template', $data);
        }
        else
        {
            redirect('login','refresh');
        }
    }
}

?>
