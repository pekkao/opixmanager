<?php

/**
 * @package opix
 * @copyright Oulu University of Applied Sciences(OUAS)
 * @license MIT
 * @version 0.1
 */

/**
 * Class definition for Install controller extends CI_Controller.
 *
 * Class definition for Install controller. Controller includes methods
 * to check runing envrioment and files perssion, install opixmanager and 
 * create install.lock file. Extends CI_Controller.
 * 
 * @author Yuqing Wang
 * @package opix
 * @subpackage controllers
 * @category install
 */
class Install extends CI_Controller{
    /**
     * Constructor of a install model.
     * 
     * Constructor of a install model. Loads 'url' and 'file'helper, 
     * and language package.
     */
    public function __construct() 
    {
        
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('file');
        $this->lang->load('install');
        

    }

    /**
     * Show language-choosing page and set the runing language based on 
     * the user's option
     * 
     * Reads contents of config.php and then update the language setting 
     * values from it
     * Uses the install/install_templete_view and install_language_view.
     */
    
    public function index()
    {
        
        if($_POST)
        {
            $language=  $this->input->post('languages');
            $search = array('language'=>'english');
            $replace=array($language);
            
            $config_class= str_replace($search,$replace,
                @file_get_contents(BASEPATH.'../application/config/config_template.php'));
                @file_put_contents(BASEPATH.'../application/config/config.php', $config_class);
                
            $file=FCPATH.'install.lock'; 
            if (file_exists($file)){
                redirect('install/install_exist');
            }else{
                redirect('install/guide');  }  
        }
        $data['install_main_content']='install/install_language_view';
        $data['pagetitle'] = $this->lang->line('title_install_language');
        $this->load->view('install/install_template_view',$data);
             
    }
    
    /**
     * directs users to notice page 
     * 
     * directs users to notice page to remind users that OpixManager have
     * ready installed before
     * 
     * Uses the install/install_templete_view and install_exist_view.
     */
    
    public function install_exist()
    {
        $data['install_main_content']='install/install_exist_view';
        $data['pagetitle'] = $this->lang->line('title_install_language');
        $this->load->view('install/install_template_view',$data);
        
    }

    /**
     * directs users to introduction page 
     * 
     * Uses the install/install_templete_view and install_guide_view.
     */
    
    public function guide()
    {
        $data['pagetitle'] = 'install guide';
        $data['install_main_content']='install/guide_view';
        $this->load->view('install/install_template_view',$data);
    }
     
    /**
     * directs users to envrioment and permission checking page 
     * 
     * Uses the install/install_templete_view and envrioment_check_view.
     */
    
    public function environment()
    {
        $data['environments']= $this->check_environments();
        $data['pagetitle'] = $this->lang->line('title_envrionment');
        $data['install_main_content']='install/environment_check_view';       
        $this->load->view('install/install_template_view',$data);
    }
    
    /**
     * Check  envrionment and permission
     * 
     * Check neccessary running enrvionment and file permission for OpixManager
     */
    
    function check_environments()
    {
        //check runing enviroment
        $environments[] = array(
            'name' => 'PHP version >= 5.1.6',
            'status' => (PHP_VERSION >= '5.1.6')
        );
        $environments[] = array(
            'name' => 'MySQL version > 4.1',
            'status' => TRUE,
        );
        $environments[] = array(
            'name' => 'has MySQL expantions',
            'status' => function_exists('mysql_connect'),
        );

        //check permission
        
        $environments[] = array(
            'name' => './application folder is writable',
            'status' => is_really_writable(BASEPATH .'../application')
        );
        
        $environments[] = array(
            'name' => './application/config folder is writable',
            'status' => is_really_writable(BASEPATH .'../application/config')
        );
        
        $environments[] = array(
            'name' => './application/config/config.php file is writable',
            'status' => is_really_writable(BASEPATH .'../application/config/config.php')
        );
        
        $environments[] = array(
            'name' => './application/config/database.php file is writable',
            'status' => is_really_writable(BASEPATH .'../application/config/database.php')
        );

        return $environments;
    }
    
    /**
     * Connect to a database 
     * 
     * Fetch database information from the ajax request, and then try to 
     * connect database
     *
     */
    
