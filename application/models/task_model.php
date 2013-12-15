<?php
/**
 * @package opix
 * @copyright Oulu University of Applied Sciences(OUAS)
 * @license MIT
 * @version 0.1
 */

/**
 * Class definition for Task_model Model extends CI_Model.
 *
 * Class definition for Task_model Model. Model includes methods
 * to handle task listing, inserting, editing and deleting tasks.
 * Extends CI_Model.
 * 
 * @author Hannu Raappana, Tuukka Kiiskinen, Roni Kokkonen
 * @package opix
 * @subpackage models
 * @category Task
 */
class Task_Model extends CI_Model
{    
    /**
     * Constructor of the class
     */
    public function __construct()
    {       
        parent::__construct();
    }
    
    /**
     * Insert a task into the task table.
     * 
     * @param <array> $data task data
     * @return int Returns the primary key of the new task. 
     */
    public function create($data)
    {               
        if ($data['project_period_id'] == 0)
        {         
            $data['project_period_id'] = NULL;       
        }
        
        if (empty($data['task_type_id']))
        {            
            $data['task_type_id'] = NULL;        
        }
        
        if (empty($data['status_id']))
        {           
            $data['status_id'] = NULL;
        }
        
        if (empty($data['task_name']))
        {           
            $data['task_name'] = NULL;
        }
        
        if (empty($data['task_description']))
        {           
            $data['task_description'] = NULL;
        }
        
        if (empty($data['task_start_date']))
        {           
            $data['task_start_date'] = NULL;
        }
        
        if (empty($data['task_end_date']))
        {           
            $data['task_end_date'] = NULL;
        }
        
        if (empty($data['effort_estimate_hours']))
        {           
            $data['effort_estimate_hours'] = NULL;
        }
        
        $this->db->insert('task', $data);
        return $this->db->insert_id();
    }
    
    /**
     * Read all the tasks of the selected project period. 
     * 
     * @return <array> tasks. 
     */ 
    public function read_all($project_period_id = 0) 
    {      
        $this->db->select(
            'task.id AS id, task.task_name AS task_name,' .
            'task.task_description AS task_description,' .
            'task.task_start_date AS task_start_date,' .
            'task.task_end_date AS task_end_date,' .
            'task.effort_estimate_hours AS effort_estimate_hours,' .
            'task.project_period_id AS project_period_id,' .
            'task.task_type_id AS task_type_id,' .
            'task.status_id AS status_id,' .
            'status.status_name AS status_name,' . 
            'task_type.task_type_name AS task_type_name'
        );

        $this->db->from('task');

        $this->db->join('status', 
                'task.status_id = status.id', 'left');
        // left join because type_id can be null 
        $this->db->join('task_type', 
                'task.task_type_id = task_type.id', 'left');

        $this->db->where('task.project_period_id', $project_period_id);
        $query = $this->db->get();
        return $query->result();
    }
    
    /**
     * Read task from the task table using primary key.
     * 
     * @param int $id Primary key of the task
     * @return <array> task data 
     */
    public function read($id = 0) 
    {     
        $this->db->select(
            'task.id AS id, task.task_name AS task_name,' .
            'task.task_description AS task_description,' .
            'task.task_start_date AS task_start_date,' .
            'task.task_end_date AS task_end_date,' .
            'task.effort_estimate_hours AS effort_estimate_hours,' .
            'task.project_period_id AS project_period_id,' .
            'task.task_type_id AS task_type_id,' .
            'task.status_id AS status_id'     
        );
        
        $this->db->from('task');
        $this->db->where('task.id', $id);
       
        $query = $this->db->get();
        return $query->result();
    }
    
    /*
     * Reads task.
     * @param int $id Primary key of the task to read.
     */
    public function read_task($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('task');
        return $query->result();
    }
    
    /*
     * Reads person's tasks which are in progress.
     * @param int $id Primary key of the person to read.
     */
    public function read_person_tasks_in_progress($id)
    {
        // subquery and a parameter in a query
        $sql = 'SELECT s.task_name, s.id ' .
                'FROM task AS s ' .
                'INNER JOIN task_person AS p ON p.task_id = s.id ' .
                'WHERE p.person_id = ? ' .
                'AND s.status_id = 2 ';
        
        $query = $this->db->query($sql, array($id));
        return $query->result_array();
    }
    
    /**
     * Update task in the task table.
     * 
     * @param <array> $data task data to be updated in the table. 
     */
    public function update($data) 
    {               
        if ($data['project_period_id'] == 0) 
        {  
            $data['project_period_id'] = NULL;        
        }
        
        if (empty($data['task_type_id'])) 
        {  
            $data['task_type_id'] = NULL;
        }
        
        if (empty($data['status_id']))
        {  
            $data['status_id'] = NULL;
        }
        
        if (empty($data['task_name'])) 
        {          
            $data['task_name'] = NULL;
        }
        
        if (empty($data['task_description'])) 
        {           
            $data['task_description'] = NULL;
        }
        
        if (empty($data['task_start_date'])) 
        {       
            $data['task_start_date'] = NULL;
        }
        
        if (empty($data['task_end_date'])) 
        {
            $data['task_end_date'] = NULL;
        }
        
        if (empty($data['effort_estimate_hours'])) 
        {
            $data['effort_estimate_hours'] = NULL;  
        }
        
        $this->db->where('id', $data['id']);
        $query=$this->db->update('task', $data);
    }    
    
    /**
     * Delete a task from the task table.
     * 
     * @param int $id Primary key of the task to delete. 
     */
    public function delete($id) 
    {
        $this->db->where('id', $id);
        $this->db->delete('task');
        
        if ($this->db->_error_number() == 1451)
        {
            return FALSE;
        }
        else
        {            
            return TRUE;
        }
    }
}

?>