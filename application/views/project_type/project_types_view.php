<?php

/**
 * Project_types_view to be used to show all project_types in an html table.
 * 
 * @param $data = array(
 *               'id' => $project_type[0]->id,
 *               'type_name' => $project_type[0]->type_name,
 *               'type_description' => $project_type[0]->type_description
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
    <?php echo anchor('project_type/add', $this->lang->line('link_add_project_type')) ?>
</p>
    <table>
        <thead>
            <tr>
                <?php
                    echo '<th>' . $this->lang->line('label_project_type_name') . '</th>';
                    echo '<th>' . $this->lang->line('label_project_type_description') . '</th>';
                    echo '<th colspan="2"></th>';
                ?>
            </tr>
        </thead>
        <tbody>
            <?php
            if (isset($project_types))
            {
                foreach ($project_types as $project_type)
                {
                    echo '<tr>';
                    echo '<td>' . $project_type->type_name . '</td>';
                    echo '<td>' . $project_type->type_description . '</td>';
                    echo '<td>' . anchor ('project_type/edit/' . $project_type->id,
                            $this->lang->line('link_edit')) . '</td>';
                    echo '<td>';
                         echo form_open('project_type/delete');
                         echo form_hidden('txt_id', set_value('id', $project_type->id));
                         echo '<input type="submit" value = "X" onclick="return deleteconfirm();" />' ;
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


