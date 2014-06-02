<?php

/**
 * Sprint_backlog_items_view to list sprint_backlog_items.
 * 
 * @param $data['project_id'] Selected project
 * @param $data['sprint_backlog_id'] Selected sprint backlog
 * @param $data['sprint_backlog_items'] Items in a selected sprint backlog
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
       $(document).ready(function() {
        //If Javascript is running, change css on product-description to display:block
        //then hide the div, ready to animate
        $("div.pop-up").css({'display':'block','opacity':'0'})
      });
      
      $(document).ready(function() {
        $("a.trigger").hover(
          function () {
            $(this).prev().stop().animate({
              opacity: 1
            }, 500);
          },
          function () {
            $(this).prev().stop().animate({
              opacity: 0
            }, 200);
          }
        )
      });
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
echo '</p>';
?>

<h1><?php echo $pagetitle ?></h1>

<p>
    <?php   
    if ($sprint_backlog_id > 0)
    {
        echo '<p>' . anchor('sprint_backlog_item/add/' . $sprint_backlog_id . '/' . $product_backlog_id . '/' . $project_id, 
                $this->lang->line('link_add_sprint_backlog_item') . ' ') . '</p>';
    }
    ?>
  </p>
    <?php
    if (isset($sprint_backlog_items))
    {
        foreach ($sprint_backlog_items as $sprint_backlog_item)
        {
            echo '<table>';
            echo '<tbody>';
                echo '<tr>';
                    echo '<th class="rivi">' . $this->lang->line('label_item_name') . '</th>';
                    echo '<td class="rivi">' . $sprint_backlog_item->item_name . '</td>';
                echo '</tr>';                  
            echo '</tbody>';
            echo '</table>';

            echo '<table>';
            echo '<tbody>';
                echo '<tr>';
                    echo '<th class="reuna">' . $this->lang->line('label_item_description') . '</th>';
                echo '</tr>';

                echo '<tr>';
                    echo '<td class="reuna">' . $sprint_backlog_item->item_description . '</td>';
                echo '</tr>';
            echo '</tbody>';
            echo '</table>';

            echo '<table>';
            echo '<tbody>';
                echo '<tr>';
                    echo '<td class="reuna">';
                         echo form_open('sprint_backlog_item/delete');
                         echo form_hidden('txt_sprint_backlog_id', set_value('sprint_backlog_id',
                                 $sprint_backlog_id));
                         echo form_hidden('txt_project_id', set_value('project_id', $project_id));
                         echo form_hidden('txt_id', set_value('id', $sprint_backlog_item->id));
                         echo '<input type="submit" value = "X" onclick="return deleteconfirm();" />';
                         echo form_close();
                    echo '</td>';
                    echo '<td class="reuna">' . anchor ('sprint_task/index/' . $project_id . '/' .
                            $sprint_backlog_item->id,
                            $this->lang->line('link_sprint_task')) . 
                            '</td>';
                    echo '<td class="reuna"><div class="pop-up">';
                    echo $this->lang->line('label_priority') . ': ' .
                            $sprint_backlog_item->priority . '</br>' .
                            $this->lang->line('label_business_value') . ': ' .
                            $sprint_backlog_item->business_value . '</br>' .
                            $this->lang->line('label_estimate_points') . ': ' .
                            $sprint_backlog_item->estimate_points . '</br>' .
                            $this->lang->line('label_effort_estimate_hours') . ': ' .
                            $sprint_backlog_item->effort_estimate_hours . '</br>' .
                            $this->lang->line('label_acceptance_criteria') . ': ' .
                            $sprint_backlog_item->acceptance_criteria . '</br>' .
                            $this->lang->line('label_release_target') . ': ' .
                            $sprint_backlog_item->release_target;
                    echo '</div>';
                    echo '<a href="#" class="trigger">' . 
                        img('application/img/information.jpg') . '</a>';
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