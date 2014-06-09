<!DOCTYPE html>
<html>
    <?php $this->load->helper('url'); ?>
    <?php $this->lang->load('navigation'); ?>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title><?php echo $pagetitle ?></title>

        <link <?php echo 'href="' . base_url() . 'css/opixstyle.css"' ?>
            type="text/css"  rel="stylesheet" />  
        
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.0/jquery.min.js"></script>

    </head>
    
    <body>
        <div id="wrapper">
            <header>
                <h1>
                    <img <?php echo 'src="' . base_url() . 'css/opixlogo3.png"' ?>  
                        />OpixManager</h1>
                

            </header>
            <div id="logged">
            <?php
                if ($this->session->userdata('logged_in'))
                {
                  echo $login_user_id;
                  echo br(1);
                  echo anchor(base_url() . 'index.php/home/logout',
                          $this->lang->line('nav_logout'));
                }
            ?>
            </div>
            
            <nav>
                <ul>
                    <li>
                        <?php echo anchor(base_url() . 'index.php/home' , 
                        $this->lang->line('nav_home')) ?>
                    </li>
                    <li>
                        <?php
                        
                            echo anchor(base_url() . 'index.php/customer' , 
                            $this->lang->line('nav_customers'));
                        ?>
                    </li>
                    <li><?php
                    if ($this->session->userdata('account_type') == 1)
                    {
                            echo anchor(base_url() . 'index.php/project' , 
                            $this->lang->line('nav_projects')) .
                            '<ul>' .
                            '<li>' . anchor(base_url() . 'index.php/project/index2', 
                                    $this->lang->line('nav_project_show_all'), 'class="submenu"') . '</li>' . 
                            '<li>' . anchor(base_url() . 'index.php/project/index', 
                                    $this->lang->line('nav_project_show_active'), 'class="submenu"') . '</li>' .
                            '<li>' . anchor(base_url() . 'index.php/project/index3', 
                                    $this->lang->line('nav_project_show_finished'), 'class="submenu"') . '</li>' .
                            '</ul>';
                        
                    }
                            ?></li>
                    
                    <li><?php              
                  
                            echo anchor(base_url() . 'index.php/person' , 
                            $this->lang->line('nav_persons'));
                        
                        ?></li>
                    
                    <li><?php
                    
                        echo anchor(base_url() . 'index.php/person_role' , 
                        $this->lang->line('nav_staff_roles'));
                        
                        ?></li>
                    
                    <li><?php
                    
                        echo anchor(base_url() . 'index.php/status' , 
                        $this->lang->line('nav_status'));
                        
                        ?></li>
                    
                    <li><?php
                    
                        echo anchor(base_url() . 'index.php/task_type' , 
                        $this->lang->line('nav_task_type'));
                        
                        ?></li>
                    <li><?php
                    
                        echo anchor(current_url() . '', $this->lang->line('nav_reports')) .
                            '<ul>' . 
                            '<li>' . anchor(base_url() . 'index.php/report/customers_contacts' , 
                        $this->lang->line('nav_customer_contacts'), 'class="submenu"') .
                                '<ul>' .
                                    '<li>' . anchor(base_url() . 'index.php/report/choose_customer',
                                            $this->lang->line('nav_choose_customer'), 'class="subsubmenu"') . '</li>' . 
                                '</ul>' .
                            '</li>' .
                            '<li>' . anchor(base_url() . 'index.php/report/customers_projects',
                        $this->lang->line('nav_customer_projects'), 'class="submenu"') . 
                                '<ul>' .
                                    '<li>' . anchor(base_url() . 'index.php/report/choose_customer_project',
                                            $this->lang->line('nav_choose_customer_project'), 'class="subsubmenu"') . '</li>' . 
                                '</ul>' .
                            '</li>' .
                            '<li>' . anchor(base_url() . 'index.php/report/projects_persons',
                        $this->lang->line('nav_projects_persons'), 'class="submenu"') .
                                '<ul>' .
                                    '<li>' . anchor(base_url() . 'index.php/report/active_projects_persons',
                                            $this->lang->line('nav_project_show_active'), 'class="subsubmenu"') . '</li>' .
                                    '<li>' . anchor(base_url() . 'index.php/report/finished_projects_persons',
                                            $this->lang->line('nav_project_show_finished'), 'class="subsubmenu"') . '</li>' .
                                    '<li>' . anchor(base_url() . 'index.php/report/projects_persons',
                                            $this->lang->line('nav_project_show_all'), 'class="subsubmenu"') . '</li>' .
                                '</ul>' .
                            '</li>' .
                            '<li>' . anchor(base_url() . 'index.php/report/persons_projects',
                        $this->lang->line('nav_persons_projects'), 'class="submenu"') . '</li>' .
                            '<li>' . anchor(base_url() . 'index.php/report/choose_project',
                        $this->lang->line('nav_choose_project'), 'class="submenu"') . '</li>' .
                            '<li>' . anchor(base_url() . 'index.php/report/choose_project_sprint',
                        $this->lang->line('nav_choose_project_sprint'), 'class="submenu"') . '</li>' .
                            '<li>' . anchor(base_url() . 'index.php/report/choose_project_period',
                        $this->lang->line('nav_choose_project_period'), 'class="submenu"') . '</li>' .
                            '<li>' . anchor(base_url() . 'index.php/report/choose_person',
                        $this->lang->line('nav_choose_person'), 'class="submenu"') . '</li>' .
                            '</ul>';
                        
                            
                            ?></li>
                    <li><?php
                    if ($this->session->userdata('account_type') == 1)
                    {
                        echo anchor(base_url() . 'index.php/backup' , 
                        $this->lang->line('nav_backup'));
                    }  
                        ?></li>
                    <li><?php
                    if ($this->session->userdata('logged_in'))
                    {
                        if ($this->session->userdata('account_type') == 1)
                        {
                            echo anchor(base_url() . 'index.php/sprint_work/choose_person' , 
                            $this->lang->line('nav_sprint_work'));
                        }
                    }
                        ?></li>
                    <li><?php
                    if ($this->session->userdata('logged_in'))
                    {
                        if ($this->session->userdata('account_type') == 1)
                        {
                             echo anchor(base_url() . 'index.php/task_work/choose_person' , 
                             $this->lang->line('nav_task_work'));
                        }
                    }
                        ?></li>
                </ul>
            </nav>
            <section>
                
                <?php
                $this->load->view($main_content);
                ?>              
            </section>
            <footer>
                <p><?php echo $this->lang->line('label_footer'); ?></p>
            </footer>
            
        </div>    
    </body>
</html>
