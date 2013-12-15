<?php

/**
 * Product_backlog__items_view to be used to insert and update product_backlog_items.
 * 
 * @param $data = array(
 *               'id' => $product_backlog[0]->id,
 *               'item_name' => $product_backlog_item[0]->item_name,
 *               'item_description' => $product_backlog_item[0]->item_description,
 *               'item_priority' => $product_backlog_item[0]->item_priority,
 *               'item_business_value' => $product_backlog_item[0]->item_business_value,
 *               'item_estimate_points' => $product_backlog_item[0]->item_estimate_points,
 *               'item_effort_estimate_points' => $product_backlog_item[0]->item_effort_estimate_points,
 *               'item_acceptance_criteria' => $product_backlog_item[0]->item_acceptance_criteria,
 *               'item_release_target' => $product_backlog_item[0]->item_release_target,
 *              );
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

<h1><?php echo $pagetitle ?></h1>

<p>
    <?php 
    if ($project_id > 0)
        {
        echo anchor('product_backlog_item/add/' . $project_id . '/' . $product_backlog_id,
                $this->lang->line('link_add_product_backlog_item'));
        }  
    ?>
</p>
        <?php
        if (isset($product_backlog_items))
        {
            foreach ($product_backlog_items as $product_backlog_item)
            {
                echo '<table>';
                echo '<tbody>';     
                    echo '<tr>';
                        echo '<th class="rivi">' . $this->lang->line('label_item_name') . '</th>';                 
                        echo '<th class="rivi">' . $this->lang->line('label_start_date') . '</th>';
                        echo '<th class="rivi">' . $this->lang->line('label_priority') . '</th>';
                        echo '<th class="rivi">' . $this->lang->line('label_business_value') . '</th>';
                        echo '<th class="rivi">' . $this->lang->line('label_estimate_points') . '</th>';
                        echo '<th class="rivi">' . $this->lang->line('label_effort_estimate_hours') . '</th>';                  
                        echo '<th class="rivi">' . $this->lang->line('label_release_target') . '</th>';
                    echo '</tr>';         

                    echo '<tr>';
                        echo '<td class="reuna">' . $product_backlog_item->item_name . '</td>';            
                        echo '<td class="reuna">' . $product_backlog_item->start_date . '</td>';
                        echo '<td class="reuna">' . $product_backlog_item->priority . '</td>';
                        echo '<td class="reuna">' . $product_backlog_item->business_value . '</td>';
                        echo '<td class="reuna">' . $product_backlog_item->estimate_points . '</td>';
                        echo '<td class="reuna">' . $product_backlog_item->effort_estimate_hours . '</td>';              
                        echo '<td class="reuna">' . $product_backlog_item->release_target . '</td>';
                    echo '</tr>';
                echo '</tbody>';
                echo '</table>';
                
                echo '<table>';
                echo '<tbody>';  
                    echo '<tr>';
                        echo '<th class="reuna">' . $this->lang->line('label_item_description') . '</th>';
                    echo '</tr>';

                    echo '<tr>';
                        echo '<td class="reuna">' . $product_backlog_item->item_description . '</td>';
                    echo '</tr>';

                    echo '<tr>';
                        echo '<th class="reuna">' . $this->lang->line('label_acceptance_criteria') . '</th>';
                    echo '</tr>';

                    echo '<tr>';
                        echo '<td class="reuna">' . $product_backlog_item->acceptance_criteria . '</td>';
                    echo '</tr>';
                echo '</tbody>';
                echo '</table>';
                
                echo '<table>';
                echo '<tbody>';
                    echo '<tr>';  
                        echo '<td class="reuna">' . anchor ('product_backlog_item/edit/' . 
                                $project_id . '/' . $product_backlog_item->id,
                                $this->lang->line('link_edit')) . '</td>';
                        echo '<td class="reuna">';
                             echo form_open('product_backlog_item/delete');
                             echo form_hidden('txt_project_id', 
                                     set_value('project_id', $project_id));
                             echo form_hidden('txt_product_backlog_id', 
                                     set_value('product_backlog_id', $product_backlog_id));
                             echo form_hidden('txt_id', 
                                     set_value('id', $product_backlog_item->id));
                             echo '<input type="submit" value = "X" onclick="return deleteconfirm();" />';
                             echo form_close();
                        echo '</td>';
                    echo '</tr>';
                echo '</tbody>';
                echo '</table>';
            }
        }
        ?>

<?php
echo anchor('product_backlog/index/' . $project_id,  
        $this->lang->line('link_return'), 'class="returnlink"');

echo br(2);

if ($error_message != '')
{
    echo '<h4>' . $heading . '</h4>';
    echo '<p>' . $error_message . '</p>';
}
?>