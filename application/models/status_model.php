<?php
/**
 * @package opix
 * @copyright Oulu University of Applied Sciences(OUAS)
 * @license MIT
 * @version 0.1
 */

/**
 * Class definition for Status_Model Model extends CI_Model.
 *
 * Class definition for Status_Model Model. Model includes methods
 * to handle Statuses listing, inserting, editing and deleting Statuses.
 * Extends CI_Model.
 * 
 * @author Tuukka Kiiskinen
 * @package opix
 * @subpackage models
 * @category status
 */

class Status_Model extends CI_Model {
    
    /**
     * Constructor of the class
     */
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * Read all the statuses from the status table
     * 
     * @return <array> statuses. 
     */
    public function read_all() {
        
        $this->db->select(
            'id, status_name, status_description ' 
        );
        
        $this->db->from('status');
        $this->db->order_by('status_name');
        $query = $this->db->get();
        return $query->result();
    }
    
    /**
     * Read status from the status table using primary key.
     * 
     * @param int $id Primary key of the status
     * @return <array> Status data 
     */
    public function read($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('status');
        return $query->result();
    }
    
    /**
     * Read all the status names and ids from the status table
     * @return <result_array> Statuses
     */
    public function read_names()
    {
        $this->db->select('id, status_name');
        $this->db->from('status');
        $this->db->order_by('status_name');
        $query = $this->db->get();
        return $query->result_array();
    }    
    
     /**
     * Update status in the status table.
     * 
     * @param <array> $data status data to be updated in the table. 
     */
    public function update($data)
    {
        if (empty($data['status_description']))
        {
            $data['status_description'] = NULL;
        }
        
        $this->db->where('id', $data['id']);
        $query = $this->db->update('status', $data) ;
    }
    
    /**
     * Insert status into the status table.
     * 
     * @param <array> $data status data
     * @return int Returns the primary key of the new status . 
     */
    public function create($data)
    {
        if (empty($data['status_description']))
        {
            $data['status_description'] = NULL;
        }
        
        $this->db->insert('status', $data);
        return $this->db->insert_id();
    }
    
    /**
     * Delete a status from the status table.
     * 
     * @param int $id Primary key of the Status to delete. 
     * @return boolean false if delete does not succeed because of child rows
     */
    public function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('status');
        
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
