<?php
/**
 * @package opix
 * @copyright Oulu University of Applied Sciences(OUAS)
 * @license MIT
 * @version 0.1
 */

/**
 * Class definition for Person_Role_Model Model extends CI_Model.
 *
 * Class definition for Person_Role_Model Model. Model includes methods
 * to handle Person roles listing, inserting, editing and deleting Person roles.
 * Extends CI_Model.
 * 
 * @author Wang Yuqing
 * @package opix
 * @subpackage models
 * @category person_roles
 */

class Person_Role_Model extends CI_Model 
{
    /**
     * Constructor of the class
     */
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * Read all the person_roles from the person_role table
     * 
     * @return <array> person_roles. 
     */
    public function read_all()
    {
        $this->db->select('id, role_name, role_description');
        $this->db->from('person_role');
        $this->db->order_by('role_name');
        $query = $this->db->get();
        return $query->result();
    }
    
    /**
     * Read person_role from the person_role table using primary key.
     * 
     * @param int $id Primary key of the person_role
     * @return <array> Person_role data 
     */
    public function read($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('person_role');
        return $query->result();
    }
    
    /**
     * Update person_role in the person_role table.
     * 
     * @param <array> $data person_role data to be updated in the table. 
     */
    public function update($data)
    {
        if (empty($data['role_description']))
        {
            $data['role_description'] = NULL;
        }
        
        $this->db->where('id', $data['id']);
        $query = $this->db->update('person_role', $data);
    }
    
    /**
     * Insert person_role into the person_role table.
     * 
     * @param <array> $data person_role data
     * @return int Returns the primary key of the new person_role . 
     */
    public function create($data)
    {
        if (empty($data['role_description']))
        {
            $data['role_description'] = NULL;
        }
        
        $this->db->insert('person_role', $data);
        return $this->db->insert_id();
    }
    
    /**
     * Delete a person_role from the person_role table.
     * 
     * @param int $id Primary key of the Person_role to delete. 
     */
    public function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('person_role');
    }
       
    /**
     * Read role_names from the person_role table.
     */
    public function read_names()
    {
        $this->db->select('id, role_name');
        $this->db->from('person_role');
        $this->db->order_by('role_name');
        $query = $this->db->get();
        return $query->result_array();
    }
    
}
?>
