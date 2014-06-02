<?php

/**
 * tasks_view to be used to view tasks.
* COMMENTS SHOULD BE REWRITTEN
 * 
 * @param $data = array(        
                'id' => $task[0]->id,
                'task_name' => $task[0]->task_name,
                'task_description' => $task[0]->task_description,
                'task_start_date' => $task[0]->task_start_date,
                'task_end_date' => $task[0]->task_end_date,
                'effort_estimate_hours' => $task[0]->effort_estimate_hours,
                'project_period_id' => $task[0]->project_period_id,
                'task_type_id' => $task[0]->task_type_id,
                'status_id' => $task[0]->status_id
            );
 * 
 * @param $data['pagetitle'] Title and heading of the page
 * @param $data['add'] Hide or show the Reset button (false/true).
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
echo '<p class="polku">' . anchor('project_period/index/' . $project_id, $this->lang->line('link_project_period')) . '</p>';
?>

<h1>   <?php echo($pagetitle) ?> </h1> 

<p>
<?php echo anchor('task/add/' . $project_id . '/' . $currentprojectperiod_id , 
        $this->lang->line('title_add_task')) ?>
</p>
                
<?php

if(isset($tasks))
{      
    foreach($tasks as $task)
    {
        echo '<table>';
        echo '<tbody>';
            echo '<tr>';
                echo '<th class="rivi">' . $this->lang->line('label_task_name') . '</th>';                                     
                echo '<th class="rivi">' . $this->lang->line('label_task_start_date') . '</th>';                
                echo '<th class="rivi">' . $this->lang->line('label_task_end_date') . '</th>';                
                echo '<th class="rivi">' . $this->lang->line('label_effort_estimate_hours') . '</th>';               
                echo '<th class="rivi">' . $this->lang->line('label_status') . '</th>';                
                echo '<th class="rivi">' . $this->lang->line('label_task_type') . '</th>';                
            echo '</tr>';
            
            echo '<tr>';
                echo '<td class="reuna">' . $task->task_name . '</td>';
                echo '<td class="reuna">' . $task->task_start_date . '</td>';
                echo '<td class="reuna">' . $task->task_end_date . '</td>';
                echo '<td class="reuna">' . $task->effort_estimate_hours . '</td>';
                echo '<td class="reuna">' . $task->status_name . '</td>';
                echo '<td class="reuna">' . $task->task_type_name . '</td>';
            echo '</tr>';
        echo '</tbody>';
        echo '</table>';
        
        echo '<table>';
        echo '<tbody>';
            echo '<tr>';
                echo '<th class="reuna">' . $this->lang->line('label_task_description') . '</th>';
            echo '</tr>';
            
            echo '<tr>';
                echo '<td class="reuna">' . $task->task_description . '</td>';
            echo '</tr>';
        echo '</tbody>';
        echo '</table>';
            
        echo '<table>';
        echo '<tbody>';
            echo '<tr>';
                echo '<td class="reuna">' . anchor(
                        'task/edit/' . $project_id . '/' . $task->project_period_id . '/' . $task->id,
                        $this->lang->line('link_edit')) . '</td>';
                echo '<td class="reuna">';
                    echo form_open('task/delete');
                    echo form_hidden('txt_id', set_value('id', $task->id));
                    echo form_hidden('txt_project_id', set_value('project_id', $project_id));
                    echo form_hidden('txt_project_period_id', set_value('project_period_id', $task->project_period_id));
                    echo '<input type="submit" value="X" onclick="return deleteconfirm();" />';
                    echo form_close();
                    echo '</td>';
                echo '<td class="reuna">' . anchor(
                        'task_person/index/' . $project_id . '/' . $task->id,
                        $this->lang->line('link_task_person')) . '</td>';
            echo '</tr>';
        echo '</tbody>';
        echo '</table>';
    }
}
?>

<?php

if ($error_message != '')
{
    echo '<h4>' . $heading . '</h4>';
    echo '<p>' . $error_message . '</p>';
}
?>