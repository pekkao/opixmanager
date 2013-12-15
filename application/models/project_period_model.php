<?php
/**
 * @package opix
 * @copyright Oulu University of Applied Sciences(OUAS)
 * @license MIT
 * @version 0.1
 */

/**
 * Class definition for  Project_period_model Model extends CI_Model.
 *
 * Class definition for  Project_period_model Model. Model includes methods
 * to handle Project period listing, inserting, editing and deleting project periods.
 * Extends CI_Model.
 * 
 * @author Hannu Raappana, Tuukka Kiiskinen, Roni Kokkonen
 * @package opix
 * @subpackage models
 * @category Project_period
 */
class Project_Period_Model extends CI_Model
{   
    /**
     * Constructor of the class
     */
    public function __construct()
    {        
        parent::__construct();        
    }
    
    /**
     * Insert a project period into the project period table.
     * 
     * @param <array> $data project period data
     * @return int Returns the primary key of the new project period. 
     */
    public function create($data)
    {        
        if($data['project_id'] == 0)
        {           
            $data['project_id'] = NULL;
        }
        
        if(empty($data['period_name']))
        {            
            $data['period_name'] = NULL;
        }
        
        if(empty($data['period_description']))
        {            
            $data['period_description'] = NULL;
        }
        
        if(empty($data['period_start_date']))
        {           
            $data['period_start_date'] = NULL;
        }
        
        if(empty($data['period_end_date']))
        {            
            $data['period_end_date'] = NULL;
        }
        
        if(empty($data['milestone']))
        {            
            $data['milestone'] = NULL;
        }
        
        $this->db->insert('project_period', $data);
        return $this->db->insert_id();
    }
    
     /**
     * Read project period from the project period table using primary key.
     * 
     * @param int $id Primary key of the project period
     * @return <array> project period data 
     */
    public function read($id = 0)
    {             
        $this->db->select(
            'project_period.id AS id, project_period.period_name AS period_name,' .
            'project_period.period_start_date AS period_start_date,' .
            'project_period.period_end_date AS period_end_date,' .
            'project_period.milestone AS milestone,' .
            'project_period.period_description AS period_description,' .
            'project_period.project_id AS project_id,'
        );
        
        $this->db->from('project_period');
        $this->db->where('project_period.id',$id);
        $query = $this->db->get();
        return $query->result();
    }
   
    /**
     * Read all the project periods of the selected project. 
     * 
     * @return <array> project_periods. 
     */   
    public function read_all($project_id = 0)
    {      
        $this->db->select( 
           'project_period.id AS id, project_period.period_name AS period_name,' .
           'project_period.period_start_date AS period_start_date,' .
           'project_period.period_end_date AS period_end_date,' .
           'project_period.milestone AS milestone,' .
           'project_period.period_description AS period_description,' .
           'project_period.project_id AS project_id,'
        );
        
        $this->db->from('project_period');
        
        if ($project_id > 0)
        {        
            $this->db->where('project_period.project_id', $project_id);
        }  
        
        $query = $this->db->get();
        return $query->result();
    }
    
    /**
     * Update project period in the project period table.
     * 
     * @param <array> $data project period data to be updated in the table. 
     */
    public function update($data)
    {       
        if($data['project_id'] == 0)
        {          
            $data['project_id'] = NULL;
        }
        
        if(empty($data['period_name']))
        {            
            $data['period_name'] = NULL;
        }
        
        if(empty($data['period_description']))
        {            
            $data['period_description'] = NULL;
        }
        
        if(empty($data['period_start_date']))
        {           
            $data['period_start_date'] = NULL;
        }
        
        if(empty($data['period_end_date']))
        {           
            $data['period_end_date'] = NULL;
        }
        
        if(empty($data['milestone']))
        {           
            $data['milestone'] = NULL;
        }
        
        $this->db->where('id', $data['id']);
        $query = $this->db->update('project_period', $data);        
        
    }     
    
    /**
     * Delete a project period from the project period table.
     * 
     * @param int $id Primary key of the project period to delete. 
     */
    public function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('project_period');
        
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
