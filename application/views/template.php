<!DOCTYPE html>
 <!-- Copyright [yyyy] [name of copyright owner]

Licensed under the Apache License, Version 2.0 (the "License");
you may not use this file except in compliance with the License.
You may obtain a copy of the License at

    http://www.apache.org/licenses/LICENSE-2.0

Unless required by applicable law or agreed to in writing, software
distributed under the License is distributed on an "AS IS" BASIS,
WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
See the License for the specific language governing permissions and
limitations under the License.
 -->


<html>
    <?php $this->load->helper('url'); ?>
    <?php $this->lang->load('navigation'); ?>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title><?php echo $pagetitle ?></title>
   <!-- Bootstrap Core CSS - Uses Bootswatch Flatly Theme: http://bootswatch.com/flatly/ --> 
    <link <?php echo 'href="' . base_url() . 'css/bootstrap.min.css"' ?>
            type="text/css"  rel="stylesheet" />  
    <!-- Custom CSS -->
        <link <?php echo 'href="' . base_url() . 'css/freelancer.css"' ?>
            type="text/css"  rel="stylesheet" />  
    <!-- Custom Fonts -->
            <link <?php echo 'href="' . base_url() . 'css/font-awesome.min.css"' ?>
            type="text/css"  rel="stylesheet" />  
            
    <link href="http://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
    <link href="http://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet" type="text/css">
 <!--
    <link 
        <?php echo 'href="' . base_url() . 'application/css/opixstyle.css"' ?>
            type="text/css"  rel="stylesheet" />  -->

     <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.0/jquery.min.js"></script>
    </head>
    
    <body id="page-top" class="index">

    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
              <div id="logged" class="pull-right">
            <?php                if ($this->session->userdata('logged_in'))
                {
                  echo $login_user_id;
                  echo br(1);
                  echo anchor(base_url() . 'index.php/home/logout',
                          $this->lang->line('nav_logout'));
                }
            ?>
            </div>
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
           <div class="navbar-brand">OpixManager</div>
           
            <div class="navbar-header page-scroll">
                
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" 
                        data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
