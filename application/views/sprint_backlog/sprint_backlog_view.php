<?php

/**
 * Sprint_backlog_view to be used to insert and update a sprint_backlog.
 * 
 * @param $data = array(
 *               'id', 
 *               'product_backlog_id', 
 *               'sprint_name', 
 *               'sprint_description',
 *               'start_date',
 *               'end_date'  
 * 
 * @param $data['project_id'] Selected project
 * @param $data['pagetitle'] Title and heading of the page
 * @param $data['add'] Hide or show the Reset button (false/true).
 * @param $data['heading'] Heading for the error message.
 * @param $data['error_message'] The error message to be printed.
 * @param $data['login_user_id'] User's login id (session data)
 * @param $data['login_id'] User's id (session data)
 * 
 * @package opix
 * @category View
 * @author Tuukka Kiiskinen, Roni Kokkonen
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
echo form_open('sprint_backlog/save');
echo form_fieldset();

echo form_hidden('txt_id', set_value('id', $id));
echo form_hidden('txt_product_backlog_id', set_value('id', $product_backlog_id));
echo form_hidden('txt_project_id', set_value('project_id', $project_id));

echo form_label($this->lang->line('label_sprint_name'), 'txt_sprint_name');

$data = array(
    'name' => 'txt_sprint_name',
    'id' => 'txt_sprint_name',
    'value' => set_value('txt_sprint_name', $sprint_name),
    'maxlength' => '100',
    'size' => '50',
    'type' =>'text'
);

echo form_input($data);
echo form_error('txt_sprint_name');
echo br(2);

echo form_label($this->lang->line('label_sprint_description'), 'txt_sprint_description');

$data = array(
    'name' => 'txt_sprint_description',
    'id' => 'txt_sprint_description',
    'value' => set_value('txt_sprint_description', $sprint_description),
    'maxlength' => '100',
    'size' => '50',
    'type' => 'text'
);

echo form_textarea($data);
echo form_error('txt_sprint_description');
echo br(2);

echo form_label($this->lang->line('label_start_date'), 'dtm_start_date');

$data = array(
    'name' => 'dtm_start_date',
    'class' => 'datepicker',
    'value' => set_value('dtm_start_date', $start_date),
    'maxlength' => '100',
    'size' => '10',
    'type' => 'text'
);

echo form_input($data);
echo form_error('dtm_start_date');
echo br(1);

echo form_label($this->lang->line('label_end_date'), 'dtm_end_date');

$data = array(
    'name' => 'dtm_end_date',
    'class' => 'datepicker',
    'value' => set_value('dtm_end_date', $end_date),
    'maxlength' => '50',
    'size' => '10',
    'type' => 'text'
);

echo form_input($data);
echo form_error('dtm_end_date');
echo br(1);

echo '<p>';
echo form_submit('btn_submit', $this->lang->line('button_save'),'class="newline"');

if ($add == TRUE)
{
    echo '<input type="button" value="' . $this->lang->line('button_reset') .
            '" onclick="location.href=' . "'" . base_url() . 'index.php/sprint_backlog/add/' . $project_id . '/' .
            $product_backlog_id . "'" . '" />';
}

echo anchor('sprint_backlog/index/' . $project_id . '/' . $product_backlog_id, $this->lang->line('link_return'), 'class="returnlink"' );
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