    public function check_database()
    {
        $dbhost = $_REQUEST['dbhost'];
        $dbname = $_REQUEST['dbname'];
        $dbuser = $_REQUEST['dbuser'];
        $dbpwd = $_REQUEST['dbpwd'];       
        $res = array("msg"=>"");
        
        $config['hostname']= $dbhost;
        $config['username'] = $dbuser;
        $config['password']=  $dbpwd ;
        $config['database'] = $dbname;
        $config['dbprefix'] = '';
        $config['dbdriver'] = 'mysql';
        $config['pconnect'] = TRUE;
        $config['db_debug'] = FALSE;
        $config['cache_on'] = FALSE;
        $config['cachedir'] = '';
        $config['char_set'] = "utf8";
        $config['dbcollat'] = "utf8_general_ci"; 

       
        $db = $this->load->database($config, TRUE);
        
        if (!mysql_errno())
            {
                $res["code"]=1;
                $res["msg"]="success";
                
            }else{
                
                $res["code"]=0;
                $res["msg"]="error";
            }
        echo json_encode($res);
        
    }
      
    /**
     * Install OpixManager 
     * 
     * Complete database creation and customize configuration values from 
     * config.php and database.php based on the users' input data
     *
     */
    
    public function database()
    {
        $data['pagetitle']=  $this->lang->line('title_database_connection');        
        $data['install_main_content']='install/database_connection_view';
        $this->load->view('install/install_template_view',$data);
        
        
        if($_POST){
            //connect to the database
            $language=  $this->input->post('ddl_languages');
            $encryption_key=  $this->input->post('encryption_key');
            
            $config['hostname']= $this->input->post('txt_database_host');
            $config['username'] = $this->input->post('txt_database_user_name');
            $config['password']= $this->input->post('txt_password');
            $config['database'] = $this->input->post('txt_database_name');
            $config['dbprefix'] = '';
            $config['dbdriver'] = 'mysql';
            $config['pconnect'] = TRUE;
            $config['db_debug'] = FALSE;
            $config['cache_on'] = FALSE;
            $config['cachedir'] = '';
            $config['char_set'] = "utf8";
            $config['dbcollat'] = "utf8_general_ci"; 

  
            $db = $this->load->database($config, TRUE);
            
            if (!mysql_errno())
            {
                               
                //customize database.php
                $search_array = array('hostname'=>'localhost', 'username'=>'root', 'password'=>'',
                'database'=>'opixmanager');  
                $replace_array = array($config['hostname'], $config['username'],
                $config['password'], $config['database']); 
                
                $database_config = str_replace($search_array, $replace_array, 
                @file_get_contents(BASEPATH.'../application/config/database_template.php'));           
                @file_put_contents(BASEPATH.'../application/config/database.php', $database_config);
                
                //customize config.php          
                $search = array('language'=>'english', 'encryption_key'=>'opixproject');
                $replace=array($language,$encryption_key);
                
                $config_class= str_replace($search,$replace,
                 @file_get_contents(BASEPATH.'../application/config/config_template.php'));
                @file_put_contents(BASEPATH.'../application/config/config.php', $config_class);
                
                
                //create database tables
                $dbsqls=  $this->input->post('ddl_dbsqls');
                if($dbsqls==='with_data'){
                $sql=  file_get_contents(FCPATH.'db/create-database-with-data.sql');
            
                }else{
                $sql=  file_get_contents(FCPATH.'db/create-database-no-data.sql');  

                }
                $sql = str_replace("DROP DATABASE IF EXISTS opixmanager;",'',$sql);
                $sql = str_replace("CREATE DATABASE IF NOT EXISTS opixmanager;",'',$sql);
                $sql = str_replace("USE opixmanager;",'',$sql);
                $explode = explode(";",$sql);
                
                
                foreach ($explode as $query)
                {  
                    if ($query)
                    {
                    $db->query($query.";");
                    }
                }
                
                write_file(BASEPATH .'../install.lock', "Welcome to OpixManager");
                
                redirect('install/complete');
                
                }                   
         }                
    }
 
    /**
     * Directs users to completation page 
     * 
     * Uses the install/install_templete_view and install_complete_view.
     */
    
    public function complete()
    {
          
        $data['pagetitle']=  $this->lang->line('title_complete');        
        $data['install_main_content']='install/install_complete_view';
        $this->load->view('install/install_template_view',$data);
    }

}

