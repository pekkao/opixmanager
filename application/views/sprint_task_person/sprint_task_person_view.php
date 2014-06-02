<?php
/**
 * Sprint task person view is to add hours for persons to sprint item tasks 
 * or edit a person's hours for a sprint item task.
 * 
 * When adding persons
 * $data = array(
 *       'person_id',
 *       'firstname',
 *       'surname', 
 *       'selected'           
 *  );
 * 
 * 
 * When editing a person
 * $data = array(
 *        'id',
 *        'sprint_task_id',
 *        'person_id',
 *        'estimate_work_effort_hours',
 *        'firstname',
 *        'surname' 
 *   );
 * 
 * @param $data['task_persons'] Persons that are not currently working with a task
 * @param $data['add'] Add persons or edit persons hours
 * @param $data['project_id'] Selected project
 * @param $data['sprint_task_id'] Selected sprint task
 * @param $data['estimate_work_effort_hours'] Empty data for empty effort hours for add
 * @param $data['pagetitle'] Title and heading of the page
 * @param $data['heading'] Heading for the error message.
 * @param $data['error_message'] The error message to be printed.
 * @param $data['login_user_id'] User's login id (session data)
 * @param $data['login_id'] User's id (session data)
 * 
 * @package opix
 * @category View
 * @author Tuukka Kiiskinen, Roni Kokkonen
 */
?>

<h1><?php echo $pagetitle ?></h1>

<?php 

if ($add == TRUE)
{
    echo form_fieldset();
    echo form_open('sprint_task_person/save');

    echo form_hidden('sprint_task_id', $sprint_task_id);
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
    echo anchor('sprint_task_person/index/' . $project_id . '/' . $sprint_task_id,
            $this->lang->line('link_return'), 'class="returnlink"');
    echo form_close();
    echo form_fieldset_close();
}

else
{
    echo form_fieldset();    
    echo form_open('sprint_task_person/save_edit');

    echo form_hidden('sprint_task_id', $sprint_task_id);
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
        echo form_error('txt_eweh');
    echo '</td>';
    echo '</table>';
    echo br(1);
    echo form_submit('btn_save', $this->lang->line('button_save'));
    echo anchor('sprint_task_person/index/' . $project_id . '/' . $sprint_task_id,
            $this->lang->line('link_return'), 'class="returnlink"');  
    echo form_close();
    echo form_fieldset_close();
}


echo br(2);
?>

<?php
if ($error_message != '')
{
    echo '<p>' . $error_message . '</p>';
}
?>