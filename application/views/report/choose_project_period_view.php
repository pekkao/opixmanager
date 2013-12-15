<?php
/**
 * Select a project from dropdownlist
 * @param $data['projects'] project names and ids
 * @param $data['pagetitle'] Title and heading of the page
 
 * @package opix
 * @category View
 * @author Roni Kokkonen, Tuukka Kiiskinen
 */
?>

<h1><?php echo $pagetitle ?></h1>

<?php 
echo form_fieldset();

echo form_open('report/project_periods_tasks');

echo form_label($this->lang->line('label_project_name'), 'ddl_project');
//echo form_hidden('txtroleId', set_value('id', $id));
// the first one is selected now
echo form_dropdown('ddl_project', $projects, $selected_project, 'class="sameline"');
echo br(2);

echo form_submit('btn_save', $this->lang->line('button_save'));
echo br(2);

echo form_fieldset_close();
echo form_close();
echo br(2);
?>
