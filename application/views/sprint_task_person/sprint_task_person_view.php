<?php
/**
 * Add Sprint task person view to be used to add a sprint task person in an html table.
 * 
 * $data = array(
        'id' => $sprint_task_person[0]->id,
        'sprint_task_id' => $sprint_task_person[0]->sprint_task_id,
        'person_id' => $sprint_task_person[0]->person_id,
        'estimate_work_effort_hours' => $sprint_task_person[0]->estimate_work_effort_hours,
        'firstname' => $sprint_task_person[0]->firstname,
        'surname' => $sprint_task_person[0]->surname              
        );
 
 * @param $data['pagetitle'] Title and heading of the page
 * @param $data['add'] Hide or show the Reset button (false/true).
 
 * @package opix
 * @category View
 * @author Tuukka Kiiskinen, Roni Kokkonen
 */
?>

<h1><?php echo $pagetitle ?></h1>

<?php 
echo form_fieldset();

if ($add == TRUE)
{
    echo form_open('sprint_task_person/save');
    echo form_hidden('sprint_task_id', $sprinttask_id);
    echo form_hidden('txt_project_id', set_value('project_id', $project_id));

    echo '<table>';
    echo '<tr>';
        echo '<td>' . $this->lang->line('label_select') . '</td>';
        echo '<td>' . $this->lang->line('label_person_name') . '</td>';
        echo '<td>' . $this->lang->line('label_estimate_work_effort_hours') . '</td>';
    echo '</tr>';

    foreach ($task_persons as $task_person)  
    {
        echo '<tr>';
        echo '<td>';
        // show the data for the checkbox (checked/not checked)
            echo form_checkbox('chk_new_task_person' . '[]', $task_person['person_id'], $task_person['selected']);
        echo '</td>';

        echo '<td>' . $task_person['surname'] . ' ' . $task_person['firstname'] . '</td>';
        echo '</td>';

        echo '<td>';
        echo form_input('txt_eweh' . '[]', $estimate_work_effort_hours);      
        echo form_error('txt_eweh');
        echo br(1);

        echo '</td>';

        echo '</tr>';
    }

    echo '</table>';
    echo br(1);
    echo form_submit('btn_save', $this->lang->line('button_save'));
    echo anchor('sprint_task_person/index/' . $project_id . '/' . $sprinttask_id,
            $this->lang->line('link_return'), 'class="returnlink"');
}

else
{
    echo form_open('sprint_task_person/save_edit');
    echo form_hidden('sprint_task_id', $sprinttask_id);
    echo form_hidden('person_id', $person_id);
    echo form_hidden('txt_project_id', set_value('project_id', $project_id));

    echo '<table>';
    echo '<tr>';
        echo '<td>' . $this->lang->line('label_person_name') . '</td>';
        echo '<td>' . $this->lang->line('label_estimate_work_effort_hours') . '</td>';
    echo '</tr>';
    
    echo '<tr>';
    echo '<td>';
        echo $surname . ' ' . $firstname;
    echo '</td>';
    echo '<td>';
        echo form_input('txt_eweh', $estimate_work_effort_hours);
    echo '</td>';
    echo '</table>';
    echo br(1);
    echo form_submit('btn_save', $this->lang->line('button_save'));
    echo anchor('sprint_task_person/index/' . $project_id . '/' . $sprinttask_id,
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