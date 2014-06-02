<?php

/**
 * COMMENTS SHOULD BE REWRITTEN
 * task_view to be used to insert and update a task.
 * 
 * @param $data = array(        
                'id' => $task[0]->id,
                'task_name' => $task[0]->task_name,
                'task_description' => $task[0]->task_description,
                'task_start_date' => $task[0]->task_start_date,
                'task_end_date' => $task[0]->task_end_date,
                'effort_estimate_hours' => $task[0]->effort_estimate_hours,
                'project_period_id' => $task[0]->project_period_id,
                'task_type_id' => $task[0]->task_type_id,
                'status_id' => $task[0]->status_id
            );
 * 
 * @param $data['pagetitle'] Title and heading of the page
 * @param $data['add'] Hide or show the Reset button (false/true).
 *
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
echo form_open('task/save');
echo form_fieldset();

echo form_hidden('txt_id', set_value('id', $id));
echo form_hidden('txt_project_id', set_value('project_id', $project_id));
echo form_hidden('txt_project_period_id', set_value('project_period_id', $project_period_id));

echo form_label($this->lang->line('label_task_name'), 'txt_task_name');
$data = array(
    'name' => 'txt_task_name',
    'id' => 'txt_task_name',
    'value' => set_value('txt_task_name', $task_name),
    'maxlength' => '100',
    'size' => '50',
    'type' => 'text'
);

echo form_input($data);
echo form_error('txt_task_name');
echo br(2);

echo form_label($this->lang->line('label_task_description'), 'txt_task_description');
$data = array(
    'name' => 'txt_task_description',
    'id' => 'txt_task_description',
    'value' => set_value('txt_task_description', $task_description),
    'maxlength' => '100',
    'size' => '50',
    'type' => 'text'
);
echo form_textarea($data);
echo form_error('txt_task_description');
echo br(1);

echo form_label($this->lang->line('label_task_start_date'), 'txt_task_start_date');
$data = array(
    'name' => 'txt_task_start_date',
    'class' => 'datepicker',
    'value' => set_value('txt_task_start_date', $task_start_date),
    'maxlength' => '10',
    'size' => '10'
);
echo form_input($data);
echo form_error('txt_task_start_date');
echo br(1);

echo form_label($this->lang->line('label_task_end_date'), 'txt_task_end_date');
$data = array(
    'name' => 'txt_task_end_date',
    'class' => 'datepicker',
    'value' => set_value('txt_task_end_date', $task_end_date),
    'maxlength' => '10',
    'size' => '10'
);
echo form_input($data);
echo form_error('txt_task_end_date');
echo br(1);

echo form_label($this->lang->line('label_effort_estimate_hours'), 'txt_effort_estimate_hours');
$data = array(
    'name' => 'txt_effort_estimate_hours',
    'id' => 'txt_effort_estimate_hours',
    'value' => set_value('txt_effort_estimate_hours', $effort_estimate_hours),
    'maxlength' => '3',
    'size' => '3',
);

echo form_input($data);
echo form_error('txt_effort_estimate_hours');
echo br(1);

echo form_label($this->lang->line('label_status'), 'ddl_status_id');
echo form_dropdown('ddl_status_id', $statuses, $status_id);

echo form_label($this->lang->line('label_task_type'), 'ddl_task_type_id');
echo form_dropdown('ddl_task_type_id', $task_types, $task_type_id);

echo br(1);


echo '<p>';

echo form_submit('btn_submit', $this->lang->line('button_save'), 'class="newline"');
if ($add == true)

{
    echo '<input type="button" value="' . $this->lang->line('button_reset') .
            '" onclick="location.href=' . "'" . base_url() . 
            'index.php/task/add/' . $project_period_id ."'" . '" />';
}
echo anchor('task/index/' . $project_id . '/' . $project_period_id , $this->lang->line('link_return'), 'class="returnlink"' );
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