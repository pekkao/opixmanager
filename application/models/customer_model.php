<?php
/**
 * @package opix
 * @copyright Oulu University of Applied Sciences(OUAS)
 * @license MIT
 * @version 0.1
 */

/**
 * Class definition for Customer_Model extends CI_Model.
 *
 * Class definition for Customer_Model model. Model includes methods
 * to handle customer listing, inserting, editing and deleting customers.
 * Extends CI_Model.
 * 
 * @author Liisa Auer
 * @package opix
 * @subpackage modelss
 * @category customer
 */
class Customer_Model extends CI_Model 
{
    /**
     * Constructor of the class
     */
    public function __construct() 
    {
        parent::__construct();
    }
    
    /**
     * Insert customer into the customer table.
     * 
     * @param <array> $data Customer data
     * @return int Returns the primary key of the new customer. 
     */
    public function create($data)
    {
        if (empty($data['customer_description']))
        {
            $data['customer_description'] = NULL;
        }
        
        if (empty($data['street_address']))
        {
            $data['street_address'] = NULL;
        }
        
        if (empty($data['post_code']))
        {
            $data['post_code'] = NULL;
        }
        
        if (empty($data['city']))
        {
            $data['city'] = NULL;
        }
        
        if (empty($data['www']))
        {
            $data['www'] = NULL;
        }
        
        $this->db->insert('customer', $data);
        return $this->db->insert_id();
    }
    
    /**
     * Read customer from the customer table using primary key.
     * 
     * @param int $id Primary key of the customer
     * @return <array> Customer data 
     */
    public function read($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('customer');
        return $query->result();
    }
    
    /**
     * Read all the customers from the customer table
     * 
     * @return <array> Customers. 
     */
    public function read_all()
    {
        $this->db->select(
            'id,
            customer_name,
            customer_description,
            street_address,
            post_code,
            city, 
            www'
        );
        
        $this->db->from('customer');
        $this->db->order_by('customer_name');
        $query = $this->db->get();
        return $query->result();
    }
    
    /**
     * Read all the customer names and ids from the customer table
     * @return <result_array> Customers
     */
    public function read_names()
    {
        $this->db->select('id, customer_name');
        $this->db->from('customer');
        $this->db->order_by('customer_name');
        $query = $this->db->get();
        return $query->result_array();
    }
    
    /**
     * Update customer in the customer table.
     * 
     * @param <array> $data Customer data to be updated in the table. 
     */
    public function update($data)
    {
        if (empty($data['customer_description']))
        {
            $data['customer_description'] = NULL;
        }
        
        if (empty($data['street_address']))
        {
            $data['street_address'] = NULL;
        }
        
        if (empty($data['post_code']))
        {
            $data['post_code'] = NULL;
        }
        
        if (empty($data['city']))
        {
            $data['city'] = NULL;
        }
        
        if (empty($data['www']))
        {
            $data['www'] = NULL;
        }
        
        $this->db->where('id', $data['id']);
        $query = $this->db->update('customer', $data) ;
    }
    
    /**
     * Delete a customer from the customer table.
     * 
     * @param int $id Primary key of the customer to delete. 
     */
    public function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('customer');
    }
    
    /**
     * Find a customers that exists based on customer_name
     * 
     * @param type $customer_name The customer_name.
     * @return <array> customers.
     * 
     */
    public function find_customer_by_name($field, $criteria) 
    {
        $this->db->select(
            'id,
            customer_name,
            customer_description,
            street_address,
            post_code,
            city, 
            www'
        );
        
        $this->db->from('customer');
        //$this->db->like($field,$criteria);
        $this->db->like($field, $criteria, 'after');
        $this->db->order_by("customer_name", "asc");
        $query = $this->db->get();
        return $query->result();
    }
}

?>
