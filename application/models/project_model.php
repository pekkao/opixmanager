<?php 
/**
 * @package opix
 * @copyright Oulu University of Applied Sciences(OUAS)
 * @license MIT
 * @version 0.1
 */

/**
* Project_Model Class
*
* @package	opix
* @subpackage   models
* @category	project
* @author	Antti Aho, Arto Ruonala, Pipsa Korkiakoski
*/
class Project_Model extends CI_Model 
{
    /**
    * Constructor of the class
    */
    public function __construct()
    {
        parent::__construct();
    }
	
    /**
     * Insert a project into the project table.
     * 
     * @param <array> $data Project data
     * @return int Returns the primary key of the new project. 
     */
    public function create($data)
    {
        if ($data['customer_id'] == 0)
        {
            $data['customer_id'] = NULL;
        }

        if ($data['type_id'] == 0)
        {
            $data['type_id'] = NULL;
        }
        
        if (empty($data['project_start_date']))
        {
            $data['project_start_date'] = NULL;
        }

        if (empty($data['project_end_date']))
        {
            $data['project_end_date'] = NULL;
        }
        
        if (empty($data['project_description']))
        {
            $data['project_description'] = NULL;
        }
        
        if (empty($data['project_type']))
        {
            $data['project_type'] = NULL;
        }
        
        if( empty($data['active']))
        {
            $data['active'] = NULL;
        }
        
        $this->db->insert('project', $data);
        return $this->db->insert_id();
    }

    /**
     * Read project from the project table using primary key.
     * 
     * @param int $id Primary key of the project
     * @return <array> project data 
     */
    public function read($id)
    {
       $this->db->where('id', $id);
       $query = $this->db->get('project');
       return $query->result();
    }
    
    /**
     * Read all the projects with foreign key descriptions (type, customer) 
     * from the project table.
     * 
     * @return <array> Projects. 
     */
    public function read_all()
    {
        $this->db->select(
            'project.id AS id, project.project_name AS project_name,' .
            'project.project_description AS project_description,' . 
            'project.project_start_date AS project_start_date,' .
            'project.project_end_date AS project_end_date,' .
            'project.project_type AS project_type,' .
            'project.type_id AS type_id, project.customer_id AS customer_id,' .
            'project_type.type_name AS type_name,' . 
            'customer.customer_name AS customer_name,' .
            'project.active AS active'    
        );
        
        $this->db->from('project');       
        // left join because customer_id can be null 
        $this->db->join('customer', 
                'project.customer_id = customer.id', 'left');
        // left join because type_id can be null 
        $this->db->join('project_type', 
                'project.type_id = project_type.id', 'left');
        $this->db->order_by('project_name');
         
        $query = $this->db->get();
        return $query->result();        
    }
    
    /**
     * Read selected customer's projects from the project table using a key.
     * 
     * @param int $id a customerid of the selected customer
     * @return <array> project data 
     */
    public function read_by_customerid($customerid = 0)
    {
        $this->db->select(
            'project.id AS id, project.project_name AS project_name,' .
            'project.project_description AS project_description,' . 
            'project.project_start_date AS project_start_date,' .
            'project.project_end_date AS project_end_date,' .
            'project.project_type AS project_type,' .
            'project.type_id AS type_id, project.customer_id AS customer_id,' .
            'project_type.type_name AS type_name,' . 
            'customer.customer_name AS customer_name,' .
            'project.active AS active'    
        );
        
        $this->db->from('project');
        $this->db->where('project.customer_id', $customerid);
        // left join because customer_id can be null 
        $this->db->join('customer', 
                'project.customer_id = customer.id', 'left');
        // left join because type_id can be null 
        $this->db->join('project_type', 
                'project.type_id = project_type.id', 'left');
         
        $query = $this->db->get();
        return $query->result();        
    }    
    
    /**
     * Reads all active projects from the project table.
     * 
     * @return <array> project data 
     */
    public function read_all_active_projects()
    {
        $this->db->select(
            'project.id AS id, project.project_name AS project_name,' .
            'project.project_description AS project_description,' . 
            'project.project_start_date AS project_start_date,' .
            'project.project_end_date AS project_end_date,' .
            'project.project_type AS project_type,' .
            'project.type_id AS type_id, project.customer_id AS customer_id,' .
            'project_type.type_name AS type_name,' . 
            'customer.customer_name AS customer_name,' .
            'project.active AS active'    
        );
        
        $this->db->from('project'); 
        $this->db->where('project.active = 2');
        // left join because customer_id can be null 
        $this->db->join('customer', 
                'project.customer_id = customer.id', 'left');
        // left join because type_id can be null 
        $this->db->join('project_type', 
                'project.type_id = project_type.id', 'left');
        $this->db->order_by('project_name');
         
        $query = $this->db->get();
        return $query->result();        
    }
    
