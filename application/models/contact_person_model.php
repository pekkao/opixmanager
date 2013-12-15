<?php
/**
 * @package opix
 * @copyright Oulu University of Applied Sciences(OUAS)
 * @license MIT
 * @version 0.1
 */

/**
 * Class definition for Contact_person_Model extends CI_Model.
 *
 * Class definition for Contact_person_Model model. Model includes methods
 * to handle Contact_person listing, inserting, editing and deleting Contact_persons.
 * Extends CI_Model.
 * 
 * @author Liisa Auer
 * @package opix
 * @subpackage modelss
 * @category Contact_person
 */
class Contact_Person_Model extends CI_Model 
{
    /**
     * Constructor of the class
     */
    public function __construct() 
    {
        parent::__construct();
    }
    
    /**
     * Insert contact person into the contact_person table.
     * 
     * @param <array> $data Contact Person data
     * @return int Returns the primary key of the new contact person. 
     */
    public function create($data)
    {
        if ($data['customer_id'] == 0)
        {
            $data['customer_id'] = NULL;
        }
        
        if (empty($data['surname']))
        {
            $data['surname'] = NULL;
        }
        
        if (empty($data['firstname']))
        {
            $data['lastname'] = NULL;
        }
        
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
        
        $this->db->insert('contact_person',$data);
        return $this->db->insert_id();
    }
    
    /**
     * Read contact person from the contact_person table using primary key.
     * 
     * @param int $id Primary key of the contact person
     * @return <array> contact person data 
     */
    public function read($id)
    {
        $this->db->select(
            'contact_person.id AS id, contact_person.surname AS surname, '.
            'contact_person.firstname AS firstname, contact_person.title AS title, '.
            'contact_person.phone_number AS phone_number, '.
            'contact_person.email AS email, customer.id AS customer_id, ' .
            'customer.customer_name AS customer_name'
        );
        
        $this->db->from('contact_person');
        $this->db->join('customer', 
                'contact_person.customer_id = customer.id');
        $this->db->where('contact_person.id',$id);
        $query = $this->db->get();
        return $query->result();
    }
    
    /**
     * Read all the contact persons from the contact_person table
     * 
     * @return <array> contact persons. 
     */
    public function read_all($customer_id = 0)
    {
        $this->db->select(
            'contact_person.id AS id, contact_person.surname AS surname,' .
            'contact_person.firstname AS firstname, contact_person.title AS title,' .
            'contact_person.phone_number AS phone_number,' .
            'contact_person.email AS email, customer.id AS customer_id,' .
            'customer.customer_name AS customer_name'
        );
        
        $this->db->from('contact_person');
        $this->db->join('customer', 
                'contact_person.customer_id = customer.id');
        
        if ($customer_id > 0)
        {
            $this->db->where('contact_person.customer_id', $customer_id);
        }
        
        $this->db->order_by("customer.customer_name", "asc");
        $this->db->order_by("contact_person.surname", "asc");
        $this->db->order_by("contact_person.firstname", "asc");
        $query = $this->db->get();
        return $query->result(); 
    }
    
    /**
     * Read the contact persons of a customer from the contact_person table
     * 
     * @param int $customerid Foreign key value (customerid) of the contact person
     * @return <array> contact persons of a customer. 
     */
    public function read_customer_contacts($customerid)
    {
        $this->db->where('customerid', $data['customerid']);
        $query = $this->db->get('contact_person');
        return $query->result();
    }
    
    /**
     * Update contact person in the contact_person table.
     * 
     * @param <array> $data contact person data to be updated in the table. 
     */
    public function update($data)
    {
        if ($data['customer_id'] == 0)
        {
            $data['customer_id'] = NULL;
        }
        
        if (empty($data['surname']))
        {
            $data['surname'] = NULL;
        }
        
        if (empty($data['firstname']))
        {
            $data['lastname'] = NULL;
        }
        
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
        
        $this->db->where('id',$data['id']);
        $query = $this->db->update('contact_person',$data) ;
    }
    
    /**
     * Delete a contact person from the contact_person table.
     * 
     * @param int $id Primary key of the contact person to delete. 
     */
    public function delete($id)
    {
        $this->db->where('id',$id);
        $this->db->delete('contact_person');
    }
}

?>
