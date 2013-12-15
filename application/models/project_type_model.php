<?php
/**
 * @package opix
 * @copyright Oulu University of Applied Sciences(OUAS)
 * @license MIT
 * @version 0.1
 */

/**
 * Class definition for Project_Type_Model Model extends CI_Model.
 *
 * Class definition for Project_Type_Model Model. Model includes methods
 * to handle Project types listing, inserting, editing and deleting project type.
 * Extends CI_Model.
 * 
 * @author Wang Yuqing
 * @package opix
 * @subpackage models
 * @category Project_types
 */
class Project_Type_Model extends CI_Model 
{
    /**
     * Constructor of the class
     */
    public function __construct() 
    {
     /**
     * Constructor of the class
     */
        parent::__construct();
    }
    
    /**
     * Read all the  Project_Types from the  Project_Type table
     * 
     * @return <array>  project_Types. 
     */
    public function read_all()
    {
         $this->db->select(
            'id, type_name, type_description' 
         );
         
         $this->db->from('project_type');
         $this->db->order_by('type_name');
         $query = $this->db->get();
         return $query->result();
    }
    
     /**
     * Read project_type from the project_type table using primary key.
     * 
     * @param int $id Primary key of the project_type
     * @return <array> project_type data 
     */
     public function read($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('project_type');
        return $query->result();
    }
    
    /**
     * Read all the project_type names and ids from the project_type table
     * @return <result_array> Project_types
     */
    public function read_names()
    {
        $query = $this->db->get('project_type');
        return $query->result_array();     
    }
    
    /**
     * Update project_type in the project_type table.
     * 
     * @param <array> $data project_type data to be updated in the table. 
     */
    public function update($data)
    {
        if (empty($data['type_description']))
        {
            $data['type_description'] = NULL;
        }
        
        $this->db->where('id', $data['id']);
        $query = $this->db->update('project_type', $data) ;
    }
    
     /**
     * Insert project_type into the project_type table.
     * 
     * @param <array> $data project_type data
     * @return int Returns the primary key of the new project_type . 
     */
    public function create($data)
    {
        if (empty($data['type_description']))
        {
            $data['type_description'] = NULL;
        }

        $this->db->insert('project_type', $data);
        return $this->db->insert_id();
    }
    
    /**
     * Delete a project_type from the project_type table.
     * 
     * @param int $id Primary key of the Project_type to delete. 
     */
    public function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('project_type');
    }  
}

?>
