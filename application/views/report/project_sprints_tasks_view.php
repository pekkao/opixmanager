<?php
/**
 * Shows selected project's sprint backlogs and sprint tasks.
 * @param $data['psts']
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
        </thead>
        <tbody>
            <?php
            if (isset($psts))
            {
                $prev = '';
                foreach ($psts as $pst)
                {
                                       
                    if ($pst['sprint_name'] === $prev)
                    {
                        echo '<tr>';
                            echo '<th class="raporttireuna">' . $this->lang->line('label_task_name') . '</th>';
                            echo '<td class="raporttireuna">' . $pst['task_name'] . '</td>'; 
                            echo '<th class="raporttireuna">' . $this->lang->line('label_effort_estimate_hours') . '</th>';
                            echo '<td class="raporttireuna" colspan="2">' . $pst['effort_estimate_hours'] . '</td>';
                        echo '</tr>';                        
                        
                        echo '<tr>';
                            echo '<th class="raporttireuna" colspan="6">' . $this->lang->line('label_task_description') . '</th>';
                        echo '</tr>';
                        
                        echo '<tr>';
                            echo '<td colspan="6">' . $pst['task_description'] . '</td>'; 
                        echo '</tr>';
                        $prev = $pst['sprint_name'];
                    }
                    
                    else
                    {
                        echo '<tr>';
                            echo '<th class="rivi">' . $this->lang->line('label_sprint_name') . '</th>';
                            echo '<td class="rivi">' . $pst['sprint_name'] . '</td>';
                            echo '<th class="rivi">' . $this->lang->line('label_start_date') . '</th>';
                            echo '<td class="rivi">' . $pst['start_date'] . '</td>';
                            echo '<th class="rivi">' . $this->lang->line('label_end_date') . '</th>';
                            echo '<td class="rivi">' . $pst['end_date'] . '</td>';
                        echo '</tr>';                        
                        
                        echo '<tr>';
                            echo '<th class="raporttireuna" colspan="6">' . $this->lang->line('label_sprint_description') . '</th>';
                        echo '</tr>';
                        
                        echo '<tr>';
                            echo '<td colspan="6">' . $pst['sprint_description'] . '</td>';
                        echo '</tr>';
                        
                        echo '<tr>';
                            echo '<th class="raporttireuna">' . $this->lang->line('label_task_name') . '</th>';
                            echo '<td class="raporttireuna">' . $pst['task_name'] . '</td>';
                            echo '<th class="raporttireuna">' . $this->lang->line('label_effort_estimate_hours') . '</th>';
                            echo '<td class="raporttireuna" colspan="2">' . $pst['effort_estimate_hours'] . '</td>';
                        echo '</tr>';
                        
                        echo '<tr>';
                            echo '<th class="raporttireuna" colspan="6">' . $this->lang->line('label_task_description') . '</th>';
                        echo '</tr>';
                        
                        echo '<tr>';
                            echo '<td colspan="6">' . $pst['task_description'] . '</td>'; 
                        echo '</tr>';
                        
                        $prev = $pst['sprint_name'];
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
echo anchor('report/choose_project_sprint', $this->lang->line('link_return'), 'class="returnlink"' );

if ($error_message != '')
{
    echo '<h4>' . $heading . '</h4>';
    echo '<p>' . $error_message . '</p>';
} 
?>