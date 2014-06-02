<?php

/**
 * @package opix
 * @copyright Oulu University of Applied Sciences(OUAS)
 * @license MIT
 * @version 0.1
 */

/**
 * Class definition for project_staff_Model Model extends CI_Model.
 *
 * Class definition for project_staff_Model Model. Model includes methods
 * to handle Person roles listing, inserting, editing and deleting project staffs.
 * Extends CI_Model.
 * 
 * @author Wang Yuqing
 * @package opix
 * @subpackage models
 * @category project_staffs
 */
class Project_Staff_Model extends CI_Model
{
     /**
     * Constructor of the class
     */
    public function __construct() 
    {
        parent::__construct();
    }
    
    /**
     * Insert project_staff into the project_staff table.
     * 
     * @param <array> $data project_staff data
     * @return int Returns the primary key of the new project_staff . 
     */
    public function create($data)
    {
        $this->db->insert('project_staff', $data);
        return $this->db->insert_id();
    } 
    
    /**
     * Reads all project staffs from all projects
     * 
     * @return <array> project_staffs
     */
    public function read_all()
    {
        $this->db->select( 
            'project_staff.project_id AS project_id,' .
            'project_staff.person_id AS person_id,' .
            'project.project_name AS project_name,' .
            'person.surname AS surname, person.firstname AS firstname,' .
            'person_role.role_name AS role_name,' .
            'project_staff.id AS id,' .
            'project_staff.start_date AS start_date,' .
            'project_staff.end_date AS end_date'
        );

        $this->db->from('project_staff');
        $this->db->join('person_role', 
                'project_staff.person_role_id  = person_role.id', 'left');
        $this->db->join('project', 
                'project_staff.project_id = project.id');
        $this->db->join('person', 
                'project_staff.person_id = person.id');
        
        $this->db->order_by("person.surname", "asc");
        $this->db->order_by("person.firstname", "asc");
        $query = $this->db->get();
        return $query->result();
    }
    
    /**
     * Read project staff of a project.
     * 
     * @param int $id Primary key of a project_staff
     * 
     * @return <array> project_staff
     */
    public function read($id)
    {
        $this->db->select(
        'project_staff.project_id AS project_id,' .
        'project_staff.person_role_id AS person_role_id,' .
        'project_staff.person_id AS person_id,' .
        'project.project_name AS project_name,' .
        'person.surname AS surname,person.firstname AS firstname,' .
        'person_role.role_name AS role_name,' .
        'person_role.id AS id,' .
        'project_staff.id AS project_staff_id, ' .
        'project_staff.start_date AS start_date, ' .
        'project_staff.end_date AS end_date'
        );
                
        $this->db->from('project_staff');
        $this->db->join('person_role', 
                'project_staff.person_role_id  = person_role.id', 'left');
        $this->db->join('project', 
                'project_staff.project_id = project.id');
        $this->db->join('person', 
                'project_staff.person_id = person.id');
        
        $this->db->where('project_staff.id', $id);
        $query = $this->db->get();
        return $query->result();
    }
        
    
    /**
     * Read all the project_staffs with foreign key descriptions (project, person, person_role) 
     * from the project_staff table.
     * 
     * @param int projectid Primary key of a project
     * @return <array> Project_staff. 
     */
    
    public function read_project_staffs($projectid)
    {
        $this->db->select( 
            'project_staff.project_id AS project_id,' .
            'project_staff.person_id AS person_id,' .
            'project.project_name AS project_name,' .
            'person.surname AS surname, person.firstname AS firstname,' .
            'person_role.role_name AS role_name,' .
            'project_staff.id AS id,' .
            'project_staff.start_date AS start_date,' .
            'project_staff.end_date AS end_date'
        );
         
        $this->db->from('project_staff');
        $this->db->join('person_role', 
                'project_staff.person_role_id  = person_role.id', 'left');
        $this->db->join('project', 
                'project_staff.project_id = project.id');
        $this->db->join('person', 
                'project_staff.person_id = person.id');
        if ($projectid > 0)
        {
            $this->db->where('project_id', $projectid);
        }
        
        $this->db->order_by("person.surname", "asc");
        $this->db->order_by("person.firstname", "asc");
        $query = $this->db->get();
        return $query->result();
    }
    
    /*
     * Reads project's persons
     * 
     * @param int $id Primary key of the project to read.
     * 
     * @return <result_array> Persons of a project
     */
    public function read_project_persons($projectid)
    {
        $this->db->select(          
            'project_staff.person_id AS person_id,' .
            'CONCAT(person.surname," " , person.firstname) AS name', FALSE);
         
        $this->db->from('project_staff');      
        $this->db->join('person', 
                'project_staff.person_id = person.id');
        if ($projectid > 0)
        {
            $this->db->where('project_id', $projectid);
        }
        
        $this->db->order_by("person.surname", "asc");  
        $query = $this->db->get();
        return $query->result_array();
    }
    
    /**
     * Read project staffs that are not selected in the project.
     * 
     * @param int $id Primary key of a project
     * 
     * @return <array> Project's staff
     */
    public function read_not_project_staffs($id)
    {
        // subquery and a parameter in a query
        $sql = 'SELECT person.id AS person_id, person.surname AS surname ,' .
                'person.firstname AS firstname '.
                'FROM person WHERE person.id NOT IN ( ' .
                'SELECT person.id AS id FROM person ' .
                'INNER JOIN project_staff ON person.id = project_staff.person_id ' .
                'WHERE project_staff.project_id = ?)';
        
        $query = $this->db->query($sql, array($id));
        return $query->result();
    }
    
     /**
     * Update project_staff in the project_staff table.
     * 
     * @param <array> $data Project_staff data to be updated in the table. 
     */
    public function update($data)
    {
        if (empty($data['end_date']))
        {
            $data['end_date'] = NULL;
        }
        
        if ($data['person_role_id'] == 0)
        {
            $data['person_role_id'] = NULL;
        }
        
        $this->db->where('id', $data['id']);
        $query = $this->db->update('project_staff', $data);
    }

     /**
     * Delete a project_staff from the project_staff table.
     * 
     * @param int $id Primary key of the project_staff to delete. 
     */
    public function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('project_staff');
    }
}

?>
