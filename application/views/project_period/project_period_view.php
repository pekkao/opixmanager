<?php

/**
 * Project_period_view to be used to insert and update a project_period.
 * 
 * @param $data = array(
 *   'id', 
 *   'period_start_date',
 *   'period_end_date', 
 *   'milestone',
 *   'period_name', 
 *   'period_description', 
 *   'project_id'
 *    );
 * 
 * @param $data['pagetitle'] Title and heading of the page
 * @param $data['add'] Hide or show the Reset button (false/true).
 * @param $data['error_message'] The error message to be printed.
 * @param $data['login_user_id'] User's login id (session data)
 * @param $data['login_id'] User's id (session data)
 * 
 * @package opix
 * @category View
 * @author Hannu Raappana, Tuukka Kiiskinen, Roni Kokkonen
 */

?>

<link rel="stylesheet" href="http://code.jquery.com/ui/1.9.2/themes/base/jquery-ui.css" />
<script src="http://code.jquery.com/jquery-1.8.3.js"></script>
<script src="http://code.jquery.com/ui/1.9.2/jquery-ui.js"></script>
<script> $(function() {
        $( ".datepicker" ).datepicker({
            dateFormat: "yy-mm-dd",
            showOtherMonths: true,
            selectOtherMonths: true,
            showAnim: "slideDown"
        });
    });
</script>

<h1><?php echo $pagetitle ?></h1>

<?php
echo form_open('project_period/save');
echo form_fieldset();

echo form_hidden('txt_id', set_value('id', $id));
echo form_hidden('txt_projectid', set_value('project_id', $project_id));

echo form_label($this->lang->line('label_period_name'), 'txt_period_name');

$data = array(
    'name' => 'txt_period_name',
    'id' => 'txt_period_name',
    'value' => set_value('txt_period_name', $period_name),
    'maxlength' => '100',
    'size' => '50'
);

echo form_input($data);
echo form_error('txt_period_name');
echo br(2);

echo form_label($this->lang->line('label_period_description'), 'txt_period_description');
$data = array(
    'name' => 'txt_period_description',
    'id' => 'txt_period_description',
    'value' => set_value('txt_period_description', $period_description),
    'maxlength' => '100',
    'size' => '50'
);

echo form_textarea($data);
echo form_error('txt_period_description');
echo br(1);

echo form_label($this->lang->line('label_period_start_date'), 'txt_period_start_date');
$data = array(
    'name' => 'txt_period_start_date',
    'class' => 'datepicker',
    'value' => set_value('txt_period_start_date', $period_start_date),
    'maxlength' => '10',
    'size' => '10'
);

echo form_input($data);
echo form_error('txt_period_start_date');
echo br(1);

echo form_label($this->lang->line('label_period_end_date'), 'txt_period_end_date');
$data = array(
    'name' => 'txt_period_end_date',
    'class' => 'datepicker',
    'value' => set_value('txt_period_end_date', $period_end_date),
    'maxlength' => '10',
    'size' => '10'
);
echo form_input($data);
echo form_error('txt_period_end_date');
echo br(1);

echo form_label($this->lang->line('label_period_milestone'), 'txt_milestone');
$data = array(
    'name' => 'txt_milestone',
    'id' => 'txt_milestone',
    'value' => set_value('txt_milestone', $milestone),
    'maxlength' => '3',
    'size' => '5'
);
echo form_input($data);
echo form_error('txt_milestone');

echo '<p>';
echo form_submit('btn_submit', $this->lang->line('button_save'), 'class="newline"');

if ($add == TRUE)
{
   echo '<input type="button" value="' . $this->lang->line('button_reset') .
            '" onclick="location.href=' . "'" . base_url() . 'index.php/project_period/add/' .
            $project_id . "'" . '" />';
}
echo anchor('project_period/index/' . $project_id, $this->lang->line('link_return'), 'class="returnlink"' );

echo '</p>';
echo form_fieldset_close();
echo form_close();

?>

<?php 
// printing the error message if exists
if ($error_message != '')
{
    echo '<p>' . $error_message . '</p>';
}
?>