<?php

/**
 * Sprint_task_view to be used to insert and update a sprint_task.
 * 
 * @param $data = array(
                'id'         => $sprint_task[0]->id,
                'sprint_backlog_item_id'    => $sprint_task[0]->sprint_backlog_item_id,
                'task_name'  => $sprint_task[0]->task_name,
                'task_description'      => $sprint_task[0]->task_description,
                'effort_estimate_hours'      => $sprint_task[0]->effort_estimate_hours,
                'status_id'      => $sprint_task[0]->status_id,
                'task_type_id' => $sprint_task[0]->task_type_id  
 * 
 * @param $data['pagetitle'] Title and heading of the page
 * @param $data['add'] Hide or show the Reset button (false/true).
 * @author Tuukka Kiiskinen, Roni Kokkonen
 * 
 */

?>
<h1><?php echo $pagetitle ?></h1>

<?php
echo form_open('sprint_task/save');
echo form_fieldset();

echo form_hidden('txt_id', set_value('id', $id));
echo form_hidden('txt_sprint_backlog_item_id', set_value('sprint_backlog_item_id', $sprint_backlog_item_id));
echo form_hidden('txt_project_id', set_value('project_id', $project_id));

echo form_label($this->lang->line('label_task_name'), 'txt_task_name');

$data = array(
    'name' => 'txt_task_name',
    'id' => 'txt_task_name',
    'value' => set_value('txt_task_name', $task_name),
    'maxlength' => '100',
    'size' => '50',
    'type' =>'text'
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
echo br(2);

echo form_label($this->lang->line('label_effort_estimate_hours'), 'txt_effort_estimate_hours');

$data = array(
    'name' => 'txt_effort_estimate_hours',
    'id' => 'txt_effort_estimate_hours',
    'value' => set_value('txt_effort_estimate_hours', $effort_estimate_hours),
    'maxlength' => '100',
    'size' => '50',
    'type' => 'text'
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
echo form_submit('btn_submit', $this->lang->line('button_save'),'class="newline"');

if ($add == TRUE)
{
    echo '<input type="button" value="' . $this->lang->line('button_reset') .
            '" onclick="location.href=' . "'" . base_url() . 'index.php/sprint_task/add/' . $project_id . '/' .
            $sprint_backlog_item_id . "'" . '" />';
}

echo anchor('sprint_task/index/' . $project_id . '/' . $sprint_backlog_item_id, $this->lang->line('link_return'), 'class="returnlink"' );
echo '</p>';
echo form_fieldset_close();
echo form_close();

?>
