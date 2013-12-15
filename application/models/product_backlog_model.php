<?php
/**
 * @package opix
 * @copyright Oulu University of Applied Sciences(OUAS)
 * @license MIT
 * @version 0.1
 */

/**
 * Class definition for  Product_backlog_model Model extends CI_Model.
 *
 * Class definition for  Product_backlog_model Model. Model includes methods
 * to handle Product backlog listing, inserting, editing and deleting product backlogs.
 * Extends CI_Model.
 * 
 * @author Wang Yuqing
 * @package opix
 * @subpackage models
 * @category Product_backlog
 */
class Product_Backlog_Model extends CI_Model
{
    /**
     * Constructor of the class
     */
    public function __construct() 
    {
        parent::__construct();
    }

    /**
     * Insert a product backlog into the product backlog table.
     * 
     * @param <array> $data product backlog data
     * @return int Returns the primary key of the new product backlog. 
     */
    public function create($data)
    {    
        if (empty($data['product_visio']))
        {
            $data['product_visio'] = NULL;
        }
        
        if (empty($data['product_current_state']))
        {
            $data['product_current_state'] = NULL;
        }
        
        if (empty($data['product_owner']))
        {
            $data['product_owner'] = NULL;
        }
        
        $this->db->insert('product_backlog', $data);
        return $this->db->insert_id();
    }
    
    /**
     * Read product backlog from the product backlog table using primary key.
     * 
     * @param int $id Primary key of the product backlog
     * @return <array> product backlog data 
     */
    public function read($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('product_backlog');
        return $query->result();
    }
    
    /**
     * Read all the product backlogs of the selected project. 
     * 
     * @return <array> product_backlogs. 
     */
    public function read_all($project_id = 0)
    {
        $this->db->from('product_backlog');
        
        if ($project_id > 0)
        {
            $this->db->where('product_backlog.project_id', $project_id);
        }
        
        $this->db->order_by("product_backlog.backlog_name", "asc");
        $query = $this->db->get();
        return $query->result(); 
    }
    
    /**
     * Update product backlog in the product backlog table.
     * 
     * @param <array> $data product backlog data to be updated in the table. 
     */
    public function update($data)
    {
        if (empty($data['product_visio']))
        {
            $data['product_visio'] = NULL;
        }
        
        if (empty($data['product_current_state']))
        {
            $data['product_current_state'] = NULL;
        }
        
        if (empty($data['product_owner']))
        {
            $data['product_owner'] = NULL;
        }
               
        $this->db->where('id', $data['id']);
        $query = $this->db->update('product_backlog', $data) ;
    }
    
    /**
     * Delete a product backlog from the project table.
     * 
     * @param int $id Primary key of the project to delete. 
     */
    public function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('product_backlog');
        
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
