<?php
/**
 * Add task person view to be used to add a task person in an html table.
* COMMENTS SHOULD BE REWRITTEN
 * $data = array(
                'id' => $task_person[0]->id,
                'task_id' => $task_person[0]->task_id,
                'effort_estimate_hours' => $task_person[0]->effort_estimate_hours,
                'start_date' => $task_person[0]->start_date,
                'end_date' => $task_person[0]->end_date,
                'firstname' => $task_person[0]->firstname,
                'surname' => $task_person[0]->surname              
            );
 
 * @param $data['pagetitle'] Title and heading of the page
 * @param $data['add'] Hide or show the Reset button (false/true).
 
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
echo form_fieldset();

if ($add == TRUE)
{
    echo form_open('task_person/save');
    echo form_hidden('txt_task_id', $task_id);
    echo form_hidden('txt_project_id', set_value('project_id', $project_id));

    echo '<table>';
    echo '<tr>';
        echo '<td>' . $this->lang->line('label_select') . '</td>';
        echo '<td>' . $this->lang->line('label_person_name') . '</td>';
        echo '<td>' . $this->lang->line('label_effort_estimate_hours') . '</td>';
        echo '<td>' . $this->lang->line('label_start_date') . '</td>';
        echo '<td>' . $this->lang->line('label_end_date') . '</td>';
    echo '</tr>';

    foreach ($task_persons as $task_person)  
    {
        echo '<tr>';
        echo '<td>';
        // show the data for the checkbox (checked/not checked)
            echo form_checkbox('chk_new_task_person' . '[]', $task_person['person_id'], $task_person['selected']);
        echo '</td>';

        echo '<td>' . $task_person['surname'] . ' ' . $task_person['firstname'] . '</td>';

        echo '<td>';
        echo form_input('txt_eeh' . '[]', $effort_estimate_hours);      
        echo form_error('txt_eeh');
        echo br(1);
        echo '</td>';
        
        echo '<td>';
        echo form_input('dtm_start_date' . '[]', $start_date, 'class="datepicker"');      
        echo br(1);
        echo '</td>';
        
        echo '<td>';
        echo form_input('dtm_end_date' . '[]', $end_date, 'class="datepicker"');      
        echo br(1);
        echo '</td>';
        
        echo '</tr>';
    }

    echo '</table>';
    echo br(1);
    echo form_submit('btn_save', $this->lang->line('button_save'));
    echo anchor('task_person/index/' . $project_id . '/' . $task_id,
            $this->lang->line('link_return'), 'class="returnlink"');
}

else
{
    echo form_open('task_person/save_edit');
    echo form_hidden('task_id', $task_id);
    echo form_hidden('person_id', $person_id);
    echo form_hidden('txt_project_id', set_value('project_id', $project_id));

    echo '<table>';
    echo '<tr>';
        echo '<td>' . $this->lang->line('label_person_name') . '</td>';
        echo '<td>' . $this->lang->line('label_effort_estimate_hours') . '</td>';
        echo '<td>' . $this->lang->line('label_start_date') . '</td>';
        echo '<td>' . $this->lang->line('label_end_date') . '</td>';
    echo '</tr>';
    
    echo '<tr>';
    echo '<td>';
        echo $surname . ' ' . $firstname;
    echo '</td>';
    echo '<td>';
        echo form_input('txt_eeh', $effort_estimate_hours);
    echo '</td>';
    
    echo '<td>';
        echo form_input('dtm_start_date', $start_date, 'class="datepicker"');
    echo '</td>';
    
    echo '<td>';
        echo form_input('dtm_end_date', $end_date, 'class="datepicker"');
    echo '</td>';
    echo '</tr>';
    
    echo '</table>';
    echo br(1);
    echo form_submit('btn_save', $this->lang->line('button_save'));
    echo anchor('task_person/index/' . $project_id . '/' . $task_id,
            $this->lang->line('link_return'), 'class="returnlink"');  
}

echo form_fieldset_close();
echo form_close();
echo br(2);
?>

<?php
if ($error_message != '')
{
    echo '<p>' . $error_message . '</p>';
}
?>