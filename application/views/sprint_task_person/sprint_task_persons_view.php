<?php

/**
 * Sprint_task_persons_view to be used to show all sprint_task_persons in an html table.
 * 
 * @param $data['project_id'] Selected project
 * @param $data['sprint_task_persons'] All sprint_task_persons with estimate hours in an array.
 * @param $data['currentid'] Selected sprint task id
 * @param $data['sprint_backlog_item_id'] Selected sprint backlog item
 * @param $data['sprint_backlog_id'] Selected sprint backlog
 * @param $data['product_backlog_id'] Selected product backlog
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
echo anchor('sprint_backlog_item/index/' . $project_id . '/' . $sprint_backlog_id, $this->lang->line('link_sprint_backlog_item'));
echo ' >> ';
echo anchor('sprint_task/index/' . $project_id . '/' . $sprint_backlog_item_id, $this->lang->line('link_sprint_task'));
echo '</p>';
?>

<h1><?php echo $pagetitle ?></h1>

<p>
    <?php   
    if ($currentid > 0)
    {
        echo '<p>' . anchor('sprint_task_person/add/' . $project_id . '/' . $currentid, $this->lang->line('link_add_sprint_task_person') . ' ') . '</p>';
    }
    ?>
  </p>
  <table>
        <thead>
            <tr>
                <?php
                echo '<th>' . $this->lang->line('label_person_name') . '</th>';
                echo '<th>' . $this->lang->line('label_estimate_work_effort_hours') . '</th>';
                echo '<th colspan="3"></th>';
                ?>
            </tr>
        </thead>
        <tbody>
            <?php
            if (isset($sprint_task_persons))
            {
                foreach ($sprint_task_persons as $sprint_task_person)
                {
                    echo '<tr>';
                    echo '<td>' . $sprint_task_person->surname . 
                            ' ' . $sprint_task_person->firstname . '</td>';
                    echo '<td>' . $sprint_task_person->estimate_work_effort_hours . '</td>';
                    echo '<td>' . anchor ('sprint_task_person/edit/' . $project_id . '/' .  
                                $sprint_task_person->person_id . '/' . 
                            $sprint_task_person->sprint_task_id,
                            $this->lang->line('link_edit')) . '</td>';
                    echo '<td>';
                    echo '<td>';
                         echo form_open('sprint_task_person/delete');
                         echo form_hidden('txt_sprint_task_id', set_value('sprint_task_id',
                                 $currentid));
                         echo form_hidden('txt_project_id', set_value('project_id', $project_id));
                         echo form_hidden('txt_id', set_value('id', $sprint_task_person->id));
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