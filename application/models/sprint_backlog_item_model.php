<?php
/**
 * @package opix
 * @copyright Oulu University of Applied Sciences(OUAS)
 * @license MIT
 * @version 0.1
 */

/**
 * Class definition for  Sprint_backlog_item_model Model extends CI_Model.
 *
 * Class definition for  Sprint_backlog_item_model Model. Model includes methods
 * to handle Sprint backlog item types listing, inserting, editing and deleting sprint backlog item.
 * Extends CI_Model.
 * 
 * @author Tuukka Kiiskinen, Roni Kokkonen
 * @package opix
 * @subpackage models
 * @category Sprint_Backlog_Item
 */
class Sprint_Backlog_Item_Model extends CI_Model
{
    /**
     * constructor of the class
     */
    public function __construct() 
    {
        parent::__construct();
    }

    /**
     * Insert a sprint backlog item into the sprint backlog item table.
     * 
     * @param <array> $data sprint backlog item data
     * @return int Returns the primary key of the new sprint backlog item. 
     */
    public function create($data)
    {    
        
        $this->db->insert('sprint_backlog_item', $data);
        return $this->db->insert_id();
    }
    
    /**
     * Read sprint backlog item from the sprint backlog item table using primary key.
     * 
     * @param int $id Primary key of the sprint backlog
     * @return <array> sprint backlog item data 
     */
    public function read($id)
    {
        $this->db->select(
        'sprint_backlog_item.sprint_backlog_id AS sprint_backlog_id,' . 
        'sprint_backlog_item.product_backlog_item_id AS product_backlog_item_id,' . 
        'sprint_backlog_item.id AS sprint_backlog_item_id,' . 
        'product_backlog_item.item_name AS item_name'
        );
        
        $this->db->from('sprint_backlog_item');
        $this->db->join('sprint_backlog',
                'sprint_backlog_item.sprint_backlog_id = sprint_backlog.id');
        $this->db->join('product_backlog_item',
                'sprint_backlog_item.product_backlog_item_id = product_backlog_item.id');
        $this->db->where('sprint_backlog_item.id', $id);
        $query = $this->db->get();
        return $query->result();
    }
    
    /**
     * Read all the sprint backlog items of the selected sprint backlog. 
     * 
     * @return <query> sprint_backlog_items. 
     */
    public function read_all($sprintbacklogitemid)
    {
        $this->db->select(
            'sprint_backlog_item.sprint_backlog_id AS sprint_backlog_id,' . 
            'sprint_backlog_item.product_backlog_item_id AS product_backlog_item_id,' . 
            'sprint_backlog_item.id AS id,' . 
            'product_backlog_item.item_name AS item_name,' . 
            'product_backlog_item.item_description AS item_description,' . 
            'product_backlog_item.priority AS priority,' . 
            'product_backlog_item.business_value AS business_value,' . 
            'product_backlog_item.estimate_points AS estimate_points,' . 
            'product_backlog_item.effort_estimate_hours AS effort_estimate_hours,' . 
            'product_backlog_item.acceptance_criteria AS acceptance_criteria,' . 
            'product_backlog_item.release_target AS release_target'
        );
        
        $this->db->from('sprint_backlog_item');
        $this->db->join('sprint_backlog',
                'sprint_backlog_item.sprint_backlog_id = sprint_backlog.id');
        $this->db->join('product_backlog_item',
                'sprint_backlog_item.product_backlog_item_id = product_backlog_item.id');       
        
        if ($sprintbacklogitemid > 0)
        {
            $this->db->where('sprint_backlog_item.sprint_backlog_id', $sprintbacklogitemid);
        }
                
        $query = $this->db->get();
        return $query->result(); 
    }
    
    /**
     *
     * Read all the sprint backlog items currently not selected in the sprint backlog
     * @param int $id Primary key of the sprint backlog
     * @return query results 
     */
    public function read_not_backlog_items($id)
    {
        // subquery and a parameter in a query
        $sql = 'SELECT product_backlog_item.id AS product_backlog_item_id, 
                product_backlog_item.item_name AS item_name ' .           
                'FROM product_backlog_item WHERE product_backlog_item.id NOT IN ( ' .
                'SELECT product_backlog_item.id AS id FROM product_backlog_item ' .
                'INNER JOIN sprint_backlog_item ON product_backlog_item.id = sprint_backlog_item.product_backlog_item_id ' .
                'WHERE sprint_backlog_item.sprint_backlog_id = ?)';
        
        $query = $this->db->query($sql, array($id));
        return $query->result();
    }
    
    /**
     * Delete a sprint backlog item from the sprint backlog item table.
     * 
     * @param int $id Primary key of the sprint backlog item to delete. 
     */
    public function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('sprint_backlog_item');
        
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