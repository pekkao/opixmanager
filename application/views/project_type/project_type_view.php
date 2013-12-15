<?php

/**
 * Project_type_view to be used to insert and update a project_type.
 * 
 * @param $data = array(
 *               'id' => $project_type[0]->id,
 *               'type_name' => $project_type[0]->type_name,
 *               'type_description' => $project_type[0]->type_description
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

<?php echo form_open('project_type/save');
echo form_fieldset();

echo form_hidden('txt_id', set_value('id', $id));

echo form_label($this->lang->line('label_project_type_name'), 'txt_typename');

$data = array(
    'name' => 'txt_typename',
    'id' => 'txt_typename',
    'value' => set_value('txt_name', $type_name),
    'maxlength' => '100',
    'size' => '50',
    'type' => 'text'
);

echo form_input($data);
echo form_error('txt_typename');
echo br(1);

echo form_label($this->lang->line('label_project_type_description'), 'txt_type_description');
echo br(1);

$data = array(
    'name' => 'txt_type_description',
    'id' => 'txt_type_description',
    'value' => set_value('txt_type_description', $type_description),
    'maxlength' => '100',
    'size' => '50',
    'type' => 'text'
);

echo form_textarea($data);
echo br(2);

echo '<p>';
echo form_submit('btn_submit', $this->lang->line('button_save'), 'class="newline"');

if ($add == TRUE)
{
    echo '<input type="button" value ="' . $this->lang->line('button_reset') .
            '"onclick="location.href=' . "'" . base_url() .
            'index.php/project_type/add' . "'" . '" />';
}

echo anchor('project_type', $this->lang->line('link_return'), 'class="returnlink"');
echo '</p>';
echo form_fieldset_close();
echo form_close();

?>
