<?php
/**
 * @package opix
 * @copyright Oulu University of Applied Sciences(OUAS)
 * @license MIT
 * @version 0.1
 */

/**
 * Class definition for Sprint_work_model Model extends CI_Model.
 *
 * Class definition for Sprint_work_model Model. Model includes methods
 * to handle Sprint work listing, inserting, editing and deleting sprint works.
 * Extends CI_Model.
 * 
 * @author Tuukka Kiiskinen, Roni Kokkonen
 * @package opix
 * @subpackage models
 * @category Sprint_work
 */
class Sprint_Work_Model extends CI_Model
{
    /**
     * Constructor of the class
     */
    public function __construct() 
    {
        parent::__construct();
    }

    /**
     * Insert a sprint work into the sprint work table.
     * 
     * @param <array> $data sprint work data
     * @return int Returns the primary key of the new sprint work. 
     */
    public function create($data)
    {    
        if (empty($data['work_date']))
        {
            $data['work_date'] = NULL;
        }
        
        if (empty($data['description']))
        {
            $data['description'] = NULL;
        }
        
        if (empty($data['work_done_hours']))
        {
            $data['work_done_hours'] = NULL;
        }
        
        if (empty($data['work_remaining_hours']))
        {
            $data['work_remaining_hours'] = NULL;
        }
              
        $this->db->insert('sprint_work', $data);
        return $this->db->insert_id();
    }
    
    /**
     * Read sprint work from the sprint work table using primary key.
     * 
     * @param int $id Primary key of the sprint work
     * @return <array> sprint work data 
     */
    public function read($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('sprint_work');
        return $query->result();
    }
    
    /**
     * Read all the sprint works of the selected person. 
     * 
     * @return <array> sprint works. 
     */
    public function read_all($person_id = 0)
    {
        $this->db->select(
            'sprint_work.id AS id, sprint_work.work_date AS work_date,' .
            'sprint_work.description AS description,' . 
            'sprint_work.work_done_hours AS work_done_hours,' .
            'sprint_work.work_remaining_hours AS work_remaining_hours,' .
            'sprint_work.sprint_task_id AS sprint_task_id,' .
            'sprint_work.person_id AS person_id,' .
            'sprint_task.task_name AS task_name'
        );
        $this->db->from('sprint_work');
        $this->db->join('sprint_task', 
                'sprint_work.sprint_task_id = sprint_task.id', 'left');
        // left join because type_id can be null 
        $this->db->join('person', 
                'sprint_work.person_id = person.id', 'left');
        
        if ($person_id > 0)
        {
            $this->db->where('sprint_work.person_id', $person_id);
        }
        
        $this->db->order_by('sprint_task.task_name');
        
        $query = $this->db->get();
        return $query->result(); 
    }
    
    /**
     * Update sprint work in the sprint_work table.
     * 
     * @param <array> $data sprint work data to be updated in the table. 
     */
    public function update($data)
    {
        if (empty($data['work_date']))
        {
            $data['work_date'] = NULL;
        }
        
        if (empty($data['description']))
        {
            $data['description'] = NULL;
        }
        
        if (empty($data['work_done_hours']))
        {
            $data['work_done_hours'] = NULL;
        }
        
        if (empty($data['work_remaining_hours']))
        {
            $data['work_remaining_hours'] = NULL;
        }
               
        $this->db->where('id', $data['id']);
        $query = $this->db->update('sprint_work', $data) ;
    }
    
    /**
     * Delete a sprint work from the sprint_work table.
     * 
     * @param int $id Primary key of the sprint work to delete. 
     */
    public function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('sprint_work');
    }    
    
}

?>
