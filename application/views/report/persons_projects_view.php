<?php
/**
 * Shows all persons and projects.
 * @param $data['person_projects']
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
                <?php
                echo '<th>' . $this->lang->line('label_person_name') . '</th>';
                echo '<th>' . $this->lang->line('label_role_name') . '</th>';
                echo '<th>' . $this->lang->line('label_project_name') . '</th>';
                echo '<th>' . $this->lang->line('label_project_start_date') . '</th>';
                echo '<th>' . $this->lang->line('label_project_end_date') . '</th>';
                echo '<th>' . $this->lang->line('label_project_type') . '</th>';
                echo '<th>' . $this->lang->line('label_active') . '</th>';               
                ?>
            </tr>
        </thead>
        <tbody>
            <?php
            if (isset($person_projects))
            {
                $prev = '';
                foreach ($person_projects as $person_project)
                {
                    
                    
                    if ($person_project['surname'] === $prev)
                    {
                        echo '<tr>';
                        echo '<td class="reuna">' . '</td>';                      
                        echo '<td class="reuna">' . $person_project['role_name'] . '</td>';
                        echo '<td class="reuna">' . $person_project['project_name'] . '</td>';
                        echo '<td class="reuna">' . $person_project['project_start_date'] . '</td>';
                        echo '<td class="reuna">' . $person_project['project_end_date'] . '</td>';
                        echo '<td class="reuna">' . Report::toString($person_project['project_type']) . '</td>';
                        echo '<td class="reuna">' . Report::toString2($person_project['active']) . '</td>'; 
                        $prev = $person_project['surname'];
                        echo '</tr>';
                    }
                    
                    else
                    {
                        echo '<tr>';
                        echo '<td class="rivi">' . $person_project['surname'] . ' ' .
                                    $person_project['firstname'] . '</td>';
                        echo '<td class="rivi">' . $person_project['role_name'] . '</td>';
                        echo '<td class="rivi">' . $person_project['project_name'] . '</td>';
                        echo '<td class="rivi">' . $person_project['project_start_date'] . '</td>';
                        echo '<td class="rivi">' . $person_project['project_end_date'] . '</td>';
                        echo '<td class="rivi">' . Report::toString($person_project['project_type']) . '</td>';
                        echo '<td class="rivi">' . Report::toString2($person_project['active']) . '</td>';                       
                        $prev = $person_project['surname'];
                        echo '</tr>';
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
if ($error_message != '')
{
    echo '<h4>' . $heading . '</h4>';
    echo '<p>' . $error_message . '</p>';
} 
?>