<?php
/**
 * @package opix
 * @copyright Oulu University of Applied Sciences(OUAS)
 * @license MIT
 * @version 0.1
 */

/**
 * Class definition for Product_backlog_item_Model Model extends CI_Model.
 *
 * Class definition for Product_backlog_item_Model Model. Model includes methods
 * to handle Product_backlog_items listing, inserting, editing and deleting Product_backlog_items.
 * Extends CI_Model.
 * 
 * @author Wang Yuqing
 * @package opix
 * @subpackage models
 * @category product_backlog_item
 */

class Product_Backlog_Item_Model extends CI_Model
{
    /**
     * Constructor of the class
     */
    public function __construct() 
    {
        parent::__construct();
    }
    
    /**
     * Insert product_backlog_item into the product_backlog_item table.
     * 
     * @param <array> $data product_backlog_item data
     * @return int Returns the primary key of the new product_backlog_item . 
     */
    public function create($data)
    {
        if (empty($data['item_description']))
        {
            $data['item_description'] = NULL;
        }

        if (empty($data['priority']))
        {
            $data['priority'] = NULL;
        }
        
        if (empty($data['business_value']))
        {
            $data['business_value'] = NULL;
        }
        
        if (empty($data['estimate_points']))
        {
            $data['estimate_points'] = NULL;
        }
        
        if (empty($data['effort_estimate_hours']))
        {
            $data['effort_estimate_hours'] = NULL;
        }
        
        if (empty($data['acceptance_criteria']))
        {
            $data['acceptance_criteria'] = NULL;
        }
        
        if (empty($data['release_target']))
        {
            $data['release_target'] = NULL;
        }
        
        if (empty($data['start_date']))
        {
            $data['start_date'] = NULL;
        }
        
        // not handled yet, recursive reference to oneself is not implemented yet
        $data['is_part_of_id'] = NULL;

        $this->db->insert('product_backlog_item', $data);
        return $this->db->insert_id();
    }
    
    /**
     * Read all the product_backlog_items from the product_backlog_item table
     * 
     * @param int product_backlog_id Optional, what product backlog items are to be read.
     *  
     * @return <array> product_backlog_items. 
     */
    public function read_all($product_backlog_id = 0)
    {
        $this->db->select(
            'product_backlog_item.id AS id,' .
            'product_backlog_item.item_name AS item_name,' .
            'product_backlog_item.item_description AS item_description,' .
            'product_backlog_item.priority AS priority,' .
            'product_backlog_item.business_value AS business_value,' .
            'product_backlog_item.estimate_points AS estimate_points,' .
            'product_backlog_item.effort_estimate_hours AS effort_estimate_hours,' .
            'product_backlog_item.acceptance_criteria AS acceptance_criteria,' .
            'product_backlog_item.release_target AS release_target,' .
            'product_backlog.backlog_name AS backlog_name,' .
            'status.status_name AS status_name,' .
            'product_backlog_item.start_date AS start_date'
        );
        
        $this->db->from('product_backlog_item');
        $this->db->join('product_backlog', 
                'product_backlog_item.product_backlog_id = product_backlog.id');
        $this->db->join('item_type', 
                'product_backlog_item.item_type_id = item_type.id');
        $this->db->join('status', 
                'product_backlog_item.status_id = status.id');
        
        if ($product_backlog_id  > 0)
        {
            $this->db->where('product_backlog_item.product_backlog_id', 
                    $product_backlog_id);
        }
        
        $this->db->order_by("product_backlog_item.item_name", "asc");
        $this->db->order_by("item_type.item_type_name", "asc");
        $this->db->order_by("status.status_name", "asc");
        $query = $this->db->get();
        return $query->result(); 
        
    }
    
    /**
     * Read product_backlog_item from the product_backlog_item table using primary key.
     * 
     * @param int $id Primary key of the product_backlog_item
     * 
     * @return <array> Product_backlog_item data 
     */
    public function read($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('product_backlog_item');
        return $query->result();
    }
    
    /**
     * Read Item types.
     * 
     * @return <array> Item types with ids 
     */
    public function read_item_types()
    {
        $this->db->select('id, item_type_name');
        $this->db->from('item_type');
        $this->db->order_by('item_type_name');
        $query = $this->db->get();
        return $query->result_array();
    }
    
    /**
     * Read statuses .
     * 
     * @return <array> Status data with ids 
     */
 /*   public function read_status()
    {
        $this->db->select('id, status_name');
        $this->db->from('status');
        $query = $this->db->get();
        return $query->result_array();
    }    
   */
    
    /**
     * Update product_backlog_item in the product_backlog_item table.
     * 
     * @param <array> $data product_backlog_item data to be updated in the table. 
     */
    public function update($data) 
    {                
        if (empty($data['item_description']))
        {
            $data['item_description'] = NULL;
        }

        if (empty($data['priority']))
        {
            $data['priority'] = NULL;
        }
        
        if (empty($data['business_value']))
        {
            $data['business_value'] = NULL;
        }
        
        if (empty($data['estimate_points']))
        {
            $data['estimate_points'] = NULL;
        }
        
        if (empty($data['effort_estimate_hours']))
        {
            $data['effort_estimate_hours'] = NULL;
        }
        
        if (empty($data['acceptance_criteria']))
        {
            $data['acceptance_criteria'] = NULL;
        }
        
        if (empty($data['release_target']))
        {
            $data['release_target'] = NULL;
        }
        
        if (empty($data['start_date']))
        {
            $data['start_date'] = NULL;
        }
        
        // not handled yet, recursive reference to oneself is not implemented yet
        $data['is_part_of_id'] = NULL;
        
        $this->db->where('id', $data['id']);
        $query = $this->db->update('product_backlog_item', $data) ;
    }
    
    /**
     * Delete a product_backlog_item from the product_backlog_item table.
     * 
     * @param int $id Primary key of the Product_backlog_item to delete. 
     */
    public function delete($id) 
    {
        $this->db->where('id', $id);
        $this->db->delete('product_backlog_item');
        
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
