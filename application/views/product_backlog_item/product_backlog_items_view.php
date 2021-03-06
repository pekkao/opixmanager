<?php

/**
 * Product_backlog__items_view to show items in a selected product backlog.
 * 
 * @param $data = array(
 *               'id',
 *               'item_name',
 *               'item_description',
 *               'priority',
 *               'business_value',
 *               'estimate_points',
 *               'effort_estimate_points',
 *               'acceptance_criteria',
 *               'release_target' 
 *              );
 * 
 * @param $data['product_backlog_items'] Backlog items of a selected product backlog
 * @param $data['pagetitle'] Title and heading of the page
 * @param $data['can_add'] Whether a user can add, edit or delete backlog items.
 * @param $data['login_user_id'] User's login id (session data)
 * @param $data['login_id'] User's id (session data)
 * @param $data['heading'] Heading for the error message.
 * @param $data['error_message'] The error message to be printed.
 * 
 * @package opix
 * @category View
 * @author Wang Yuqing, Tuukka Kiiskinen, Roni Kokkonen
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
    if ($can_add == TRUE)
    {
        if ($project_id > 0)
        {
        echo anchor('product_backlog_item/add/' . $project_id . '/' . $product_backlog_id,
                $this->lang->line('link_add_product_backlog_item'));
        }
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
                    echo '<tr class="success">';
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
                
                if ($can_add == TRUE)
                {    
                echo '<table>';
                echo '<tbody>';
                    echo '<tr>';  
                        echo '<td class="reuna">';
                            echo anchor ('product_backlog_item/edit/' . 
                                $project_id . '/' . $product_backlog_item->id,
                                $this->lang->line('link_edit'));
                        echo  '</td>';
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