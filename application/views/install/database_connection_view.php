<?php
/**
 * Database connection view to be used to gather configuration information 
 * from users
 * 
 * @param $data['pagetitle'] Title and heading of the page
 * @package opix
 * @category View
 * @author Yuqing Wang
 */
?>

<div id="step1">
    <h4><?php echo $this->lang->line('title_database_connection')?></h4>
    <p><?php echo $this->lang->line('txt_install_step2_explanation')?></p>
<?php 
$attributes=array('class' =>'form-horizontal', 'role' => 'form', 'id'=>'frm_db',
                    );
echo form_open('install/database', $attributes);
?>    
<div class="form-group">
    <label for="database_host" class="col-sm-3 control-label"><?php echo $this->lang->line('lbl_host')?></label>
    <div class="col-sm-5">
      <input type="text" class="form-control" name="txt_database_host" id="txt_database_host" 
             value="<?php echo set_value('txt_database_host','localhost')?>"/>
    </div>
        <span class="install_text_warning">*</span>
        <?php echo $this->lang->line('txt_host_hint')?>
  </div>
  
  <div class="form-group">
    <label for="database_name" class="col-sm-3 control-label"><?php echo $this->lang->line('lbl_database_name')?></label>
    <div class="col-sm-5">
        <input type="text" class="form-control" name="txt_database_name" id="txt_database_name" 
               value="<?php echo set_value('txt_database_name','opixmanager')?>"/>
    </div>
    	<span class="install_text_warning">*</span>
        	<?php echo $this->lang->line('txt_db_name_hint')?>
  </div>
  
  <div class="form-group">
    <label for="database_user_name" class="col-sm-3 control-label"><?php echo $this->lang->line('lbl_username')?></label>
    <div class="col-sm-5">
      <input type="text" class="form-control" name="txt_database_user_name" id="txt_database_user_name" 
             value="<?php echo set_value('txt_database_user_name','root')?>"/>
    </div>
    	<span class="install_text_warning">*</span>
        	e.g.root
  </div>
  
  <div class="form-group">
    <label for="password" class="col-sm-3 control-label"><?php echo $this->lang->line('lbl_database_password')?></label>
    <div class="col-sm-5">
      <input type="text" class="form-control" name="txt_password" id="txt_password"
             value="<?php echo set_value('txt_password')?>"/>
    </div>
        	<?php echo $this->lang->line('txt_password_hint')?>
  </div>
  
  <input class="btn btn-default" id="check_database" type="button" value="<?php echo $this->lang->line('btn_connect')?>">


</div>

<div id="step2" style="display:none">
    
    <h4> <?php echo $this->lang->line('title_db_connect_sucess') ?></h4>
    <p><?php echo $this->lang->line('txt_db_connect_sucess') ?></p>
    
    <div class="form-group">
    <label for="password" class="col-sm-3 control-label"><?php echo $this->lang->line('lbl_encryption_key') ?></label>
    <div class="col-sm-5">
      <input type="text" class="form-control" name="encryption_key" id="encryption_key"
             value="<?php echo set_value('txt_encryption_key','opixproject')?>"/>
    </div>
            <?php echo $this->lang->line('txt_encryption_key_hint') ?>
  </div>
  
  <div class="form-group">
    <label for="language" class="col-sm-3 control-label"><?php echo $this->lang->line('lbl_language') ?></label>
    <div class="col-sm-5">
      <select class="form-control" name="ddl_languages">
        <option value="English">English</option>
        <option value="Finnish">Finnish</option>
      </select>
    </div>
        	<?php echo $this->lang->line('txt_language_hint') ?>
  </div>
    
  <div class="form-group">
    <label for="dbsql" class="col-sm-3 control-label">Create Database</label>
    <div class="col-sm-5">
      <select class="form-control" name="ddl_dbsqls">
        <option value="with_data">With data</option>
        <option value="no_data">No data</option>
      </select>
    </div>
        	<?php echo $this->lang->line('txt_database_choose_hint') ?>
  </div>
    
    <div class='form-actions'>
        <input id="configuration_submit" class="btn btn-default" name="submit" type="submit"
               value="<?php echo $this->lang->line('btn_run_install') ?>" />

    </div>
</div>

<div id="step3" style="display:none">
    <h4><?php echo $this->lang->line('title_db_connect_error') ?></h4>
    <p><?php echo $this->lang->line('txt_db_connect_error') ?></p>
    <ul>
    <li><?php echo $this->lang->line('txt_error_factor1') ?></li>
    <li><?php echo $this->lang->line('txt_error_factor2') ?></li>
    <li><?php echo $this->lang->line('txt_error_factor3') ?></li>
    </ul>
    <p> <?php echo $this->lang->line('txt_error_connect_hint') ?>
        <a href="http://opixproject.opiskelijaprojektit.net/images/setupenvironment.pdf" >
            <?php echo $this->lang->line('url_here') ?></a></p>
    <input id="try_install_again" class="btn btn-small btn-default" 
           value="<?php echo $this->lang->line('btn_try_again') ?>"/>
    
</div>

</form>