<?php

/**
 * @package opix
 * @copyright Oulu University of Applied Sciences(OUAS)
 * @license MIT
 * @version 0.1
 */

/**
 * Class definition for Product_backlog_item controller extends CI_Controller.
 *
 * Class definition for Product_backlog_item controller. Controller includes methods
 * to handle Product_backlog_item listing, inserting, editing and deleting Product_backlog_items.
 * Extends CI_Controller.
 * 
 * @author Wang Yuqing, Roni Kokkonen, Tuukka Kiiskinen
 * @package opix
 * @subpackage controllers
 * @category Product_backlog_item
 */

class Product_Backlog_Item extends CI_Controller 
{
     /**
     * Constructor of a Product_backlog_item model.
     * 
     * Constructor of a Product_backlog_item model. Loads product_backlog_model,
     * product_backlog_item_model, project_model and language package.
     */
     public function __construct() 
     {
         parent::__construct();
         $this->load->model('product_backlog_model');
         $this->load->model('product_backlog_item_model');
         $this->load->model('project_model');
         $this->load->model('status_model');
         
         $this->lang->load('product_backlog_item');

         $this->load->library('session');
         $this->load->library('form_validation');
     }
     
     /**
     * Listing of all product backlog items.
     * 
     * Reads all product backlog items from the product_backlog_item table in the database. 
     * Uses the product_backlog_item/product_backlog_item_view.
     * 
     * @param type $project_id Primary key of a project
     * @param type $product_backlog_id Primary key of a product backlog
     * 
     */
     public function index($project_id = 0, $product_backlog_id = 0)
     {  
        if ($this->session->userdata('logged_in'))
        {
            $session_data = $this->session->userdata('logged_in');
            
            $data['product_backlog_items'] = 
                $this->product_backlog_item_model->read_all($product_backlog_id);

            $data['product_backlog_id'] = $product_backlog_id;
            $data['project_id'] = $project_id;

            // form the pagetitle
            $data['pagetitle'] = "";
            if ($project_id > 0)
            {
                $project = $this->project_model->read($project_id);
                $data['pagetitle'] .= $project[0]->project_name . ", ";
            }

            if ($product_backlog_id > 0)
            {
                $product_backlog = 
                    $this->product_backlog_model->read($product_backlog_id);
                $data['pagetitle'] .= $product_backlog[0]->backlog_name  . 
                        ': ';
                
                // admin and product owner can add backlog items
                if ($product_backlog[0]->product_owner == $session_data['id'] || 
                       $this->session->userdata('account_type') == 1 ) 
                {
                    $data['can_add'] = TRUE;
                }
                else
                {
                    $data['can_add'] = FALSE;
                }
            }

            $data['pagetitle'] .= $this->lang->line('title_product_backlog_item');
            $data['login_user_id'] = $session_data['user_id'];
            $data['login_id'] = $session_data['id'];
            $data['main_content'] = 'product_backlog_item/product_backlog_items_view';
            $data['error_message'] = $this->session->flashdata('$error_message');
            $data['heading']=$this->lang->line('title_db_error');
            $this->load->view('template', $data);
        }
        else
        {
            redirect('login','refresh');
        }
     }
     
