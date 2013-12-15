<?php
/**
 * Select a customer from dropdownlist
 * @param $data['customers'] customer names and ids
 * @param $data['pagetitle'] Title and heading of the page
 
 * @package opix
 * @category View
 * @author Roni Kokkonen, Tuukka Kiiskinen
 */
?>

<h1><?php echo $pagetitle ?></h1>

<?php 
echo form_fieldset();

echo form_open('report/customer_contacts');

echo form_label($this->lang->line('label_customer'), 'ddl_customer');
//echo form_hidden('txtroleId', set_value('id', $id));
// the first one is selected now
echo form_dropdown('ddl_customer', $customers, $selected_customer, 'class="sameline"');
echo br(2);

echo form_submit('btn_save', $this->lang->line('button_save'));
echo br(2);

echo form_fieldset_close();
echo form_close();
echo br(2);
?>
