<?php
/**
 * @package opix
 * @copyright Oulu University of Applied Sciences(OUAS)
 * @license MIT
 * @version 0.1
 */

/**
 * Class definition for Sprint_task_person_model Model extends CI_Model.
 *
 * Class definition for Sprint_task_person_model Model. Model includes methods
 * to handle Sprint task person types listing, inserting, editing and deleting sprint task person.
 * Extends CI_Model.
 * 
 * @author Tuukka Kiiskinen, Roni Kokkonen
 * @package opix
 * @subpackage models
 * @category Sprint_Task_Person
 */
class Sprint_Task_Person_Model extends CI_Model
{
    /**
     * Constructor of the class
     */
    public function __construct() 
    {
        parent::__construct();
    }

    /**
     * Insert a sprint task person into the sprint_task_person table.
     * 
     * @param <array> $data sprint task person data
     * @return int Returns the primary key of the new sprint task person. 
     */
    public function create($data)
    {    
        if (empty($data['estimate_work_effort_hours']))
        {
            $data['estimate_work_effort_hours'] = NULL;
        }
        
        $this->db->insert('sprint_task_person', $data);
        return $this->db->insert_id();
    }
    
    /**
     * Read sprint task person from the sprint_task_person table using primary key.
     * 
     * @param int $id Primary key of the sprint task person
     * @return <array> sprint task person data 
     */
    public function read($id)
    {
        $this->db->select(
            'sprint_task_person.sprint_task_id AS sprint_task_id,' . 
            'sprint_task_person.person_id AS person_id,' . 
            'sprint_task_person.estimate_work_effort_hours AS estimate_work_effort_hours,' . 
            'person.surname AS surname,' .
            'person.firstname AS firstname'
        );
        
        $this->db->from('sprint_task_person');
        $this->db->join('sprint_task',
                'sprint_task_person.sprint_task_id = sprint_task.id');
        $this->db->join('person',
                'sprint_task_person.person_id = person.id');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->result();
    }
    
    /*
     * Reads sprint task persons estimate work effort hours.
     * @param int $id Primary key of the sprint_task to read.
     * @return <array> Person's tasks
     */
    public function read_eweh($id)
    {
        $this->db->select(
            'sprint_task_person.sprint_task_id AS sprint_task_id,' . 
            'sprint_task_person.person_id AS person_id,' .
            'sprint_task_person.estimate_work_effort_hours AS estimate_work_effort_hours,'
        );
        
        $this->db->from('sprint_task_person');
        $this->db->join('sprint_task',
                'sprint_task_person.sprint_task_id = sprint_task.id');
        $this->db->join('person',
                'sprint_task_person.person_id = person.id');
        $this->db->where('sprint_task_person.sprint_task_id', $id);
        $query = $this->db->get();
        return $query->result();
    }
    
    /**
     * Read all the sprint tasks of the person of the selected sprint task. 
     * 
     * @return <array> sprint_task_persons. 
     */
    public function read_all($sprinttaskpersonid)
    {
        $this->db->select(
            'sprint_task_person.sprint_task_id AS sprint_task_id,' . 
            'sprint_task_person.person_id AS person_id,' . 
            'sprint_task_person.estimate_work_effort_hours AS estimate_work_effort_hours,' .
            'sprint_task_person.id AS id,' .
            'person.surname AS surname,' .
            'person.firstname AS firstname,' .
            'person.title AS title,' .
            'person.email AS email,' .
            'person.phone_number AS phone_number,' .
            'person.user_id AS user_id,' .
            'person.language_id AS language_id'
        );
        
        $this->db->from('sprint_task_person');
        $this->db->join('sprint_task',
                'sprint_task_person.sprint_task_id = sprint_task.id');
        $this->db->join('person',
                'sprint_task_person.person_id = person.id');       
        
        if ($sprinttaskpersonid > 0)
        {
            $this->db->where('sprint_task_person.sprint_task_id', $sprinttaskpersonid);
        }
                
        $query = $this->db->get();
        return $query->result(); 
    }
    
    /**
     * Read person's estimate work effort hours from sprint_task_person
     * 
     * @param int $person_id primary key of the person table.
     * @return <array> sprint task person. 
     */
    public function read_by_person($person_id, $sprinttask_id)
    {
        $this->db->select(
            'sprint_task_person.sprint_task_id AS sprint_task_id,' . 
            'sprint_task_person.person_id AS person_id,' . 
            'sprint_task_person.estimate_work_effort_hours AS estimate_work_effort_hours,' .
            'sprint_task_person.id AS id,' .
            'person.surname AS surname,' .
            'person.firstname AS firstname'
        );
        
        $this->db->from('sprint_task_person');
        $this->db->join('sprint_task',
                'sprint_task_person.sprint_task_id = sprint_task.id');
        $this->db->join('person',
                'sprint_task_person.person_id = person.id');
        $this->db->where('person_id', $person_id);
        $this->db->where('sprint_task_id', $sprinttask_id);
        $query = $this->db->get();
        return $query->result();
    }
    
    /*
     * Reads persons sprint tasks.
     * @param int $id Primary key of the person to read.
     */
    public function read_by_personid($person_id)
    {
        $this->db->select(
            'sprint_task_person.sprint_task_id AS sprint_task_id,' . 
            'sprint_task_person.person_id AS person_id,' . 
            'sprint_task_person.estimate_work_effort_hours AS estimate_work_effort_hours,' .
            'sprint_task_person.id AS id,' .
            'person.surname AS surname,' .
            'person.firstname AS firstname'
        );
        
        $this->db->from('sprint_task_person');
        $this->db->join('sprint_task',
                'sprint_task_person.sprint_task_id = sprint_task.id');
        $this->db->join('person',
                'sprint_task_person.person_id = person.id');
        $this->db->where('person_id', $person_id);
        $query = $this->db->get();
        return $query->result();
    }
    
    /**
     * Read person's currently not selected in sprint task.
     * 
     * @param int $id primary key of the selected sprint task.
     * @return <array> sprint task 
     */
    public function read_not_task_persons($id)
    {
        // subquery and a parameter in a query
        $sql = 'SELECT person.id AS person_id, 
                person.surname AS surname,
                person.firstname AS firstname ' .           
                'FROM person WHERE person.id NOT IN ( ' .
                'SELECT person.id AS id FROM person ' .
                'INNER JOIN sprint_task_person ON person.id = sprint_task_person.person_id ' .
                'WHERE sprint_task_person.sprint_task_id = ?)';
        
        $query = $this->db->query($sql, array($id));
        return $query->result();
    }
    
    /**
     * Update sprint task person's estimate work effort hours in the sprint task person table.
     * 
     * @param <array> $data sprint task person data to be updated in the table. 
     */
    public function update($data)
    {  
        if (empty($data['estimate_work_effort_hours']))
        {
            $data['estimate_work_effort_hours'] = NULL;
        }
        
        $this->db->where('person_id', $data['person_id']);
        $this->db->where('sprint_task_id', $data['sprint_task_id']);
        $query = $this->db->update('sprint_task_person', $data) ;
    }
    
    /**
     * Delete a sprint task person from the sprint task person table.
     * 
     * @param int $id Primary key of the sprint task person to delete. 
     */
    public function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('sprint_task_person');
    }    
}

?>