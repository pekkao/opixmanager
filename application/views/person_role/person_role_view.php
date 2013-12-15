<?php

/**
 * Person_role_view to be used to insert and update a person_roles.
 * 
 * @param $data = array(
 *               'id' => $person_role[0]->id,
 *               'role_name' => $person_role[0]->role_name,
 *               'role_description' => $person_role[0]->role_description
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
<?php echo form_open('person_role/save');
echo form_fieldset();

echo form_hidden('txt_id', set_value('id',$id));

echo form_label($this->lang->line('label_person_role_name'), 'txt_rolename');

$data = array(
    'name'=>'txt_rolename',
    'id' =>'txt_rolename',
    'value' =>  set_value('txt_name', $role_name),
    'maxlength' =>'100',
    'size' =>'50',
    'type' => 'text'
    );

echo form_input($data);
echo form_error('txt_rolename');
echo br(1);

echo form_label($this->lang->line('label_person_role_description'), 'txt_roledescription');
echo br(1);

$data = array(
    'name'=>'txt_roledescription',
    'id' =>'txt_roledescription',
    'value' =>  set_value(' txt_roledescription', $role_description),
    'maxlength' =>'100',
    'size' =>'50',
    'type' => 'text'
    );
echo form_textarea($data);
echo br(2);

echo '<p>';
echo form_submit('btn_submit', $this->lang->line('button_save'), 'class="newline"');

if ($add == TRUE)
{
    echo '<input type="button" value="' . $this->lang->line('button_reset').
            '" onclick="location.href=' . "'" . base_url() .
            'index.php/person_role/add' . "'" . '" />';
}

echo anchor('person_role', $this->lang->line('link_return'), 'class="returnlink"');
echo '</p>';
echo form_fieldset_close();
echo form_close();

?>
