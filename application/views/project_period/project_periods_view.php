<?php

/**
 * Project_periods_view to be used to view project_periods.
 * 
 * @param $data = array(
 *       'id',
 *       'period_name',
 *       'period_description',
 *       'period_start_date',
 *       'period_end_date', 
 *       'milestone',
 *       'project_id', 
 *   );
 * 
 * @param $data['project_periods'] Periods of a selected project in an array
 * @param $data['currentproject_id'] Selected project
 * @param $data['pagetitle'] Title and heading of the page
 * @param $data['add'] Hide or show the Reset button (false/true).
 * @param $data['heading'] Heading for the error message.
 * @param $data['error_message'] The error message to be printed.
 * @param $data['login_user_id'] User's login id (session data)
 * @param $data['login_id'] User's id (session data)
 * 
 * @package opix
 * @category View
 * @author Hannu Raappana, Tuukka Kiiskinen, Roni Kokkonen
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

<h1><?php echo $pagetitle ?></h1>

<p>
    <?php echo anchor('project_period/add/' . $currentproject_id , 
        $this->lang->line('link_project_period')) ?>
</p>

<?php
if (isset($project_periods))
{
    foreach ($project_periods as $project_period)
    {
        echo '<table>';
        echo '<tbody>';
            echo '<tr>';
                echo '<th class="rivi">' . $this->lang->line('label_period_name') . '</th>';               
                echo '<th class="rivi">' . $this->lang->line('label_period_start_date') . '</th>';            
                echo '<th class="rivi">' . $this->lang->line('label_period_end_date') . '</th>';
                echo '<th class="rivi">' . $this->lang->line('label_period_milestone') . '</th>';
            echo '</tr>';
            echo '<tr>';
                echo '<td class="reuna">' . $project_period->period_name . '</td>';               
                echo '<td class="reuna">' . $project_period->period_start_date . '</td>';                
                echo '<td class="reuna">' . $project_period->period_end_date . '</td>';
                echo '<td class="reuna">' . $project_period->milestone . '</td>';
            echo '</tr>';
        echo '</tbody>';
        echo '</table>';
        
        echo '<table>';
        echo '<tbody>';
            echo '<tr>';
                echo '<th class="reuna">' . $this->lang->line('label_period_description') . '</th>';
            echo '</tr>';
            echo '<tr>';
                echo '<td class="reuna">' . $project_period->period_description . '</td>';
            echo '</tr>';
        echo '</tbody>';
        echo '</table>';
        
        echo '<table>';
        echo '<tbody>';
            echo '<tr>';
                echo '<td class="reuna">' . anchor(
                        'project_period/edit/' . $project_period->id . '/' . $project_period->project_id,
                        $this->lang->line('link_edit')) . '</td>';
                echo '<td class="reuna">';
                    echo form_open('project_period/delete');
                    echo form_hidden('txt_id', set_value('id', $project_period->id));
                    echo form_hidden('txt_projectid', set_value('project_id', $project_period->project_id));                          
                    echo '<input type="submit" value="X" onclick="return deleteconfirm();" />';
                    echo form_close();
                echo '</td>';
                echo '<td class="reuna">' . anchor('task/index/' . $project_period->project_id . '/' . $project_period->id,
                        $this->lang->line('tasks')) . '</td>';
            echo '</tr>';
        echo '</tbody>';
        echo '</table>';        
    }
}
?>

<?php 
// printing the error message if exists
if ($error_message != '')
{
    echo '<h4>' . $heading . '</h4>';
    echo '<p>' . $error_message . '</p>';
}
?>