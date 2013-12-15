<?php
/**
 *  Add Project staffs view to be used to add a project staff in an html table.
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
echo form_fieldset();

echo form_open('project_staff/save');
echo form_hidden('project_id', $project_id);

echo form_label($this->lang->line('label_role'), 'ddl_role');
//echo form_hidden('txtroleId', set_value('id', $id));
// the first one is selected now
echo form_dropdown('ddl_role', $roles, $selected_role, 'class="sameline"');
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
echo br(2);

echo '<table>';
echo '<tr>';
        echo '<td>' . $this->lang->line('label_select') . '</td>';
        echo '<td>' . $this->lang->line('label_surname') . '</td>';
        echo '<td>' . $this->lang->line('label_firstname') . '</td>';
echo '</tr>';

foreach ($persons as $person)  
{
   echo '<tr>';
   echo '<td>';
    // show the data for the checkbox (checked/not checked)
        echo form_checkbox('chk_new_staff' . '[]', $person['person_id'], $person['selected']);
   echo '</td>';
    
   echo '<td>' . $person['surname'] . '</td>';
   echo '<td>' . $person['firstname'] . '</td>';
   echo '</td>';       
   echo '</tr>';
}

echo '</table>';
echo br(1);
echo form_submit('btn_save', $this->lang->line('button_save'));
echo anchor('project_staff/index/' . $project_id ,
        $this->lang->line('link_return'), 'class="returnlink"');

echo form_fieldset_close();
echo form_close();
echo br(2);
?>

<?php 
// printing the error message if exists
if ($error_message != '')
{
    echo '<p>' . $error_message . '</p>';
}
?>
