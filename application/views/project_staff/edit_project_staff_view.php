<?php
/**
 *  Edit Project staffs view to be used to edit all project staffs in an html table.
 * 
 * @param  $data = array(
 *       'id' => '',
 *       'surname' => '',
 *       'firstname' => '',
 *       'role' => '',
 *       'start_date' => '',
 *       'end_date' => '',
 *   );
 * @param $data['project_staff'] Project staff names and ids
 * @param $data['pagetitle'] Title and heading of the page
 
 * @package opix
 * @category View
 * @author Arto Ruonala, Pipsa Korkiakoski, Antti Aho, Liisa Auer
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

echo form_label($this->lang->line('label_surname'), 'txt_surname');

$data = array(
    'class' => 'sameline'
);

echo form_label($surname, 'txt_surname', $data);
echo br(1);

echo form_label($this->lang->line('label_firstname'), 'txt_firstname');

$data = array(
    'class' => 'sameline'
);

echo form_label($firstname, 'txt_firstname', $data);
echo br(1);

echo form_label($this->lang->line('label_role'), 'ddl_role');
echo form_dropdown('ddl_role', $roles, $id, 'class="sameline"');
echo br(1);

echo form_label($this->lang->line('label_start_date'), 'dtm_startdate');

$data = array(
    'name' => 'dtm_startdate',
    'class' => 'datepicker',
    'value' => set_value('dtm_startdate', $start_date),
    'maxlength' => '10',
    'size' => '10',
    'type' => 'date'
);

echo form_input($data);
echo form_error('dtm_startdate');
echo br(1);

echo form_label($this->lang->line('label_end_date'), 'dtm_enddate');

$data = array(
    'name' => 'dtm_enddate',
    'class' => 'datepicker',
    'value' => set_value('dtm_enddate', $end_date),
    'maxlength' => '10',
    'size' => '10',
    'type' => 'date'
);

echo form_input($data);
echo form_error('dtm_enddate');
echo br(2);

echo '<p>';
echo form_submit('btn_submit', $this->lang->line('button_save'), 'class="newline"');
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