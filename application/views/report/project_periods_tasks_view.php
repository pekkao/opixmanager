<?php
/**
 * Shows selected project's project periods and tasks.
 * @param $data['ppts']
 * @param $data['pagetitle'] Title and heading of the page
 
 * @package opix
 * @category View
 * @author Roni Kokkonen, Tuukka Kiiskinen
 */
?>

<script onload="hide()">
 function printpage()
{
    window.print()
    $("nav").remove()
    $("header").remove()
    document.getElementById("1").style.display='none'
    document.getElementById("2").style.display='block'
}
function back()
{
    document.getElementById("1").style.display='block'
    document.getElementById("2").style.display='none'
    location.reload()
}
function hide()
{
    document.getElementById("2").style.display='none'
}
</script>

<h1><?php echo $pagetitle ?></h1>

  <table>
        <thead>
            <tr>
            </tr>
        </thead>
        <tbody>
            <?php
            if (isset($ppts))
            {
                $prev = '';
                foreach ($ppts as $ppt)
                {                                     
                    if ($ppt['period_name'] === $prev)
                    {
                        echo '<tr>';
                            echo '<th class="reunaa">' . $this->lang->line('label_task_name') . '</th>';
                            echo '<th class="reuna">' . $this->lang->line('label_start_date') . '</th>';
                            echo '<th class="reuna">' . $this->lang->line('label_end_date') . '</th>';
                            echo '<th class="reuna">' . $this->lang->line('label_status_name') . '</th>';
                            echo '<th class="reuna">' . $this->lang->line('label_task_type_name') . '</th>';
                            echo '<th class="reuna">' . $this->lang->line('label_effort_estimate_hours') . '</th>';                         
                        echo '</tr>';
                        
                        echo '<tr>'; 
                            echo '<td class="reunaa">' . $ppt['task_name'] . '</td>';                         
                            echo '<td class="reuna">' . $ppt['task_start_date'] . '</td>';
                            echo '<td class="reuna">' . $ppt['task_end_date'] . '</td>';
                            echo '<td class="reuna">' . $ppt['status_name'] . '</td>';
                            echo '<td class="reuna">' . $ppt['task_type_name'] . '</td>';
                            echo '<td class="reuna">' . $ppt['effort_estimate_hours'] . '</td>';                      
                        echo '</tr>';
                        
                        echo '<tr>';
                            echo '<th class="reunaa" colspan="6">' . $this->lang->line('label_task_description') . '</th>';
                        echo '</tr>';
                        
                        echo '<tr>';
                            echo '<td class="reunaaa" colspan="6">' . $ppt['task_description'] . '</td>';
                        echo '</tr>';

                        $prev = $ppt['period_name'];
                    }
                    
                    else
                    {
                        echo '<tr>';
                            echo '<th class="rivi">' . $this->lang->line('label_period_name') . '</th>';
                            echo '<td class="rivi">' . $ppt['period_name'] . '</td>';  
                            echo '<th class="rivi">' . $this->lang->line('label_start_date') . '</th>';
                            echo '<td class="rivi">' . $ppt['period_start_date'] . '</td>';
                            echo '<th class="rivi">' . $this->lang->line('label_end_date') . '</th>';
                            echo '<td class="rivi">' . $ppt['period_end_date'] . '</td>';
                            echo '<th class="rivi">' . $this->lang->line('label_milestone') . '</th>';
                            echo '<td class="rivi">' . $ppt['milestone'] . '</td>';
                        echo '</tr>';                 
                            
                        echo '<tr>';
                            echo '<th class="reuna" colspan="7">' . $this->lang->line('label_period_description') . '</th>';
                        echo '</tr>';
                        
                        echo '<tr>';
                            echo '<td class="reunaaa" colspan="7">' . $ppt['period_description'] . '</td>';
                        echo '</tr>';                        
                        
                        echo '<tr>';
                            echo '<th class="reunaa">' . $this->lang->line('label_task_name') . '</th>';
                            echo '<th class="reuna">' . $this->lang->line('label_start_date') . '</th>';
                            echo '<th class="reuna">' . $this->lang->line('label_end_date') . '</th>';
                            echo '<th class="reuna">' . $this->lang->line('label_status_name') . '</th>';
                            echo '<th class="reuna">' . $this->lang->line('label_task_type_name') . '</th>';
                            echo '<th class="reuna">' . $this->lang->line('label_effort_estimate_hours') . '</th>';                         
                        echo '</tr>';
                        
                        echo '<tr>'; 
                            echo '<td class="reunaa">' . $ppt['task_name'] . '</td>';                         
                            echo '<td class="reuna">' . $ppt['task_start_date'] . '</td>';
                            echo '<td class="reuna">' . $ppt['task_end_date'] . '</td>';
                            echo '<td class="reuna">' . $ppt['status_name'] . '</td>';
                            echo '<td class="reuna">' . $ppt['task_type_name'] . '</td>';
                            echo '<td class="reuna">' . $ppt['effort_estimate_hours'] . '</td>';                      
                        echo '</tr>';
                        
                        echo '<tr>';
                            echo '<th class="reunaa" colspan="6">' . $this->lang->line('label_task_description') . '</th>';
                        echo '</tr>';
                        
                        echo '<tr>';
                            echo '<td class="reunaaa" colspan="6">' . $ppt['task_description'] . '</td>';
                        echo '</tr>';
                        
                        $prev = $ppt['period_name'];
                    }                                                                
                }
            }
            ?>
        </tbody>
    </table>
</br>
<input type="button" value="Print" id="1" onclick="printpage()">

<input type="button" value="Back" id="2" onclick="back()">
 
<?php
echo br(1);
echo anchor('report/choose_project_period', $this->lang->line('link_return'), 'class="returnlink"' );

if ($error_message != '')
{
    echo '<h4>' . $heading . '</h4>';
    echo '<p>' . $error_message . '</p>';
} 
?>