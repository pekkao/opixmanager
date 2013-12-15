<?php
/**
 * Select a person from dropdownlist
 * @param $data['persons'] person names and ids
 * @param $data['pagetitle'] Title and heading of the page
 
 * @package opix
 * @category View
 * @author Roni Kokkonen, Tuukka Kiiskinen
 */
?>

<h1><?php echo $pagetitle ?></h1>

<?php 
echo form_fieldset();

echo form_open('task_work/index');

echo form_label($this->lang->line('label_person'), 'ddl_person');

echo form_dropdown('ddl_person', $persons, $selected_person, 'class="sameline"');
echo br(2);

echo form_submit('btn_save', $this->lang->line('button_view'));
echo br(2);

echo form_fieldset_close();
echo form_close();
echo br(2);
?>
