<?php
/**
 * Projects view to be used to show all customers in an html table.
 * 
 * Show Projects and with each Project a link to edit and delete a Project.
 * 
 * @param  $data = array(
 *       'id',
 *       'project_name', 
 *       'project_description', 
 *       'project_start_date', 
 *       'project_end_date', 
 *       'customer_id',
 *       'customer_name',
 *       'project_type',
 *       'active'
 *   );
 * 
 * @param $data['customers'] Customer names and ids for dropdown listbox
 * @param $data['project_types'] Project types and ids for dropdown listbox
 * @param $data['pagetitle'] Title and heading of the page
 * @param $data['add'] Hide or show the Reset button (false/true).
 * @param $data['login_user_id'] User's login id (session data)
 * @param $data['login_id'] User's id (session data)
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

<!-- print the heading -->
<h1><?php echo($pagetitle); ?></h1>

<?php
echo form_open('project/save');
echo form_fieldset();

echo form_hidden('txt_id', set_value('id', $id));

echo form_label('<p><span class="label label-success">Project Name: </span></p>',$this->lang->line('label_project_name'), 'txt_project_name');

$data = array(
    'name' => 'txt_project_name',
    'id' => 'txt_project_name',
    'value' => set_value('txt_project_name', $project_name),
    'maxlength' => '100',
    'size' => '50',
    'type' => 'text',
    'class' => "form-control"
);

echo form_input($data);
echo form_error('txt_project_name');
echo br(1);

echo form_label('<p><span class="label label-success">Description: </span></p>',$this->lang->line('label_project_description'), 'txt_project_description');
echo br(1);

$data = array(
    'name' => 'txt_project_description',
    'id' => 'txt_project_description',
    'value' => set_value('txt_project_description', $project_description),
    'maxlength' => '100',
    'size' => '50',
    'type' => 'text',
    'class' => "form-control",
    'row'=> '5',
);

echo form_textarea($data);
echo form_error('txt_project_description');
echo br(1);

echo form_label('<p><span class="label label-success">Start Date: </span></p>',$this->lang->line('label_project_start_date'), 'dtm_project_start_date');

$data = array(
    'name' => 'dtm_project_start_date',
    'class' => 'datepicker',
    'value' => set_value('dtm_project_start_date', $project_start_date),
    'maxlength' => '10',
    'size' => '10',
    'type'=>'date',
    'class' => "form-control"
);

echo form_input($data);
echo form_error('dtm_project_start_date');
echo br(1);

echo form_label('<p><span class="label label-success">End Date: </span></p>',$this->lang->line('label_project_end_date'), 'dtm_project_end_date');

$data = array(
    'name' => 'dtm_project_end_date',
    'class' => 'datepicker',
    'value' => set_value('dtm_project_end_date', $project_end_date),
    'maxlength' => '10',
    'size' => '10',
    'type'=>'date',
    'class' => "form-control"
);

echo form_input($data);
echo form_error('dtm_project_end_date');
 echo'<br/>';
if ($add == TRUE)
{
    echo form_label('<p><span class="label label-success">Project Type: </span></p>',$this->lang->line('label_project_type'), 'rdo_project_type');
    echo'<br/>';
    echo form_label(Project::toString(Project::TRADITIONAL));
    echo form_radio('rdo_project_type', Project::TRADITIONAL);
    echo form_label(Project::toString(Project::SCRUM));
    echo form_radio('rdo_project_type', Project::SCRUM, TRUE);
    echo form_error('rdo_project_type');
    echo br(1); 
}

else
{
    echo form_label('<p><span class="label label-success">Project Type: </span></p>',$this->lang->line('label_project_type'), 'rdo_project_type'); 
     echo'<br/>';
    if ($project_type == Project::TRADITIONAL)
    {
        echo form_label(Project::toString(Project::TRADITIONAL));
        echo '&nbsp;&nbsp';
        echo form_radio('rdo_project_type', Project::TRADITIONAL, Project::SELECTED);
        echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp';
        echo form_label(Project::toString(Project::SCRUM));
        echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp';
        echo form_radio('rdo_project_type', Project::SCRUM);
    }
    
    else
    {
        echo form_label(Project::toString(Project::TRADITIONAL));
        echo '&nbsp;&nbsp';
        echo form_radio('rdo_project_type', Project::TRADITIONAL);
        echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp';
        echo form_label(Project::toString(Project::SCRUM));
        echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp';
        echo form_radio('rdo_project_type', Project::SCRUM, Project::SELECTED);
    }
echo br(1);
}

if ($add == TRUE)
{
    echo form_label('<p><span class="label label-success">Project Status: </span></p>',$this->lang->line('label_active'), 'rdo_active');
    echo'<br/>';
    echo form_label(Project::toString2(Project::ACTIVE));
    echo '&nbsp;&nbsp';
    echo form_radio('rdo_active', Project::ACTIVE, TRUE);
    echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp';
    echo form_label(Project::toString2(Project::FINISHED));
    echo '&nbsp;&nbsp';
    echo form_radio('rdo_active', Project::FINISHED);
    echo form_error('rdo_active');
    echo br(1); 
}

else
{
    echo form_label('<p><span class="label label-success">Project Status: </span></p>',$this->lang->line('label_active'), 'rdo_active');
    echo'<br/>';
    if ($active == Project::ACTIVE)
    {
        echo form_label(Project::toString2(Project::ACTIVE));
        echo '&nbsp;&nbsp';
        echo form_radio('rdo_active', Project::ACTIVE, Project::SELECTED);
        echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp';
        echo form_label(Project::toString2(Project::FINISHED));
        echo '&nbsp;&nbsp';
        echo form_radio('rdo_active', Project::FINISHED);
    }
    
else
    {
        echo form_label(Project::toString2(Project::ACTIVE));
        echo form_radio('rdo_active', Project::ACTIVE);
        echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp';
        echo form_label(Project::toString2(Project::FINISHED));
        echo form_radio('rdo_active', Project::FINISHED, Project::SELECTED);
    }
echo br(1); 
}

echo form_label('<p><span class="label label-success">Customer: </span></p>',$this->lang->line('label_customer_name'), 'ddl_customer');
echo'<br/>';
echo form_dropdown('ddl_customer', $customers, $customer_id);
echo '<p>';
echo'<br/>';
echo form_submit('btn_submit', $this->lang->line('button_save'), 'class="btn btn-primary"');

if ($add == TRUE)
{
    echo '<input type="button" value="' . $this->lang->line('button_reset') .
            '" onclick="location.href=' . "'" . base_url() . 
            'index.php/project/add' . "'" . '" />';
}

echo anchor('project', $this->lang->line('link_return'), 'class="returnlink"' );
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
