<?php
/**
 * @package opix
 * @copyright Oulu University of Applied Sciences(OUAS)
 * @license MIT
 * @version 0.1
 */

/**
 * Class definition for Task_work_model Model extends CI_Model.
 *
 * Class definition for Task_work_model Model. Model includes methods
 * to handle Task work listing, inserting, editing and deleting Task works.
 * Extends CI_Model.
 * 
 * @author Tuukka Kiiskinen, Roni Kokkonen
 * @package opix
 * @subpackage models
 * @category Task_work
 */
class Task_Work_Model extends CI_Model
{
    /**
     * Constructor of the class
     */
    public function __construct() 
    {
        parent::__construct();
    }

    /**
     * Insert a task work into the task work table.
     * 
     * @param <array> $data task work data
     * @return int Returns the primary key of the new task work. 
     */
    public function create($data)
    {           
        if (empty($data['description']))
        {
            $data['description'] = NULL;
        }
              
        $this->db->insert('task_work', $data);
        return $this->db->insert_id();
    }
    
    /**
     * Read task work from the task work table using primary key.
     * 
     * @param int $id Primary key of the task work
     * @return <array> task work data 
     */
    public function read($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('task_work');
        return $query->result();
    }
    
    /**
     * Read all the task works of the selected person. 
     * 
     * @param int $id Optional, Primary key of a person
     * @return <array> task works. 
     */
    public function read_all($person_id = 0)
    {
        $this->db->select(
            'task_work.id AS id,' .
            'task_work.description AS description,' . 
            'task_work.work_hours AS work_hours,' .
            'task_work.work_date AS work_date,' .
            'task_work.task_id AS task_id,' .
            'task_work.person_id AS person_id,' .
            'task.task_name AS task_name'
        );
        $this->db->from('task_work');
        $this->db->join('task', 
                'task_work.task_id = task.id', 'left');
        
        $this->db->join('person', 
                'task_work.person_id = person.id', 'left');
        
        if ($person_id > 0)
        {
            $this->db->where('task_work.person_id', $person_id);
        }
        
        $this->db->order_by('task.task_name');
        
        $query = $this->db->get();
        return $query->result(); 
    }
    
    /**
     * Update task work in the task_work table.
     * 
     * @param <array> $data task work data to be updated in the table. 
     */
    public function update($data)
    {
        if (empty($data['description']))
        {
            $data['description'] = NULL;
        }
               
        $this->db->where('id', $data['id']);
        $query = $this->db->update('task_work', $data) ;
    }
    
    /**
     * Delete a task work from the task_work table.
     * 
     * @param int $id Primary key of the task work to delete. 
     */
    public function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('task_work');
    }    
    
}

?>
