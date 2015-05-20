<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?php echo $pagetitle ?></title>

<link <?php echo 'href="' . base_url() . 'css/install.css"' ?>
            type="text/css"  rel="stylesheet" />
<link <?php echo 'href="' . base_url() . 'css/bootstrap.css"' ?>
            type="text/css"  rel="stylesheet" />

<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.0/jquery.min.js"></script>
<script src="//code.jquery.com/ui/1.11.1/jquery-ui.js"></script>  

 <script <?php echo 'src="' . base_url() . 'js/install.js"' ?>
        type="text/javascript" ></script>
        
<script type="text/javascript">
    var js_base_url= "<?php echo base_url(); ?>"

        </script>

</head>

<body>   
    
 <div class="container">   

         <div class="well" style="position: relative">
             <img id="install_logo" <?php echo 'src="' . base_url() . 'css/opixlogo3.png"' ?>  
                        />
             <div class="install_content">
                        <?php $this->load->view($install_main_content);?>

             </div>
         </div>

 </div>
    <footer>
                <p><?php echo $this->lang->line('lbl_footer');?></p>
            </footer>
      
</body>
 
</html>