<!--                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>-->
                </button>

            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="navbar-collapse collapse navbar-right " id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li class="active">
                        
                       <?php echo anchor(base_url() . 'index.php/home' , 
                      $this->lang->line('nav_home'));  
               
                       ?> 
                    </li>
                    <li class="page-scroll">
                      <?php
                            echo anchor(base_url() . 'index.php/customer' , 
                            $this->lang->line('nav_customers'));
                        ?>
                    </li>


                    <li>  
                <?php if ($this->session->userdata('account_type') == 1) { ?>        
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
            <?php echo $this->lang->line('nav_projects')?> <span class="caret"></span>    </a>                                     
          <ul class="dropdown-menu">

            <li>
                        <?php
                            echo anchor(base_url() . 'index.php/project/index2' , 
                            $this->lang->line('nav_project_show_all'));
                        ?></li>
             <li><?php
                            echo anchor(base_url() . 'index.php/project/index' , 
                            $this->lang->line('nav_project_show_active'));
                        ?></li>
          <li><?php
                            echo anchor(base_url() . 'index.php/project/index3' , 
                            $this->lang->line('nav_project_show_finished'));
                        ?></li>
          </ul>
              <?php } ?>
        </li>
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
                  <li class="menu-item dropdown">                     
                      <a class="dropdown-toggle" data-toggle="dropdown" href="#">           
                        <?php echo $this->lang->line('nav_reports')?>
                       <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li class="menu-item dropdown dropdown-submenu">
                            <a  class="dropdown-toggle" data-toggle="dropdown" href="report/customers_contacts"><?php
                        echo $this->lang->line('nav_customer_contacts');
                        ?></a>
                            <ul class="dropdown-menu">
                                <li class="menu-item">
                            <a href="choose_customer" class="dropdown-toggle" data-toggle="dropdown"><?php
                        echo $this->lang->line('nav_choose_customer');
                        ?></a>
                                </li>
                            </ul>                           
                         <li class="menu-item dropdown dropdown-submenu">
                             <a href="customers_projects" class="dropdown-toggle" data-toggle="dropdown"><?php
                        echo $this->lang->line('nav_customer_projects');
                        ?></a>
                                    <ul class="dropdown-menu">
                                        <li>
                            <a href="choose_customer_project" class="dropdown-toggle" data-toggle="dropdown"><?php
                        echo $this->lang->line('nav_choose_customer_project');
                        ?></a>
                                        </li>
                                    </ul>
                                </li>
                            <li class="menu-item dropdown dropdown-submenu">
                             <a href="projects_persons" class="dropdown-toggle" data-toggle="dropdown"><?php
                        echo $this->lang->line('nav_projects_persons');
                        ?></a>
                                    <ul class="dropdown-menu">
                           <li>
                            <a href="active_projects_persons" class="dropdown-toggle" data-toggle="dropdown"><?php
                        echo $this->lang->line('nav_project_show_active');
                        ?></a>
                                        </li>
                         <li>
                            <a href="finished_projects_persons" class="dropdown-toggle" data-toggle="dropdown"><?php
                        echo $this->lang->line('nav_project_show_finished');
                        ?></a>
                                        </li>
                         <li>
                            <a href="projects_persons" class="dropdown-toggle" data-toggle="dropdown"><?php
                        echo $this->lang->line('nav_project_show_all');
                        ?></a>
                                        </li>
                                    </ul>
                                </li> 
                     <li><?php
                        echo anchor(base_url() . 'index.php/report/persons_projects' , 
                        $this->lang->line('nav_persons_projects'));
                        ?></li>
                   <li><?php
                        echo anchor(base_url() . 'index.php/report/choose_project' , 
                        $this->lang->line('nav_choose_project'));
                        ?></li> 
                   <li><?php
                        echo anchor(base_url() . 'index.php/report/choose_project_sprint' , 
                        $this->lang->line('nav_choose_project_sprint'));
                        ?></li> 
                   <li><?php
                        echo anchor(base_url() . 'index.php/report/choose_project_period' , 
                        $this->lang->line('nav_choose_project_period'));
                        ?></li> 
                  <li><?php
                        echo anchor(base_url() . 'index.php/report/choose_person' , 
                        $this->lang->line('nav_choose_person'));
                        ?></li> 
                    </ul>
                </li>
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
                        else
                        {
                            echo anchor(base_url() . 'index.php/sprint_work/index/' . $login_id , 
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
                        else
                        {
                            echo anchor(base_url() . 'index.php/task_work/index/' . $login_id , 
                            $this->lang->line('nav_task_work'));
                        }
                    }
                        ?></li>         
                    
                </ul>
                </div>
                            </div>
            
            <!-- /.navbar-collapse -->
   
        <!-- /.container-fluid -->
    </nav> 
    <section>
        <div class="container">
                <?php
                $this->load->view($main_content);
                ?> 
            </div>
    </section>

   <!-- Footer -->
    <footer class="text-center">
        <div class="footer-above">
            <div class="container">
                <div class="row">
                    <div class="footer-col col-md-4">
                        <h3>Location</h3>
                        <p><br>Teuvo Pakkalankatu 19, Oulu</p>
                    </div>
                    <div class="footer-col col-md-4">
                        <h3>Around the Web</h3>
                        <ul class="list-inline">
                            <li>
                                <a href="https://www.facebook.com/oamk.liike" class="btn-social btn-outline" target="_blank"><i class="fa fa-fw fa-facebook"></i></a>
                            </li>

                            <li>
                                <a href="#" class="btn-social btn-outline" target="_blank"><i class="fa fa-fw fa-twitter"></i></a>
                            </li>

                            <li>
                                <a href="http://www.oamk.fi/english/info/schools/business/" class="btn-social btn-outline" target="_blank"><i class="fa fa-fw fa-external-link-square"></i></a>
                            </li>
                            <li>
                                <a href="http://opixproject.opiskelijaprojektit.net" class="btn-social btn-outline" target="_blank"><i class="fa fa-fw fa-dribbble"></i></a>
                            </li>
                        </ul>
                    </div>
                    <div class="footer-col col-md-4">
                        <h3>About OpixManager</h3>
                        <p>OpixManager is a web-based open source application which supports the agile Scrum and classic software development process.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-below">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        Copyright by Oulu University Applied of Sciences<i class="fa fa-long-arrow-right"></i>Business Information Technology Unit
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- Scroll to Top Button (Only visible on small and extra-small screen sizes) -->
    <div class="scroll-top page-scroll visible-xs visble-sm">
        <a class="btn btn-primary" href="#page-top">
            <i class="fa fa-chevron-up"></i>
        </a>
    </div>
    
    <!-- jQuery Version 1.11.0 -->
    <script type="text/javascript" src="<?= base_url() ?>js/jquery-1.11.0.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script type="text/javascript" src="<?= base_url() ?>js/bootstrap.min.js"></script>
 
    <!-- Plugin JavaScript -->
    <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
    <script type="text/javascript" src="<?= base_url() ?>js/classie.js"></script>
    <script type="text/javascript" src="<?= base_url() ?>js/cbpAnimatedHeader.js"></script>

    <!-- Custom Theme JavaScript -->
    <script type="text/javascript" src="<?= base_url() ?>js/freelancer.js"></script>

    </body>
</html>
