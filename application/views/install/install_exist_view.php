<?php
/**
 *  exist view to be used to remind OpixManager has ready installad before
 * 
 * @param $data['pagetitle'] Title and heading of the page
 *
 * @package opix
 * @category View
 * @author Yuqing Wang
 */
?>
<h4><?php echo $this->lang->line('title_install_exist')?></h4>
<span><?php echo $this->lang->line('txt_install_exist_description')?>
    <a href='<?php echo base_url()."index.php/login"?>'>
       <?php echo $this->lang->line('url_here') ?>
    </a></span>
