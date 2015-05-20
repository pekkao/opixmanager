<?php
/**
 * Guide view to be used to show introduction information
 * 
 * @param $data['pagetitle'] Title and heading of the page
 *
 * @package opix
 * @category View
 * @author Yuqing Wang
 */
?>
<div id="install_guide">
    <h4><?php echo $this->lang->line('title_welcome')?> </h4>
    <p>
        <?php echo $this->lang->line('txt_install_description')?>
    </p>
    <ol>
        <li><?php echo $this->lang->line('txt_install_step1')?></li>
            <ol><?php echo $this->lang->line('txt_install_step1_explanation')?></ol>
        <li><?php echo $this->lang->line('txt_install_step2')?> </li>
        
            <ol><?php echo $this->lang->line('lbl_database_name')?></ol>
            <ol><?php echo $this->lang->line('lbl_username')?></ol>
            <ol><?php echo $this->lang->line('lbl_database_password')?></ol>
            <ol><?php echo $this->lang->line('lbl_host')?></ol>
            <ol><?php echo $this->lang->line('lbl_encryption_key')?></ol>
            <ol><?php echo $this->lang->line('lbl_language')?></ol>
            <ol>...</ol>
            
        <li><?php echo $this->lang->line('txt_install_step3')?> </li>
                
    </ol>
    
    <p>
        <?php echo $this->lang->line('txt_install_hint');
              echo '<a href="http://opixproject.opiskelijaprojektit.net/images/setupenvironment.pdf" >'.$this->lang->line('url_here').'</a>' ?>
    </p>
    
    <?php
        echo '<input class="btn btn-default"
            value="'.$this->lang->line('btn_lets_install').'" onclick="location.href=' . "'" . base_url() . 'index.php/install/environment' ."'" . '" />';?>
</div>
