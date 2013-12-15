<?php

/**
 * Sprint_backlogs_view to be used to insert and update sprint_backlogs.
 * 
 * @param $data = array(
                'id'         => $product_backlog[0]->id,
                'backlog_name'    => $product_backlog[0]->backlog_name,
                'product_visio'  => $product_backlog[0]->product_visio,
                'product_current_state' => $product_backlog[0]->product_current_state,
                'product_owner'      => $product_backlog[0]->product_owner,
                'project_id'      => $product_backlog[0]->project_id,                 
            );
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
                    echo '<td class="reuna">' . anchor ('sprint_backlog/edit/' . 
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
 

