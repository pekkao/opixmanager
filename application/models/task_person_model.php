<?php
/**
 * @package opix
 * @copyright Oulu University of Applied Sciences(OUAS)
 * @license MIT
 * @version 0.1
 */

/**
 * Class definition for Task_person_model Model extends CI_Model.
 *
 * Class definition for Task_person_model Model. Model includes methods
 * to handle task person types listing, inserting, editing and deleting task person.
 * Extends CI_Model.
 * 
 * @author Tuukka Kiiskinen, Roni Kokkonen
 * @package opix
 * @subpackage models
 * @category Task_Person
 */
class Task_Person_Model extends CI_Model
{
    /**
     * Constructor of the class
     */
    public function __construct() 
    {
        parent::__construct();
    }

    /**
     * Insert a task person into the task_person table.
     * 
     * @param <array> $data task person data
     * @return int Returns the primary key of the new task person. 
     */
    public function create($data)
    {    
        if (empty($data['effort_estimate_hours']))
        {
            $data['effort_estimate_hours'] = NULL;
        }
        
        if (empty($data['start_date']))
        {
            $data['start_date'] = NULL;
        }
        
        if (empty($data['end_date']))
        {
            $data['end_date'] = NULL;
        }
        
        $this->db->insert('task_person', $data);
        return $this->db->insert_id();
    }
    
    /**
     * Read task person from the task_person table using primary key.
     * 
     * @param int $id Primary key of the task person
     * @return <array> task person data 
     */
    public function read($id)
    {
        $this->db->select(
            'task_person.task_id AS task_id,' . 
            'task_person.person_id AS person_id,' . 
            'task_person.effort_estimate_hours AS effort_estimate_hours,' .
            'task_person.start_date AS start_date,' .
            'task_person.end_date AS end_date,' .
            'person.surname AS surname,' .
            'person.firstname AS firstname'
        );
        
        $this->db->from('task_person');
        $this->db->join('task',
                'task_person.task_id = task.id');
        $this->db->join('person',
                'task_person.person_id = person.id');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->result();
    }
    
    /*
     * Reads person's effort estimate hours from a task.
     * @param int $id Primary key of the task to read.
     */
    public function read_eeh($id)
    {
        $this->db->select(
            'task_person.task_id AS task_id,' . 
            'task_person.person_id AS person_id,' .
            'task_person.effort_estimate_hours AS effort_estimate_hours,'
        );
        
        $this->db->from('task_person');
        $this->db->join('task',
                'task_person.task_id = task.id');
        $this->db->join('person',
                'task_person.person_id = person.id');
        $this->db->where('task_person.task_id', $id);
        $query = $this->db->get();
        return $query->result();
    }
    
    /**
     * Read all the task persons of the selected task. 
     * 
     * @return <array> task_persons. 
     */
    public function read_all($taskpersonid)
    {
        $this->db->select(
            'task_person.task_id AS task_id,' . 
            'task_person.person_id AS person_id,' . 
            'task_person.effort_estimate_hours AS effort_estimate_hours,' .
            'task_person.start_date AS start_date,' .
            'task_person.end_date AS end_date,' .
            'task_person.id AS id,' .
            'person.surname AS surname,' .
            'person.firstname AS firstname,' .
            'person.title AS title,' .
            'person.email AS email,' .
            'person.phone_number AS phone_number,' .
            'person.user_id AS user_id,' .
            'person.language_id AS language_id'
        );
        
        $this->db->from('task_person');
        $this->db->join('task',
                'task_person.task_id = task.id');
        $this->db->join('person',
                'task_person.person_id = person.id');       
        
        if ($taskpersonid > 0)
        {
            $this->db->where('task_person.task_id', $taskpersonid);
        }
                
        $query = $this->db->get();
        return $query->result(); 
    }
    
    /**
     * Read person's effort estimate hours from task_person
     * 
     * @param int $person_id primary key of the person table.
     * @return <array> task person. 
     */
    public function read_by_person($person_id, $task_id)
    {
        $this->db->select(
            'task_person.task_id AS task_id,' . 
            'task_person.person_id AS person_id,' . 
            'task_person.effort_estimate_hours AS effort_estimate_hours,' .
            'task_person.start_date AS start_date,' .
            'task_person.end_date AS end_date,' .
            'task_person.id AS id,' .
            'person.surname AS surname,' .
            'person.firstname AS firstname'
        );
        
        $this->db->from('task_person');
        $this->db->join('task',
                'task_person.task_id = task.id');
        $this->db->join('person',
                'task_person.person_id = person.id');
        $this->db->where('person_id', $person_id);
        $this->db->where('task_id', $task_id);
        $query = $this->db->get();
        return $query->result();
    }
    
    /*
     * Reads persons tasks.
     * @param int $id Primary key of the person to read.
     */
    public function read_by_personid($person_id)
    {
        $this->db->select(
            'task_person.task_id AS task_id,' . 
            'task_person.person_id AS person_id,' . 
            'task_person.effort_estimate_hours AS effort_estimate_hours,' .
            'task_person.id AS id,' .
            'person.surname AS surname,' .
            'person.firstname AS firstname'
        );
        
        $this->db->from('task_person');
        $this->db->join('task',
                'task_person.task_id = task.id');
        $this->db->join('person',
                'task_person.person_id = person.id');
        $this->db->where('task_person.person_id', $person_id);
        $query = $this->db->get();
        return $query->result();
    }
    
    /**
     * Read person's currently not selected in task.
     * 
     * @param int $id primary key of the selected task.
     * @return <array> task 
     */
    public function read_not_task_persons($id)
    {
        // subquery and a parameter in a query
        $sql = 'SELECT person.id AS person_id, 
                person.surname AS surname,
                person.firstname AS firstname ' .           
                'FROM person WHERE person.id NOT IN ( ' .
                'SELECT person.id AS id FROM person ' .
                'INNER JOIN task_person ON person.id = task_person.person_id ' .
                'WHERE task_person.task_id = ?)';
        
        $query = $this->db->query($sql, array($id));
        return $query->result();
    }
    
    /**
     * Update task person's effort estimate hours in the task person table.
     * 
     * @param <array> $data task person data to be updated in the table. 
     */
    public function update($data)
    {  
        if (empty($data['effort_estimate_hours']))
        {
            $data['effort_estimate_hours'] = NULL;
        }
        
        if (empty($data['start_date']))
        {
            $data['start_date'] = NULL;
        }
        
        if (empty($data['end_date']))
        {
            $data['end_date'] = NULL;
        }
        
        $this->db->where('person_id', $data['person_id']);
        $this->db->where('task_id', $data['task_id']);
        $query = $this->db->update('task_person', $data) ;
    }
    
    /**
     * Delete a task person from the task person table.
     * 
     * @param int $id Primary key of the task person to delete. 
     */
    public function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('task_person');
    }    
}

?>