<?php

/**
 * Product_backlogs_view to be used to view product_backlogs.
 * 
 * @param $data = array(
 *               'id',
 *               'product_backlog_name',
 *               'product_visio',
 *               'product_current_state',
 *               'product_owner',
 *               'product_id',
 *               'is_owner'
 *              );
 * 
 * @param $data['pagetitle'] Title and heading of the page
 * @param $data['can_add'] Can user add more product backlogs or not
 * @param $data['login_user_id'] User's login id (session data)
 * @param $data['login_id'] User's id (session data)
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
        if ($currentprojectid > 0){
            echo anchor('product_backlog/add/' . $currentprojectid, $this->lang->line('link_add_product_backlog'));
        }
    }
    ?>
  </p>
    <?php
    if (isset($product_backlogs))
    {
        foreach ($product_backlogs as $product_backlog)
        {
            echo '<table>';
            echo '<tbody>';
                echo '<tr>';
                    echo '<th class="rivi">' . $this->lang->line('label_backlog_name') . '</th>';
                    echo '<td class="rivi">' . $product_backlog['backlog_name'] . '</td>';
                    echo '<th class="rivi">' . $this->lang->line('label_product_owner') . '</th>';
        echo '<td class="rivi">' . $product_backlog['product_owner'] . '</td>';
                echo '</tr>';
            echo '</tbody>';
            echo '</table>';

            echo '<table>';
            echo '<tbody>';
                echo '<tr>';
                    echo '<th class="reuna">' . $this->lang->line('label_product_visio') . '</th>';
                echo '</tr>';

                echo '<tr>';
                    echo '<td class="reuna">' . $product_backlog['product_visio'] . '</td>';
                echo '</tr>'; 

                echo '<tr>';
                    echo '<th class="reuna">' . $this->lang->line('label_product_current_state') . '</th>';
                echo '</tr>';

                echo '<tr>';
                    echo '<td class="reuna">' . $product_backlog['product_current_state'] . '</td>';                       
                echo '</tr>';
            echo '</tbody>';
            echo '</table>';

            echo '<table>';
            echo '<tbody>';
                echo '<tr>';
                    echo '<td class="reuna">';
                    if ($product_backlog['is_owner'] == TRUE)
                    {
                        echo anchor ('product_backlog/edit/' . 
                        $currentprojectid . 
                        '/' . $product_backlog['id'],
                        $this->lang->line('link_edit'));
                    }
                    echo '</td>';
                    echo '<td class="reuna">' . anchor ('product_backlog_item/index/' . 
                        $currentprojectid .
                        '/' . $product_backlog['id'],
                        $this->lang->line('link_product_backlog_item')) . 
                        '</td>';
                    echo '<td class="reuna">' 
                        . anchor ('sprint_backlog/index/' . $currentprojectid . '/' .
                        $product_backlog['id'],
                        $this->lang->line('link_sprint_backlog'))
                        . '</td>';
                    echo '<td class="reuna">';
                        echo form_open('product_backlog/delete');
                        echo form_hidden('txt_project_id', set_value('project_id', $currentprojectid));
                        echo form_hidden('txt_id', set_value('id', $product_backlog['id']));
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
if ($error_message != '')
{
    echo '<h4>' . $heading . '</h4>';
    echo '<p>' . $error_message . '</p>';
}
?>
 

