<?php

/**
 * Task_types_view to be used to show all task types in an html table..
 * 
 * @param $data = array(
 *               'id' => $status[0]->id,
 *               'task_type_name' => $status[0]->task_type_name,
 *               'task_type_description' => $status[0]->task_type_description
 *              );
 * 
 * @param $data['pagetitle'] Title and heading of the page
 * @param $data['add'] Hide or show the Reset button (false/true).
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

<h1><?php echo $pagetitle ?></h1>

<p>
    <?php echo anchor('task_type/add', $this->lang->line('link_add_task_type')) ?>
</p>

<table>
    <thead>
        <tr>
            <?php
            echo '<th>' . $this->lang->line('label_task_type_name') . '</th>';
            echo '<th>' . $this->lang->line('label_task_type_description') . '</th>';
            echo '<th colspan="2"></th>';
            ?>
        </tr>
    </thead>
    <tbody>
        <?php
        if (isset($task_types))
        {
            foreach ($task_types as $task_type) 
            {
                echo '<tr>';
                echo '<td>' . $task_type->task_type_name . '</td>';
                echo '<td>' . $task_type->task_type_description . '</td>';
                echo '<td>' . anchor('task_type/edit/' . $task_type->id,
                        $this->lang->line('link_edit')) . '</td>';
                echo '<td>';
                    echo form_open('task_type/delete');
                    echo form_hidden('txt_id', set_value('id', $task_type->id));
                    echo '<input type="submit" value="X" onclick="return deleteconfirm();" />';
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
