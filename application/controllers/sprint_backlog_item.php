<?php

/**
 * @package opix
 * @copyright Oulu University of Applied Sciences(OUAS)
 * @license MIT
 * @version 0.1
 */

/**
 * Class definition for Sprint_backlog_item controller extends CI_Controller.
 *
 * Class definition for Sprint_backlog_item controller. Controller includes methods
 * to handle Sprint_backlog_item listing, inserting, editing and deleting Sprint_backlog_items.
 * Extends CI_Controller.
 * 
 * @author Tuukka Kiiskinen, Roni Kokkonen
 * @package opix
 * @subpackage controllers
 * @category Sprint_backlog_item
 */

class Sprint_Backlog_Item extends CI_Controller
{
    /**
     * Constructor of a sprint backlog item model.
     * 
     * Constructor of a sprint backlog item model. Loads sprint_backlog_item_model,
     * product_backlog_item_model, sprint_backlog_model, project_model and language package.
     */
    public function __construct() 
    {
        parent::__construct();
        $this->load->model('sprint_backlog_item_model');
        $this->load->model('product_backlog_item_model');;
        $this->load->model('project_model');
        $this->load->model('sprint_backlog_model');
        $this->lang->load('sprint_backlog_item');
        $this->load->library('session');
    }
    /**
     * Listing of all sprint backlog items.
     * 
     * Reads all sprint backlog items or of a specific sprint backlog
     * from the sprint_backlog_item table in the database. 
     * Uses the sprint backlog items.
     * 
     * @param int $sprintbacklogid Selected sprintbacklogid, default is zero. 
     */
    public function index($project_id = 0, $sprintbacklogid = 0) 
    {
        if ($this->session->userdata('logged_in'))
        {
            $session_data = $this->session->userdata('logged_in');
            $data = array(
                'id' => '',
                'sprint_backlog_id' => '',
                'product_backlog_item_id' => '',
                'item_name' => '',
                'item_description' => '',
                'priority' => '',
                'business_value' => '',
                'estimate_points' => '',
                'effort_estimate_hours' => '',
                'acceptance_criteria' => '',
                'release_target' => ''
            );

            $data['project_id'] = $project_id;
            $data['sprint_backlog_items'] = $this->sprint_backlog_item_model->read_all($sprintbacklogid);
            $data['currentid'] = $sprintbacklogid;
            $data['main_content'] = 'sprint_backlog_item/sprint_backlog_items_view';

            $sprint_backlog = $this->sprint_backlog_model->read($sprintbacklogid);
            $data['product_backlog_id'] = $sprint_backlog[0]->product_backlog_id;

            $project = $this->project_model->read($project_id);

            if ($sprintbacklogid > 0)
            {
                $sprintbacklog = $this->sprint_backlog_model->read($sprintbacklogid);
                $data['pagetitle'] = $project[0]->project_name . ', ' . $sprintbacklog[0]->sprint_name . ': ' .
                        $this->lang->line('title_sprint_backlog_items');
            }

            else
            {
                $data['pagetitle'] = $this->lang->line('title_sprint_backlog_items');
            }

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
     * Add a sprint_backlog_item to the database.
     * 
     * Select sprint backlog items and shows it via sprint_backlog_item_view.
     */
    public function add($project_id, $id)
    {
        if ($this->session->userdata('logged_in'))
        {
            $session_data = $this->session->userdata('logged_in');
            $backlog_items_not_in_sprint_backlog = $this->sprint_backlog_item_model->read_not_backlog_items($id);
            // an empty array
            $backlogs = array();

            // fill the array with backlog items data + not selected checkbox
            if (isset ($backlog_items_not_in_sprint_backlog[0])) // is there any
            {
                foreach ($backlog_items_not_in_sprint_backlog as $one_backlog_item)
                {                  
                    $backlog['product_backlog_item_id'] = $one_backlog_item->product_backlog_item_id;
                    $backlog['item_name'] = $one_backlog_item->item_name;
                    $backlog['selected'] = FALSE;
                    $backlogs[] = $backlog;
                }
            }

            $data['add'] = TRUE;
            $data['project_id'] = $project_id;
            $data['backlogs'] = $backlogs;

            $data['sprintbacklog_id'] = $id;

            if ($id > 0)
            {
                $sprintbacklog = $this->sprint_backlog_model->read($id);
                $data['pagetitle'] = $sprintbacklog[0]->sprint_name . ': ' .
                        $this->lang->line('title_add_sprint_backlog_item');
            }

            else 
            {
                $data['pagetitle'] = $this->lang->line('title_add_sprint_backlog_item');
            }
            
            $data['login_user_id'] = $session_data['user_id'];
            $data['login_id'] = $session_data['id'];
            $data['main_content'] = 'sprint_backlog_item/sprint_backlog_item_view';
            $this->load->view('template', $data);
        }
        else
        {
            redirect('login','refresh');
        }
    }
    
    /**
     * Insert or update sprint backlog items into the database.
     * 
     * Inserts or updates the sprint backlog items into the sprint_backlog_item table. 
     */
     public function save()
    {
        $sprintbacklog_id = $this->input->post('sprint_backlog_id');
        $new_backlogs = $this->input->post('chk_new_backlog');       
        $project_id = $this->input->post('txt_project_id');
        
        if (!empty($new_backlogs)) 
        {
            foreach ($new_backlogs as $backlog)
            {
                $data = array(                  
                    'sprint_backlog_id'  => $sprintbacklog_id,
                    'product_backlog_item_id' => $backlog
                );

                $this->sprint_backlog_item_model->create($data);
            }
        }

        redirect('sprint_backlog_item/index/' . $project_id . '/' . $sprintbacklog_id);

    }
     
    /**
     * Delete a sprint_backlog_item.
     * 
     * Deletes a sprint_backlog_item.
     * 
     */
    public function delete()
    {
        $id = $this->input->post('txt_id');
        $project_id = $this->input->post('txt_project_id');
        $sprintbacklog_id = $this->input->post('txt_sprint_backlog_id');        
        
        if ($this->sprint_backlog_item_model->delete(intval($id)) == FALSE)
        {
            $error_message = $this->lang->line('cannot_delete');
            $this->session->set_flashdata('$error_message', $error_message);
            redirect('sprint_backlog_item/index/' . $project_id . '/' . $sprintbacklog_id ); 
        }
        else
        {
            $this->sprint_backlog_item_model->delete(intval($id));
            redirect('sprint_backlog_item/index/' . $project_id . '/' . $sprintbacklog_id ); 
        }
    } 
     
}

?>