    /**
     * Reads all finished projects from the project table.
     * 
     * @return <array> project data 
     */
    public function read_all_finished_projects()
    {
        $this->db->select(
            'project.id AS id, project.project_name AS project_name,' .
            'project.project_description AS project_description,' . 
            'project.project_start_date AS project_start_date,' .
            'project.project_end_date AS project_end_date,' .
            'project.project_type AS project_type,' .
            'project.type_id AS type_id, project.customer_id AS customer_id,' .
            'project_type.type_name AS type_name,' . 
            'customer.customer_name AS customer_name,' .
            'project.active AS active'    
        );
        
        $this->db->from('project'); 
        $this->db->where('project.active = 1');
        // left join because customer_id can be null 
        $this->db->join('customer', 
                'project.customer_id = customer.id', 'left');
        // left join because type_id can be null 
        $this->db->join('project_type', 
                'project.type_id = project_type.id', 'left');
        $this->db->order_by('project_name');
         
        $query = $this->db->get();
        return $query->result();        
    }
    
    /**
     * Reads all scrum projects from the project table.
     * 
     * @return <array> project data 
     */
    public function read_projects()
    {
        $this->db->select('id, project_name');
        $this->db->from('project');
        $this->db->where('project.project_type = 2');
        $this->db->order_by('project_name');
        $query = $this->db->get();
        return $query->result_array();
    }
    
    /**
     * Reads all traditional projects from the project table.
     * 
     * @return <array> project data 
     */
    public function read_traditional_projects()
    {
        $this->db->select('id, project_name');
        $this->db->from('project');
        $this->db->where('project.project_type = 1');
        $this->db->order_by('project_name');
        $query = $this->db->get();
        return $query->result_array();
    }
      
    /**
     * Update project in the project table.
     * 
     * @param <array> $data project data to be updated in the table. 
     */
    public function update($data) 
    {
        if ($data['customer_id'] == 0)
        {
            $data['customer_id'] = NULL;
        }

       // if($data['type_id'] == 0)
        //{
            $data['type_id'] = NULL;
       // }
        
        if (empty($data['project_start_date']))
        {
            $data['project_start_date'] = NULL;
        }

        if (empty($data['project_end_date']))
        {
            $data['project_end_date'] = NULL;
        }
        
        if (empty($data['project_description']))
        {
            $data['project_description'] = NULL;
        }
        
        if (empty($data['project_type']))
        {
            $data['project_type'] = NULL;
        }
        
        if (empty($data['active']))
        {
            $data['active'] = NULL;
        }
        
        $this->db->where('id', $data['id']);
        $query = $this->db->update('project', $data) ;
    }
	
    /**
     * Delete a project from the project table.
     * 
     * @param int $id Primary key of the project to delete. 
     */
    public function delete($id) 
    {
        $this->db->where('id', $id);
        $this->db->delete('project');
        
        if ($this->db->_error_number() == 1451)
        {
            return FALSE;
        }
        else
        {            
            return TRUE;
        }
    }
    
    
    /**
     * Find a projects that have been going on between date_start and date_end
     * 
     * @param type $date_start The start date.
     * @param type $date_end The end date.
     * @return <array> Projects.
     * 
     */
    public function find_project_by_date($date_start, $date_end) 
    {        
        $this->db->select(
            'project.id AS id, project.project_name AS project_name,' .
            'project.project_description AS project_description,' . 
            'project.project_start_date AS project_start_date,' .
            'project.project_end_date AS project_end_date,' .
            'project.type_id AS type_id, project.customer_id AS customer_id,' .
            'project_type.type_name AS type_name,' . 
            'customer.customer_name AS customer_name,' .
            'project.project_type AS project_type,' .
            'project.active AS active' 
        );
        
        $this->db->from('project');
        // left join because customer_id can be null 
        $this->db->join('customer', 
                'project.customer_id = customer.id', 'left');
        // left join because type_id can be null 
        $this->db->join('project_type', 
                'project.type_id = project_type.id', 'left');
    
        $this->db->where('project_end_date >=', $date_start);
        $this->db->where('project_start_date <=', $date_end);
        $this->db->or_where('project_start_date <=', $date_end);
        $this->db->where('project_end_date IS NULL');
        
        $this->db->order_by('project_name');
        
        $query = $this->db->get();
        return $query->result();
    }
    
}
?>