     /**
     * Add a product_backlog_item to the database.
     * 
     * Creates an empty product_backlog_item and shows it via product_backlog_item/product_backlog_item_view.
     * 
     * @param type $project_id Primary key of a project
     * @param type $product_backlog_id Primary key of a product backlog
     */
     public function add($project_id, $product_backlog_id = 0)
     {
        if ($this->session->userdata('logged_in'))
        {
            $session_data = $this->session->userdata('logged_in');
            $data['login_user_id'] = $session_data['user_id'];
            $data['login_id'] = $session_data['id'];
            
            $product_backlog = $this->product_backlog_model->read($product_backlog_id);
            
            if ($this->session->userdata('account_type') == 1 || $data['login_id'] == $product_backlog[0]->product_owner)
            {
            
                $data = array(
                    'id' => '',
                    'item_name' => '',
                    'item_description' => '',
                    'priority' => '',
                    'business_value' => '',
                    'estimate_points' => '',
                    'effort_estimate_hours' =>'',
                    'acceptance_criteria' =>'',
                    'release_target' =>'',
                    'product_backlog_id' => $product_backlog_id,
                    'item_type_id'=> 0,
                    'status_id' => 0,
                    'is_part_of_id' => '',
                    'start_date' => ''
                );

                $data['project_id'] = $project_id;
                
                // item type method is in a wrong model !!!
                $item_types_from_db = $this->product_backlog_item_model->read_item_types();         
                $this->load->helper("form_input_helper");
                $item_types = convert_db_result_to_dropdown(
                $item_types_from_db, 'id', 'item_type_name');        
                $data['item_types'] = $item_types;

                $this->load->helper("form_input_helper");
                $status_from_db = $this->status_model->read_names();         
                // new text in the beginning of array
                $a = array('id' => "0", 'status_name' => $this->lang->line('select_status') );
                array_unshift($status_from_db, $a);
                $status = convert_db_result_to_dropdown(
                    $status_from_db, 'id', 'status_name');        
                $data['status'] = $status;

                $data['product_backlog_id'] = $product_backlog_id;
                $data['project_id'] = $project_id;
                $data['add'] = TRUE;

                $product_backlog = $this->product_backlog_model->read($product_backlog_id);
                $data['pagetitle'] = $product_backlog[0]->backlog_name  . ': ' .
                    $this->lang->line('title_add_product_backlog_item');

                $data['login_user_id'] = $session_data['user_id'];
                $data['login_id'] = $session_data['id'];
                $data['main_content'] = 'product_backlog_item/product_backlog_item_view';
                $this->load->view('template', $data);

            }
            else
            {
                $error_message = $this->lang->line('not_allowed');
                $this->session->set_flashdata('$error_message', $error_message);
                redirect('product_backlog_item/index/' . $project_id . '/' .
                        $product_backlog_id);
            }
        }
        else
        {
            redirect('login','refresh');
        }
    }
    
    /**
     * Edit a product_backlog_item.
     * 
     * Reads a product_backlog_item from the database using the primary key. 
     * If no product_backlog_item is found redirects to index with error message in flash data.
     * 
     * @param int $project_id Primary key of the project_id. 
     * @param int $id Primary key of a product backlog
     */
    public function edit($project_id, $id)
    {
        if ($this->session->userdata('logged_in'))
        {
            $session_data = $this->session->userdata('logged_in');
            $data['login_user_id'] = $session_data['user_id'];
            $data['login_id'] = $session_data['id'];
            
            $product_backlog_item = $this->product_backlog_item_model->read($id);

            if (isset($product_backlog_item[0])) 
            {
                $product_backlog = $this->product_backlog_model->read(
                        $product_backlog_item[0]->product_backlog_id);
                if ($this->session->userdata('account_type') == 1 || $data['login_id'] == $product_backlog[0]->product_owner)
                {
                    $data['add'] = TRUE;

                    $data = array(
                        'id' => $product_backlog_item[0]->id,
                        'item_name' => $product_backlog_item[0]->item_name,
                        'item_description' => $product_backlog_item[0]->item_description,
                        'priority' => $product_backlog_item[0]->priority,
                        'business_value' => $product_backlog_item[0]->business_value,
                        'estimate_points' => $product_backlog_item[0]->estimate_points,
                        'effort_estimate_hours' => $product_backlog_item[0]->effort_estimate_hours,
                        'acceptance_criteria' => $product_backlog_item[0]->acceptance_criteria,
                        'release_target' => $product_backlog_item[0]->release_target,
                        'product_backlog_id' => $product_backlog_item[0]->product_backlog_id,
                        'item_type_id' => $product_backlog_item[0]->item_type_id,
                        'status_id' => $product_backlog_item[0]->status_id,
                        'is_part_of_id' => $product_backlog_item[0]->is_part_of_id,
                        'start_date' => $product_backlog_item[0]->start_date
                    );
                    $data['error_message'] = $this->session->flashdata('$error_message');
                    $data['project_id'] = $project_id;

                    $item_types_from_db = $this->product_backlog_item_model->read_item_types();         
                    $this->load->helper("form_input_helper");
                    $item_types = convert_db_result_to_dropdown(
                    $item_types_from_db, 'id', 'item_type_name');        
                    $data['item_types'] = $item_types;

                    $status_from_db = $this->status_model->read_names();
                    $this->load->helper("form_input_helper");
                    // new text in the beginning of array
                    $a = array('id' => "0", 'status_name' => $this->lang->line('select_status') );
                    array_unshift($status_from_db, $a);

                    $status = convert_db_result_to_dropdown(
                    $status_from_db, 'id', 'status_name');        
                    $data['status'] = $status;

                    $data['main_content'] = 'product_backlog_item/product_backlog_item_view';
                    $data['project_id'] = $data['project_id'];
                    $data['product_backlog_id'] = $data['product_backlog_id'];
                    $data['login_user_id'] = $session_data['user_id'];
                    $data['login_id'] = $session_data['id'];

                    $product_backlog = $this->product_backlog_model->read(
                            $product_backlog_item[0]->product_backlog_id);
                    $data['pagetitle'] = $product_backlog[0]->backlog_name  . ': ' .
                        $this->lang->line('title_edit_product_backlog_item');

                    $data['add'] = FALSE; 

                    $this->load->view('template', $data);
                } 
                else
                {
                    if (isset($product_backlog_item[0]))
                    {
                        $product_backlog_id = $product_backlog_item[0]->product_backlog_id;
                    }
                    $error_message = $this->lang->line('not_allowed');
                    $this->session->set_flashdata('$error_message', $error_message);
                    redirect('product_backlog_item/index/' . $project_id . '/' .
                        $product_backlog_id);
                }
            }

            else 
            {
                $data['add'] = FALSE;
                $error_message = $this->lang->line('missing_product_backlog_item');
                $this->session->set_flashdata('$error_message', $error_message);
                redirect('product_backlog_item/index/' . $data['project_id'] . '/' .
                        $data['product_backlog_id']);
            }
        }
        else
        {
            redirect('login','refresh');
        }
    }
    
