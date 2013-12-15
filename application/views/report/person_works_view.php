<?php
/**
 * Shows selected person's sprint works and task works.
 * @param $data['psws']
 * @param $data['ptws']
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

<?php
if (isset($psws))
{
    echo '<h3>' . $this->lang->line('title_sprint_works') . '</h3>';
    foreach ($psws as $psw)
    {
        echo '<table>';
        echo '<tbody>';
            echo '<tr>';
                echo '<th class="rivi">' . $this->lang->line('label_task_name') . '</th>';
                echo '<td class="rivi">' . $psw['task_name'] . '</td>';
                echo '<th class="rivi">' . $this->lang->line('label_work_done_hours') . '</th>';
                echo '<td class="rivi">' . $psw['work_done_hours'] . '</td>';
                echo '<th class="rivi">' . $this->lang->line('label_work_remaining_hours') . '</th>';
                echo '<td class="rivi">' . $psw['work_remaining_hours'] . '</td>';
            echo '</tr>';
        echo '</tbody>';
        echo '</table>';
        
        echo '<table>';
        echo '<tbody>';
            echo '<tr>';
                echo '<th class="reuna">' . $this->lang->line('label_task_description') . '</th>';
            echo '</tr>';
            
            echo '<tr>';
                echo '<td class="reuna">' . $psw['description'] . '</th>';
            echo '</tr>';
        echo '</tbody>';
        echo '</table>';
    }
}
?>
</br>
<?php
if (isset($ptws))
{
    echo '<h3>' . $this->lang->line('title_task_works') . '</h3>';
    foreach ($ptws as $ptw)
    {
        echo '<table>';
        echo '<tbody>';
            echo '<tr>';
                echo '<th class="rivi">' . $this->lang->line('label_task_name') . '</th>';
                echo '<td class="rivi">' . $ptw['task_name'] . '</td>';
                echo '<th class="rivi">' . $this->lang->line('label_work_hours') . '</th>';
                echo '<td class="rivi">' . $ptw['work_hours'] . '</td>';
                echo '<th class="rivi">' . $this->lang->line('label_work_date') . '</th>';
                echo '<td class="rivi">' . $ptw['work_date'] . '</td>';
            echo '</tr>';
        echo '</tbody>';
        echo '</table>';
        
        echo '<table>';
        echo '<tbody>';
            echo '<tr>';
                echo '<th class="reuna">' . $this->lang->line('label_task_description') . '</th>';
            echo '</tr>';
            
            echo '<tr>';
                echo '<td class="reuna">' . $ptw['description'] . '</th>';
            echo '</tr>';
        echo '</tbody>';
        echo '</table>';
    }
}
?>

</br>
<input type="button" value="Print" id="1" onclick="printpage()">

<input type="button" value="Back" id="2" onclick="back()">
 
<?php 
if ($error_message != '')
{
    echo '<h4>' . $heading . '</h4>';
    echo '<p>' . $error_message . '</p>';
} 
?>