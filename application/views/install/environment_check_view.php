<?php
/**
 * Envrionment view to be used to check envrionment and permission
 * 
 * @param $data['pagetitle'] Title and heading of the page
 * @param $data['envrionments'] Chekcing results of envrionment and permission
 * @package opix
 * @category View
 * @author Yuqing Wang
 */
?>
    
<?php echo '<h4>'.$this->lang->line('txt_install_step1').'</h4>';?>
 
<span><?php echo $this->lang->line('txt_install_step1_explanation2')?>
    <input class="pull-right" id="refresh_envrionment" type="button" value="<?php echo $this->lang->line('btn_refresh')?>" display="inline"/></span>

<div id="install_envrionment">
<ul>
    <?php foreach ($environments as $env): ?>
    <li id="toggle">
        <div class="control-group has-<?php echo $env['status'] ? 'success' : 'error'; ?>"> 
            <?php echo $env['name']; ?>
            <span class="help-inline pull-right control-label">
                <strong><?php echo $env['status'] ? 'OK' : "It's not"; ?></strong>
                
            </span>
        </div>
    </li>
       <?php endforeach; ?>
    </ul> 
<?php
        echo '<input class="pull-right btn btn-small btn-default" id="enviroment_submit"
            value="'.$this->lang->line('btn_continue').'" onclick="location.href=' . "'" . base_url() . 'index.php/install/database' ."'" . '" />';?>
</div>   
 