     /**
     * Insert or update product_backlog_item into the database.
     * 
     * Inserts or updates the product_backlog_item into the product_backlog table. 
     * Validates the input data; product_backlog_item name must exist.
     */   
    public function save()
    {
        if ($this->session->userdata('logged_in'))
        {
            $session_data = $this->session->userdata('logged_in');
            $data = array(
                'id' => $this->input->post('txt_id'),
                'item_name' => $this->input->post('txt_item_name'),
                'item_description' => $this->input->post('txt_item_description'),
                'priority' => $this->input->post('txt_priority'),
                'business_value' => $this->input->post('txt_business_value'),
                'estimate_points' => $this->input->post('txt_estimate_points'),
                'effort_estimate_hours' => $this->input->post('txt_effort_estimate_hours'),
                'acceptance_criteria' => $this->input->post('txt_acceptance_criteria'),
                'release_target' => $this->input->post('txt_release_target'),
                'product_backlog_id' => $this->input->post('txt_product_backlog_id'),
                'item_type_id' => $this->input->post('ddl_item_type'),
                'status_id' => $this->input->post('ddl_status'),
                'start_date' => $this->input->post('dtm_start_date')
            );

            $project_id = $this->input->post('txt_project_id');
            $update = FALSE;     

            if (strlen($this->input->post("txt_id")) > 0)
            {
                $update = TRUE; 
            }

            $this->load->library('form_validation');
            $this->form_validation->set_error_delimiters('<span class="error">', '</span>');

            $this->form_validation->set_rules(
                    'txt_item_name', $this->lang->line('missing_item_name'), 'trim|required|max_length[255]|xss_clean');
            $this->form_validation->set_rules(
                    'txt_item_description', 'trim|max_length[1000]|xss_clean');
            $this->form_validation->set_rules(
                    'txt_priority', $this->lang->line('invalid_priority'), 'trim|max_length[10]|xss_clean|integer');
            $this->form_validation->set_rules(
                    'txt_business_value', $this->lang->line('invalid_business_value'), 'trim|max_length[10]|xss_clean|integer');
            $this->form_validation->set_rules(
                    'txt_estimate_points', $this->lang->line('invalid_estimate_points'), 'trim|max_length[10]|xss_clean|integer');
            $this->form_validation->set_rules(
                    'txt_effort_estimate_hours', $this->lang->line('invalid_effort_estimate_hours'), 'trim|max_length[10]|xss_clean|integer');
            $this->form_validation->set_rules(
                    'txt_acceptance_criteria', 'trim|max_length[1000]|xss_clean');
            $this->form_validation->set_rules(
                    'txt_release_target', 'trim|max_length[255]|xss_clean');
            $this->form_validation->set_rules(
                    'dtm_start_date', $this->lang->line('label_start_date'), 'xss_clean|check_date');

            // callback function to validate that status is selected
            // error message for that callback function
            $this->form_validation->set_message('check_status', $this->lang->line('missing_status'));
            $this->form_validation->set_rules(
                            'ddl_status', null, 'callback_check_status');

            if ($this->form_validation->run() == FALSE) 
            {          
                $data['login_user_id'] = $session_data['user_id'];
                $data['login_id'] = $session_data['id'];

                // item type and status methods are in a wrong model !!!
                $item_types_from_db = $this->product_backlog_item_model->read_item_types();         
                $this->load->helper("form_input_helper");
                $item_types = convert_db_result_to_dropdown(
                $item_types_from_db, 'id', 'item_type_name');        
                $data['item_types'] = $item_types;

                $status_from_db = $this->status_model->read_names();   
                $this->load->helper("form_input_helper");
                // new text in the beginning of array
                $a = array('id' => "0", 'status_name' => $this->lang->line('select_status') );
                array_unshift($status_from_db, $a);
                $status = convert_db_result_to_dropdown(
                $status_from_db, 'id', 'status_name');        
                $data['status'] = $status;

                $data['project_id']=$project_id;

                $product_backlog = $this->product_backlog_model->read(
                        $data['product_backlog_id']);

                if ($update == TRUE)
                {
                    $data['add'] = FALSE; 
                    $data['pagetitle'] = $product_backlog[0]->backlog_name  . ': ' .
                        $this->lang->line('title_edit_product_backlog_item');                
                }

                else
                {
                    $data['add'] = TRUE; 
                    $data['pagetitle'] = $product_backlog[0]->backlog_name  . ': ' .
                        $this->lang->line('title_add_product_backlog_item');
                }
                $data['main_content'] = 
                    'product_backlog_item/product_backlog_item_view';
                $this->load->view('template', $data);
            }

            else
            {
                if ($update == TRUE)  
                {
                    //$data['id']=intval($this->input->post('txtId'));
                    $this->product_backlog_item_model->update($data);     
                }

                else  
                {
                    $this->product_backlog_item_model->create($data);
                }
                redirect('product_backlog_item/index/' . 
                        $project_id . '/' . $data['product_backlog_id']);
            }

            }
        else 
        {
            redirect('login', 'refresh');
        }
    }
    
    /**
    * Checks that status is selected
    * @param int $status what status is selected
    * @return boolean 
    */
    function check_status($status) {
           if ($status > 0) {
                   return true;
           }
           else {
                   return false;
           }
    }
    
    /**
     * Delete a product backlog item.
     * 
     * Deletes a product backlog item using the primary key.
     * 
     */
    public function delete()
    {
        $id = $this->input->post('txt_id');
        $project_id  = $this->input->post('txt_project_id');
        $product_backlog_id = $this->input->post('txt_product_backlog_id');
        
        if ($this->product_backlog_item_model->delete(intval($id)) == FALSE)
        {
            $error_message = $this->lang->line('cannot_delete');
            $this->session->set_flashdata('$error_message', $error_message);
            redirect('product_backlog_item/index/' . 
              $project_id . '/' . $product_backlog_id); 
        }
        else
        {
            $this->product_backlog_item_model->delete(intval($id));
            redirect('product_backlog_item/index/' . 
              $project_id . '/' . $product_backlog_id);
        } 
    }
}

?>
