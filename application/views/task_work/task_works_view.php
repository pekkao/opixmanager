<?php

/**
 * task_works_view to be used to view task_works.
 * 
 * @param $data['task_works'] All selected person's task works from the database.
 * 
 * @param $data['pagetitle'] Title and heading of the page
 * @param $data['add'] Hide or show the Reset button (false/true).
 * @author Tuukka Kiiskinen, Roni Kokkonen
 * 
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

<h1><?php echo $pagetitle ?></h1>

<p>
    <?php   
    if ($currentpersonid > 0)
    {
        echo anchor('task_work/add/' . $currentpersonid, $this->lang->line('link_add_task_work'));
    }  
    ?>
  </p>
    <?php
    if (isset($task_works))
    {
        $prev = '';
        foreach ($task_works as $task_work)
        {
            if ($task_work->task_name === $prev)
            {               
                echo '<table>';
                echo '<tbody>';
                    echo '<tr>';
                        echo '<th class="reuna" style="visibility:hidden">' . $task_work->task_name . ': ' . '</th>';
                        echo '<td class="reuna" style="width: 78px">' . $task_work->work_hours . '</td>';                   
                        echo '<td class="reuna">' . $task_work->work_date . '</td>';
                        echo '<td class="reuna">' . anchor ('task_work/edit/' . $currentpersonid . '/' . 
                                $task_work->id,
                                $this->lang->line('link_edit')) . '</td>';
                        echo '<td class="reuna">';
                             echo form_open('task_work/delete');
                             echo form_hidden('txt_person_id', set_value('person_id', $currentpersonid));
                             echo form_hidden('txt_id', set_value('id', $task_work->id));
                             echo '<input type="submit" value = "X" onclick="return deleteconfirm();" />';
                             echo form_close();
                        echo '</td>';
                        echo '<td class="reuna"><div class="pop-up">';
                        echo  $this->lang->line('label_description') . ': ' . 
                                $task_work->description;    
                        echo '</div>'; 
                        echo '<a href="#" class="trigger">' . img('application/img/information.jpg') . '</a>';
                        echo '</td>';
                    echo '</tr>';
                echo '</tbody>';
                echo '</table>';
                $prev = $task_work->task_name;
               
            }
            else
            {
                echo '<table>';
                echo '<tbody>';
                    echo '<tr>';
                        echo '<th class="rivi">' . $task_work->task_name . ': ' . '</th>';
                        echo '<th class="rivi">' . $this->lang->line('label_work_hours') . '</th>';                        
                        echo '<th class="rivi">' . $this->lang->line('label_work_date') . '</th>';                        
                    echo '</tr>';

                    echo '<tr>';
                        echo '<td class="reuna">' . '</td>';
                        echo '<td class="reuna">' . $task_work->work_hours . '</td>';
                        echo '<td class="reuna">' . $task_work->work_date . '</td>';
                        echo '<td class="reuna">' . anchor ('task_work/edit/' . $currentpersonid . '/' . 
                                $task_work->id,
                                $this->lang->line('link_edit')) . '</td>';
                        echo '<td class="reuna">';
                             echo form_open('task_work/delete');
                             echo form_hidden('txt_person_id', set_value('person_id', $currentpersonid));
                             echo form_hidden('txt_id', set_value('id', $task_work->id));
                             echo '<input type="submit" value = "X" onclick="return deleteconfirm();" />';
                             echo form_close();
                             echo '<td class="reuna"><div class="pop-up">';
                             echo  $this->lang->line('label_description') . ': ' . 
                                    $task_work->description;    
                             echo '</div>'; 
                             echo '<a href="#" class="trigger">' . img('application/img/information.jpg') . '</a>';
                             echo '</td>';
                             echo '</td>';
                    echo '</tr>';
                echo '</tbody>';
                echo '</table>';                                      
                $prev = $task_work->task_name;          
            }
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