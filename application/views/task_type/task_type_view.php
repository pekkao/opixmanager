<?php
/**
 * Task_type_view to be used to insert and update a task type.
 * 
 * @param $data = array(
 *               'id' => $status[0]->id,
 *               'task_type_name' => $status[0]->tasktypename,
 *               'task_type_description' => $status[0]->tasktypedescription
 *              );
 * 
 * @param $data['pagetitle'] Title and heading of the page
 * @param $data['add'] Hide or show the Reset button (false/true).
 *
 */
?>

<h1>
    <?php echo $pagetitle ?>
</h1>
<?php echo form_open('task_type/save');
echo form_fieldset();

echo form_hidden('txt_id', set_value('id', $id));

echo form_label($this->lang->line('label_task_type_name'), 'txt_task_typename');

$data = array(
    'name' => 'txt_task_typename',
    'id' => 'txt_task_typename',
    'value' => set_value('txt_task_typename', $task_type_name),
    'maxlength' => '100',
    'size' => '50',
    'type' => 'text'
);

echo form_input($data);
echo form_error('txt_task_typename');
echo br(1);

echo form_label($this->lang->line('label_task_type_description'), 'txt_task_type_description');
echo br(1);

$data = array(
    'name' => 'txt_task_type_description',
    'id' => 'txt_task_type_description',
    'value' => set_value('txt_task_type_description', $task_type_description),
    'maxlength' => '100',
    'size' => '50',
    'type' => 'text'
);

echo form_textarea($data);
echo form_error('txt_task_type_description');
echo br(2);

echo '<p>';
echo form_submit('btn_submit', $this->lang->line('button_save'), 'class = "newline"');

if ($add == TRUE) 
{
    echo '<input type="button" value="' . $this->lang->line('button_reset') .
            '" onclick="location.href=' . "'" . base_url() .
            'index.php/task_type/add' . "'" . '" />';
}

echo anchor('task_type', $this->lang->line('link_return'), 'class="returnlink"');
echo '</p>';
echo form_fieldset_close();
echo form_close();

?>