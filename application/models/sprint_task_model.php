<?php
/**
 * @package opix
 * @copyright Oulu University of Applied Sciences(OUAS)
 * @license MIT
 * @version 0.1
 */

/**
 * Class definition for Sprint_task_model Model extends CI_Model.
 *
 * Class definition for Sprint_task_model Model. Model includes methods
 * to handle Sprint task types listing, inserting, editing and deleting sprint task.
 * Extends CI_Model.
 * 
 * @author Tuukka Kiiskinen, Roni Kokkonen
 * @package opix
 * @subpackage models
 * @category Sprint_Task
 */
class Sprint_Task_Model extends CI_Model
{
    
    /**
     * Constructor of the class
     */
    public function __construct() 
    {       
        parent::__construct();
    }

    /**
     * Insert a sprint task into the sprint task table.
     * 
     * @param <array> $data sprint task data
     * 
     * @return int Returns the primary key of the new sprint task. 
     */
    public function create($data)
    {    
        if (empty($data['task_description']))
        {
            $data['task_description'] = NULL;
        }
        
        if (empty($data['effort_estimate_hours']))
        {
            $data['effort_estimate_hours'] = NULL;
        }
              
        $this->db->insert('sprint_task', $data);
        return $this->db->insert_id();
    }
    
    /**
     * Read sprint task from the sprint task table using primary key.
     * 
     * @param int $id Primary key of the sprint task
     * 
     * @return <array> sprint task data 
     */
    public function read($id)
    {       
        $this->db->where('id', $id);
        $query = $this->db->get('sprint_task');
        return $query->result();
    }
    
    /*
     * Reads person's tasks which are in progress
     * 
     * @param int $id Primary key of the person to read.
     * 
     * @return <result_array> sprint task data 
     */
    public function read_person_tasks_in_progress($id)
    {
        $sql = 'SELECT s.task_name, s.id ' .
                'FROM sprint_task AS s ' .
                'INNER JOIN sprint_task_person AS p ON p.sprint_task_id = s.id ' .
                'WHERE p.person_id = ? ' .
                'AND s.status_id = 2 ';
        
        $query = $this->db->query($sql, array($id));
        return $query->result_array();
    }
    
    /**
     * Read all the sprint tasks of the selected sprint backlog item. 
     * 
     * @param int sprintbacklog_id Optional, primary key of a sprint backlog
     * 
     * @return <array> sprint tasks. 
     */
    public function read_all($sprintbacklog_id = 0)
    {
        $this->db->select(
            'sprint_task.id AS id, sprint_task.task_name AS task_name,' .
            'sprint_task.task_description AS task_description,' . 
            'sprint_task.effort_estimate_hours AS effort_estimate_hours,' .
            'sprint_task.status_id AS status_id,' .
            'sprint_task.sprint_backlog_item_id AS sprint_backlog_item_id,' .
            'sprint_task.task_type_id AS task_type_id,' .
            'status.status_name AS status_name,' . 
            'task_type.task_type_name AS task_type_name'    
        );
        $this->db->from('sprint_task');
        $this->db->join('status', 
                'sprint_task.status_id = status.id', 'left');
        // left join because type_id can be null 
        $this->db->join('task_type', 
                'sprint_task.task_type_id = task_type.id', 'left');
        
        if ($sprintbacklog_id > 0)
        {
            $this->db->where('sprint_task.sprint_backlog_item_id', $sprintbacklog_id);
        }
        
        $this->db->order_by("sprint_task.task_name", "asc");
        $query = $this->db->get();
        return $query->result(); 
    }

    /**
     * Update sprint task in the sprint_task table.
     * 
     * @param <array> $data sprint task data to be updated in the table. 
     */
    public function update($data)
    {        
        if (empty($data['task_description']))
        {
            $data['task_description'] = NULL;
        }
        
        if (empty($data['effort_estimate_hours']))
        {
            $data['effort_estimate_hours'] = NULL;
        }
               
        $this->db->where('id', $data['id']);
        $query = $this->db->update('sprint_task', $data) ;
    }
    
    /**
     * Delete a sprint task from the sprint_task table.
     * 
     * @param int $id Primary key of the sprint task to delete. 
     * 
     * @return boolean false if delete does not succeed because of child rows
     */
    public function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('sprint_task');
        
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
