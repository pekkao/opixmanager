<?php
/**
 *  Edit Project staffs view to be used to edit all project staffs in an html table.
 * 
 * @param  $data = array(
 *       'project_staff_id',
 *       'project_id',
 *       'person_id',
 *       'start_date',
 *       'end_date',
 *       'project_name',
 *       'person_role_id',
 *       'surname',
 *       'firstname'
 *   );
 * 
 * @param $data['pagetitle'] Title and heading of the page
 * @param $data['login_user_id'] User's login id (session data)
 * @param $data['login_id'] User's id (session data)
 * @param $data['heading'] Heading for the error message.
 * @param $data['error_message'] The error message to be printed.
 *  
 * @package opix
 * @category View
 * @author Arto Ruonala, Pipsa Korkiakoski, Antti Aho, Liisa Auer,
 *      Tuukka Kiiskinen, Roni Kokkonen
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
echo form_open('project_staff/save_edit'); 
echo form_fieldset();

echo form_hidden('txt_project_id', set_value('id', $project_id));
echo form_hidden('txt_id', set_value('id', $project_staff_id));

echo form_label('<p><span class="label label-success">Surname: </span></p>',$this->lang->line('label_surname'), 'txt_surname');

$data = array(
    'class' => 'sameline form-control'
);

echo form_label($surname, 'txt_surname', $data);
echo br(1);

echo form_label('<p><span class="label label-success">Firstname: </span></p>',$this->lang->line('label_firstname'), 'txt_firstname');

$data = array(
    'class' => 'sameline form-control'
);

echo form_label($firstname, 'txt_firstname', $data);
echo br(1);

echo form_label('<p><span class="label label-success">Role: </span></p>',$this->lang->line('label_role'), 'ddl_role');
echo ' ';
echo form_dropdown('ddl_role', $roles, $person_role_id, 'class="sameline"');
echo br(1);

echo form_label('<p><span class="label label-success">Start Date: </span></p>',$this->lang->line('label_start_date'), 'dtm_startdate');

$data = array(
    'name' => 'dtm_startdate',
    'class' => 'datepicker',
    'value' => set_value('dtm_startdate', $start_date),
    'maxlength' => '10',
    'size' => '10',
    'type' => 'date',
    'class' => "form-control"
);

echo form_input($data);
echo form_error('dtm_startdate');
echo br(1);

echo form_label('<p><span class="label label-success">End Date: </span></p>',$this->lang->line('label_end_date'), 'dtm_enddate');

$data = array(
    'name' => 'dtm_enddate',
    'class' => 'datepicker',
    'value' => set_value('dtm_enddate', $end_date),
    'maxlength' => '10',
    'size' => '10',
    'type' => 'date',
    'class' => "form-control"
);

echo form_input($data);
echo form_error('dtm_enddate');
echo br(2);

echo form_label('<p><span class="label label-success">Can edit staff: </span></p>',$this->lang->line('label_project_staff_edit'), 'chk_can_edit');
echo '&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp';
if ($can_edit_project_staff == 0)
{
    echo form_checkbox('chk_can_edit', TRUE, FALSE);
}
else 
{
    echo form_checkbox('chk_can_edit', TRUE, TRUE);
}
echo form_error('chk_can_edit');
echo br(2);

echo form_label('<p><span class="label label-success">Can edit project: </span></p>',$this->lang->line('label_project_data_edit'), 'chk_can_edit_project');
echo '&nbsp&nbsp&nbsp&nbsp';
if ($can_edit_project_data == 0)
{
    echo form_checkbox('chk_can_edit_project', TRUE, FALSE);
}
else 
{
    echo form_checkbox('chk_can_edit_project', TRUE, TRUE);
}
echo form_error('chk_can_edit_project');
echo br(2);




echo '<p>';
echo form_submit('btn_submit', $this->lang->line('button_save'), 'class="btn btn-primary"');
echo anchor('project_staff/index/' . $project_id, $this->lang->line('link_return'), 'class="returnlink"');

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