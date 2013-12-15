<?php

/**
 * Sprint_tasks_view to be used to insert and update sprint_tasks.
 * 
 * @param $data = array(
                'id'         => $sprint_task[0]->id,
                'sprint_backlog_item_id'    => $sprint_task[0]->sprint_backlog_item_id,
                'task_name'  => $sprint_task[0]->task_name,
                'task_description'      => $sprint_task[0]->task_description,
                'effort_estimate_hours'      => $sprint_task[0]->effort_estimate_hours,
                'status_id'      => $sprint_task[0]->status_id,
                'task_type_id' => $sprint_task[0]->task_type_id
 * 
 * @param $data['pagetitle'] Title and heading of the page
 * @param $data['add'] Hide or show the Reset button (false/true).
 * @author Tuukka Kiiskinen, Roni Kokkonen
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
echo '<p class="polku">' . anchor('product_backlog/index/' . $project_id, $this->lang->line('link_product_backlog'));
echo ' >> ';
echo anchor('sprint_backlog/index/' . $project_id . '/' . $product_backlog_id, $this->lang->line('link_sprint_backlog'));
echo ' >> ';
echo anchor('sprint_backlog_item/index/' . $project_id . '/' . $sprint_backlog_item_id, $this->lang->line('link_sprint_backlog_item'));
echo '</p>';
?>

<h1><?php echo $pagetitle ?></h1>

<p>
    <?php   
    if ($currentsprintbacklogid > 0){
        echo anchor('sprint_task/add/' . $project_id . '/' . $currentsprintbacklogid, $this->lang->line('link_add_sprint_task'));
    }  
    ?>
  </p>
    <?php
    if (isset($sprint_tasks))
    {
        foreach ($sprint_tasks as $sprint_task)
        {
            echo '<table>';
            echo '<tbody>';
                echo '<tr>';
                    echo '<th class="rivi">' . $this->lang->line('label_task_name') . '</th>';
                    echo '<td class="rivi">' . $sprint_task->task_name . '</td>';
                    echo '<th class="rivi">' . $this->lang->line('label_effort_estimate_hours') . '</th>';
                    echo '<td class="rivi">' . $sprint_task->effort_estimate_hours . '</td>';
                    echo '<th class="rivi">' . $this->lang->line('label_status') . '</th>';
                    echo '<td class="rivi">' . $sprint_task->status_name . '</td>';
                    echo '<th class="rivi">' . $this->lang->line('label_task_type') . '</th>';
                    echo '<td class="rivi">' . $sprint_task->task_type_name . '</td>';
                echo '</tr>';
            echo '</tbody>';
            echo '</table>';

            echo '<table>';
            echo '<tbody>';
                echo '<tr>';
                    echo '<th class="reuna">' . $this->lang->line('label_task_description') . '</th>';
                echo '</tr>';

                echo '<tr>';
                    echo '<td class="reuna">' . $sprint_task->task_description . '</td>';
                echo '</tr>';
            echo '</tbody>';
            echo '</table>';

            echo '<table>';
            echo '<tbody>';
                echo '<tr>';
                    echo '<td class="reuna">' . anchor ('sprint_task/edit/' . $project_id . '/' . 
                            $sprint_task->id,
                            $this->lang->line('link_edit')) . '</td>';
                    echo '<td class="reuna">';
                         echo form_open('sprint_task/delete');
                         echo form_hidden('txt_sprint_backlog_item_id', set_value('sprint_backlog_item_id',
                                 $currentsprintbacklogid));
                         echo form_hidden('txt_project_id', set_value('project_id', $project_id));
                         echo form_hidden('txt_id', set_value('id', $sprint_task->id));
                         echo '<input type="submit" value = "X" onclick="return deleteconfirm();" />';
                         echo form_close();
                    echo '</td>';
                    echo '<td class="reuna">' . anchor ('sprint_task_person/index/' . $project_id .
                            '/' . $sprint_task->id,
                            $this->lang->line('link_sprint_task_persons')) . 
                            '</td>';
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
 

