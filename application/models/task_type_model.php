<?php
/**
 * @package opix
 * @copyright Oulu University of Applied Sciences(OUAS)
 * @license MIT
 * @version 0.1
 */

/**
 * Class definition for Task_Type_Model Model extends CI_Model.
 *
 * Class definition for Task_Type_Model Model. Model includes methods
 * to handle Task types listing, inserting, editing and deleting Task type.
 * Extends CI_Model.
 * 
 * @author Roni Kokkonen
 * @package opix
 * @subpackage models
 * @category Task_types
 */

class Task_Type_Model extends CI_Model {
    
    /**
     * Constructor of the class
     */
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * Read all the task_types from the task_type table
     * 
     * @return <array> task_types. 
     */
    public function read_all()
    {   
        $this->db->select(
             'id, task_type_name, task_type_description'
        );
        
        $this->db->from('task_type');
        $this->db->order_by('task_type_name');
        $query = $this->db->get();
        return $query->result();
    }
    
     /**
     * Read task_type from the task_type table using primary key.
     * 
     * @param int $id Primary key of the task_type
     * @return <array> Task_type data 
     */
    public function read($id) 
    {     
        $this->db->where('id', $id);
        $query = $this->db->get('task_type');
        return $query->result();
    }
    
    /**
     * Update task_type in the task_type table.
     * 
     * @param <array> $data task_type data to be updated in the table. 
     */
    public function update($data) 
    {    
        if (empty($data['task_type_description'])) 
        {
            $data['task_type_description'] = NULL;
        }
        
        $this->db->where('id', $data['id']);
        $query = $this->db->update('task_type', $data);
    }
    
    /**
     * Insert task_type into the task_type table.
     * 
     * @param <array> $data task_type data
     * @return int Returns the primary key of the new task_type. 
     */
    public function create($data) 
    {
        if (empty($data['task_type_description'])) 
        {
            $data['task_type_description'] = NULL;
        }
        
        $this->db->insert('task_type', $data);
        return $this->db->insert_id();
    }
    
    /**
     * Delete a task_type from the task_type table.
     * 
     * @param int $id Primary key of the Task_type to delete. 
     */
    public function delete($id) 
    {
        $this->db->where('id', $id);
        $this->db->delete('task_type');
        
        if ($this->db->_error_number() == 1451)
        {
            return FALSE;
        }
        else
        {            
            return TRUE;
        }
    }
    
    /**
     * Read all the task_type names and ids from the task_type table
     * @return <result_array> Task_types
     */
    public function read_names() {
        $this->db->select('id, task_type_name');
        $this->db->from('task_type');
        $this->db->order_by('task_type_name');
        $query = $this->db->get();
        return $query->result_array();
    }
    
}
