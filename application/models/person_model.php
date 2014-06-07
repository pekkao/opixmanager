<?php
/**
 * @package opix
 * @copyright Oulu University of Applied Sciences(OUAS)
 * @license MIT
 * @version 0.1
 */

/**
 * Class definition for Person_Model Model extends CI_Model.
 *
 * Class definition for Person_Model Model. Model includes methods
 * to handle Persons listing, inserting, editing and deleting Persons.
 * Extends CI_Model.
 * 
 * @author Wang Yuqing, Tuukka Kiiskinen, Roni Kokkonen
 * @package opix
 * @subpackage models
 * @category person
 */
class Person_Model extends CI_Model
{
    public function __construct() 
    {
        parent::__construct();
    }
    
    /**
     * Read person from the person table using primary key.
     * 
     * @param int $id Primary key of the person
     * 
     * @return <array> person data 
     */
    public function read($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('person');
        return $query->result();
    }


    /**
     * Insert person into the person table.
     * 
     * @param <array> $data Person data
     * 
     * @return int Returns the primary key of the new person. 
     */
    public function create($data)
    {
        if (empty($data['title']))
        {
            $data['title'] = NULL;
        }
        
        if (empty($data['phone_number']))
        {
            $data['phone_number'] = NULL;
        }

        if (empty($data['email']))
        {
            $data['email'] = NULL;
        }
        
        $this->db->insert('person', $data);
        return $this->db->insert_id(); 
    }
    
     /**
     * Update person in the person table.
     * 
     * @param <array> $data Person data to be updated in the table. 
     */
    public function update($data)
    {
        if (empty($data['title']))
        {
            $data['title'] = NULL;
        }
        
        if (empty($data['phone_number']))
        {
            $data['phone_number'] = NULL;
        }

        if (empty($data['email']))
        {
            $data['email'] = NULL;
        }
                
        $this->db->where('id', $data['id']);
        $query = $this->db->update('person', $data);
    }
    
    /**
     * Delete a person from the person table.
     * 
     * @param int $id Primary key of the person to delete. 
     */
    public function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('person');
    }
    
    
    /**
     * Find a person from the person table.
     * 
     * @param string $field Field to be used in search
     * @param string $criteria Criteria to be used in search
     * @return <array> Persons
     */
    public function find_person_by_name($field, $criteria)
    {
        $this->db->select('person.id AS id, person.surname AS surname,
            person.firstname AS firstname, person.title AS title, person.email AS email, 
            person.phone_number AS phone_number,' .
            'person.user_id AS user_id, person.password AS password, 
             person.account_type AS account_type, person.language_id AS language_id,
             language.language_long AS language_long'
        );
        
        $this->db->from('person');
        $this->db->like($field, $criteria, 'after');
        $this->db->join('language', 
                'person.language_id = language.id', 'left');
        $this->db->order_by("surname", "asc");
        $query = $this->db->get();
        return $query->result();
    }
    
    /**
     * Read persons project from the project table.
     * 
     * @param int $id Primary key of the person to read. 
     * 
     * @return <array> Person's project
     */
    public function read_persons_project($id)
    {   
        $this->db->select( 
            'project_staff.project_id AS project_id,' .
            'project_staff.person_id AS person_id,' .
            'project.project_name AS project_name,' .
            'project.project_description AS project_description,' .
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
        $this->db->where('person_id', $id);
        $this->db->order_by("project_name", "asc");
        $query = $this->db->get();
        return $query->result(); 
        
    }
    
    /*
     * Reads person's projects from database.
     * 
     * @param int $id Primary key of the person to read.
     * 
     * @return <array> Person's project
     */
    public function read_person_projects($id)
    {   
        $this->db->select( 
            'project_staff.project_id AS project_id,' .
            'project_staff.person_id AS person_id,' .            
            'person.surname AS surname, person.firstname AS firstname,' .
            'person_role.role_name AS role_name,' .
            'project_staff.id AS id,' .
            'project_staff.start_date AS start_date,' .
            'project_staff.end_date AS end_date,' .
            'project.project_name AS project_name,' .
            'project.project_description AS project_description,' .
            'project.project_start_date AS project_start_date,' .
            'project.project_end_date AS project_end_date,' .
            'project.project_type AS project_type,' .
            'project.customer_id AS customer_id,' .
            'customer.customer_name AS customer_name,' .
            'project.active AS active, ' .
            'project_staff.can_edit_project_data as can_edit_project_data'    
        );
        
        $this->db->from('project_staff');
        $this->db->join('person_role', 
                'project_staff.person_role_id  = person_role.id', 'left');
        $this->db->join('project', 
                'project_staff.project_id = project.id');
        $this->db->join('person', 
                'project_staff.person_id = person.id');
        $this->db->join('customer', 
                'project.customer_id = customer.id', 'left');      
        $this->db->where('person_id', $id);
        $this->db->order_by("project_name", "asc");
        $query = $this->db->get();
        return $query->result(); 
    }
        
    /**
     * Read languages from the language table.
     * 
     * @param int $id Primary key of the person to delete.
     * 
     * @return <array> Languages 
     */
    public function read_language()
    {
        $this->db->select('id, language_long');
        $this->db->from('language');
        $this->db->order_by('language_long');
        $query = $this->db->get();
        return $query->result_array();
    }  
    
    /**
     * Read all the person names and ids from the person table
     * 
     * @return <result_array> Persons
     */
    public function read_names()
    {   
        $sql = 'SELECT person.id AS id, 
                concat(person.surname," " , person.firstname) AS name ' .           
                'FROM person ' .
                'ORDER BY person.surname';       
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    
    /*
     * Reads person name from database.
     * 
     * @param int $id Primary key of the person to read.
     * 
     * @return <array> Person name
     */
    public function read_name($person_id)
    {   
        $sql = 'SELECT concat(person.surname," " , person.firstname) AS name ' .                    
                'FROM person ' .
                'WHERE person.id = ' . $person_id;       
        $query = $this->db->query($sql);
        return $query->result();
    }
    
    /**
     * Reads person data with language name
     * 
     * @return <array> Persons 
     */
    public function read_all_with_group()
    {
        $this->db->select(
            'person.id AS id, person.surname AS surname,' .
            'person.firstname AS firstname, person.title AS title,' .
            'person.email AS email, person.phone_number AS phone_number,' .
            'person.user_id AS user_id, person.password AS password, ' .
            'person.language_id AS language_id,' .
            'language.language_long AS language_long,' .
            'person.account_type AS account_type'
        );
        
        $this->db->from('person');
        $this->db->join('language', 
                'person.language_id = language.id');
        $this->db->order_by('surname');
        
        $query = $this->db->get();
        return $query->result();    
    }
    
    /**
     * Updates person's password.
     * 
     * @param string $data id and password of a person
     */
    public function update_password($data)
    {
        $this->db->where('id', $data['id']);
        $query = $this->db->update('person', $data);
    }
    
    /*
     * Login function that checks if user_id and password matches the database.
     * 
     * @param string $user_id Person's user id
     * @param int $password Person's password
     * @return boolean (not succeed) or <array> Person login data (succeed)
     */
    
    public function login($user_id, $password)
    {
        $this->db->select('id, user_id, password, account_type');
        $this->db->from('person');
        $this->db->where('user_id', $user_id);
        $this->db->where('password', MD5($password));
        
        $query=$this->db->get();
        
        if ($query -> num_rows() === 1)
        {
            return $query->result();
        }
        else
        {
            return false;
        }
    }
}
?>
