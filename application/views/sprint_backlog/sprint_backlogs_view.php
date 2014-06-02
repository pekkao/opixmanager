<?php

/**
 * Sprint_backlogs_view to list sprint_backlogs.
 * 
 * @param $data['sprint_bacglogs'] Sprint backlogs of a selected product backlog data
 * @param $data['currentproductbacklogid'] Selected product backlog id
 * @param $data['productbacklog'] Selected product backlog data
 * @param $data['project_id'] Selected product
 * @param $data['pagetitle'] Title and heading of the page
 * @param $data['heading'] Heading for the error message.
 * @param $data['error_message'] The error message to be printed.
 * @param $data['login_user_id'] User's login id (session data)
 * @param $data['login_id'] User's id (session data)
 * 
 * @package opix
 * @category View 
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
echo '<p class="polku">' . anchor('product_backlog/index/' . $project_id, $this->lang->line('link_product_backlog')) . '</p>';
?>

<h1><?php echo $pagetitle ?></h1>

<p>
    <?php   
    if ($currentproductbacklogid > 0){
        echo anchor('sprint_backlog/add/' . $project_id . '/' . $currentproductbacklogid, $this->lang->line('link_add_sprint_backlog'));
    }  
    ?>
  </p>
    <?php
    if (isset($sprint_backlogs))
    {
        foreach ($sprint_backlogs as $sprint_backlog)
        {
            echo '<table>';
            echo '<tbody>';
                echo '<tr>';
                    echo '<th class="rivi">' . $this->lang->line('label_sprint_name') . '</th>';
                    echo '<td class="rivi">' . $sprint_backlog->sprint_name . '</td>';
                    echo '<th class="rivi">' . $this->lang->line('label_start_date') . '</th>';
                    echo '<td class="rivi">' . $sprint_backlog->start_date . '</td>';
                    echo '<th class="rivi">' . $this->lang->line('label_end_date') . '</th>';
                    echo '<td class="rivi">' . $sprint_backlog->end_date . '</td>';
                echo '<tr>';
            echo '</tbody>';
            echo '</table>';                   

            echo '<table>';
            echo '<tbody>';
                echo '<tr>';
                    echo '<th class="reuna" colspan="6">' . $this->lang->line('label_sprint_description') . '</th>';
                echo '</tr>';

                echo '<tr>';
                    echo '<td class="reuna" colspan="6">' . $sprint_backlog->sprint_description . '</td>';
                echo '</tr>';
            echo '</tbody>';
            echo '</table>';

            echo '<table>';
            echo '<tbody>';
                echo '<tr>';                       
                    echo '<td class="reuna">' . anchor ('sprint_backlog/edit/' .  $project_id . '/' .
                            $currentproductbacklogid . 
                            '/' . $sprint_backlog->id,
                            $this->lang->line('link_edit')) . '</td>';
                    echo '<td class="reuna">' . anchor ('sprint_backlog_item/index/' . $project_id . '/' .
                        $sprint_backlog->id,
                        $this->lang->line('link_sprint_backlog_item')) . '</td>';
                    echo '<td class="reuna">';
                        echo form_open('sprint_backlog/delete');
                        echo form_hidden('txt_product_backlog_id', set_value('product_backlog_id',
                        $currentproductbacklogid));
                        echo form_hidden('txt_project_id', set_value('project_id', $project_id));
                        echo form_hidden('txt_id', set_value('id', $sprint_backlog->id));
                        echo '<input type="submit" value = "X" onclick="return deleteconfirm();" />';
                    echo form_close() . '</td>';
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
 

