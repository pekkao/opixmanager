<?php

/**
 * task_persons_view to be used to show all task_persons in an html table.
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
 * 
 * @param $data['task_persons'] All task_persons in an array.
 * @param $data['pagetitle'] Title and heading of the page
 * @param $data['heading'] Heading for the error message.
 * @param $data['error_message'] The error message to be printed.
 *
 */

?>

<script type="text/javascript">
       function deleteconfirm()
    {
        var answer = confirm("Are you sure you want to delete?")
        if (answer){
            document.messages.submit();
        }

        return false;  
    }
</script>

<?php
echo '<p class="polku">' . anchor('project_period/index/' . $project_id, $this->lang->line('link_project_period'));
echo ' >> ';
echo anchor('task/index/' . $project_id . '/' . $project_period_id, $this->lang->line('link_task'));
'</p>';
?>

<h1><?php echo $pagetitle ?></h1>

<p>
    <?php   
    if ($currentid > 0)
    {
        echo '<p>' . anchor('task_person/add/' . $project_id . '/' . $currentid, $this->lang->line('link_add_task_person') . ' ') . '</p>';
    }
    ?>
  </p>
  <table>
        <thead>
            <tr>
                <?php
                echo '<th>' . $this->lang->line('label_person_name') . '</th>';
                echo '<th>' . $this->lang->line('label_effort_estimate_hours') . '</th>';
                echo '<th>' . $this->lang->line('label_start_date') . '</th>';
                echo '<th>' . $this->lang->line('label_end_date') . '</th>';
                echo '<th colspan="3"></th>';
                ?>
            </tr>
        </thead>
        <tbody>
            <?php
            if (isset($task_persons))
            {
                foreach ($task_persons as $task_person)
                {
                    echo '<tr>';
                    echo '<td>' . $task_person->surname . 
                            ' ' . $task_person->firstname . '</td>';
                    echo '<td>' . $task_person->effort_estimate_hours . '</td>';
                    echo '<td>' . $task_person->start_date . '</td>';
                    echo '<td>' . $task_person->end_date . '</td>';
                    echo '<td>' . anchor ('task_person/edit/' . $project_id . '/' .  
                                $task_person->person_id . '/' . $task_person->task_id,
                            $this->lang->line('link_edit')) . '</td>';
                    echo '<td>';
                    echo '<td>';
                         echo form_open('task_person/delete');
                         echo form_hidden('txt_task_id', set_value('task_id',
                                 $currentid));
                         echo form_hidden('txt_project_id', set_value('project_id', $project_id));
                         echo form_hidden('txt_id', set_value('id', $task_person->id));
                         echo '<input type="submit" value = "X" onclick="return deleteconfirm();" />';
                         echo form_close();
                    echo '</td>';
                    echo '</tr>';
                }
            }
            ?>
        </tbody>
    </table>
 
<?php 
if ($error_message != '')
{
    echo '<h4>' . $heading . '</h4>';
    echo '<p>' . $error_message . '</p>';
}
?>