<?php
/**
 * language view to be used to setting running language for installer
 * 
 * @param $data['pagetitle'] Title and heading of the page
 *
 * @package opix
 * @category View
 * @author Yuqing Wang
 */
?>

<h3><?php echo $this->lang->line('title_welcome')?></h3>
<?php 
$attributes=array('class' =>'form-horizontal', 'role' => 'form', 'id'=>'language_form',
                    );
echo form_open('install', $attributes);
?>

<div class="form-group">
    <label for="language" class="col-sm-6 control-label">
        <?php echo  $this->lang->line('txt_language_choose')?></label>
    <div class="col-sm-5">
      <select class="form-control" name="languages">
        <option value="English"><?php echo $this->lang->line('lbl_english')?></option>
        <option value="Finnish"><?php echo $this->lang->line('lbl_finnish')?></option>
      </select>
    </div>
        	
  </div>
    
    <div class='form-actions'>
        <input id="configuration_submit" class="btn btn-small btn-default" name="submit" type="submit" 
               value="<?php echo $this->lang->line('btn_run_installer')?>" />

    </div>

</form>