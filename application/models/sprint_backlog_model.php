<?php
/**
 * @package opix
 * @copyright Oulu University of Applied Sciences(OUAS)
 * @license MIT
 * @version 0.1
 */

/**
 * Class definition for  Sprint_backlog_model Model extends CI_Model.
 *
 * Class definition for  Sprint_backlog_model Model. Model includes methods
 * to handle Sprint backlog types listing, inserting, editing and deleting sprint backlog.
 * Extends CI_Model.
 * 
 * @author Tuukka Kiiskinen, Roni Kokkonen
 * @package opix
 * @subpackage models
 * @category Sprint_Backlog
 */
class Sprint_Backlog_Model extends CI_Model
{
    /**
     * Constructor of the class
     */
    public function __construct() 
    {
        parent::__construct();
    }

    /**
     * Insert a sprint backlog into the sprint backlog table.
     * 
     * @param <array> $data sprint backlog data
     * 
     * @return int Returns the primary key of the new sprint backlog. 
     */
    public function create($data)
    {    
        if (empty($data['sprint_description']))
        {
            $data['sprint_description'] = NULL;
        }
        
        if (empty($data['end_date']))
        {
            $data['end_date'] = NULL;
        }
        
        $this->db->insert('sprint_backlog', $data);
        return $this->db->insert_id();
    }
    
    /**
     * Read sprint backlog from the sprint backlog table using primary key.
     * 
     * @param int $id Primary key of the sprint backlog
     * 
     * @return <array> sprint backlog data 
     */
    public function read($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('sprint_backlog');
        return $query->result();
    }
    
    /**
     * Read all the sprint backlogs of the selected product backlog. 
     * 
     * @param int productbacklog_id Optional, primary key of a product backlog
     * 
     * @return <array> sprint_backlogs. 
     */
    public function read_all($productbacklog_id = 0)
    {
        $this->db->from('sprint_backlog');
        
        if ($productbacklog_id > 0)
        {
            $this->db->where('sprint_backlog.product_backlog_id', $productbacklog_id);
        }
        
        $this->db->order_by("sprint_backlog.sprint_name", "asc");
        $query = $this->db->get();
        return $query->result(); 
    }
    
    /**
     * Update sprint backlog in the sprint backlog table.
     * 
     * @param <array> $data sprint backlog data to be updated in the table. 
     */
    public function update($data)
    {
        if (empty($data['sprint_description']))
        {
            $data['sprint_description'] = NULL;
        }
        
        if (empty($data['end_date']))
        {
            $data['end_date'] = NULL;
        }
               
        $this->db->where('id', $data['id']);
        $query = $this->db->update('sprint_backlog', $data) ;
    }
    
    /**
     * Delete a sprint backlog from the sprint_backlog table.
     * 
     * @param int $id Primary key of the sprint_backlog to delete. 
     * 
     * @return boolean false if delete does not succeed because of child rows
     */
    public function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('sprint_backlog');
        
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
