<?php
/**
 * Shows all projects and persons.
 * @param $data['project_persons']
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
                echo '<th>' . $this->lang->line('label_project_name') . '</th>';
                echo '<th>' . $this->lang->line('label_project_start_date') . '</th>';
                echo '<th>' . $this->lang->line('label_project_end_date') . '</th>';
                echo '<th>' . $this->lang->line('label_project_type') . '</th>';
                echo '<th>' . $this->lang->line('label_active') . '</th>';
                echo '<th>' . $this->lang->line('label_person_name') . '</th>';
                echo '<th>' . $this->lang->line('label_role_name') . '</th>';
                echo '<th colspan="3"></th>';
                ?>
            </tr>
        </thead>
        <tbody>
            <?php
            if (isset($project_persons))
            {
                $prev = '';
                foreach ($project_persons as $project_person)
                {
                    
                    if ($project_person['project_name'] === $prev)
                    {
                        echo '<tr>';
                            echo '<td class="reuna">' . '</td>';
                            echo '<td class="reuna">' . '</td>';
                            echo '<td class="reuna">' . '</td>';
                            echo '<td class="reuna">' . '</td>';
                            echo '<td class="reuna">' . '</td>';
                            echo '<td class="reuna">' . $project_person['surname'] . ' ' .
                                            $project_person['firstname'] . '</td>';
                            echo '<td class="reuna">' . $project_person['role_name'] . '</td>';                   
                        echo '</tr>';
                        $prev = $project_person['project_name'];
                    }
                    
                    else
                    {
                        echo '<tr>';
                            echo '<td class="rivi">' . $project_person['project_name'] . '</td>';
                            echo '<td class="rivi">' . $project_person['project_start_date'] . '</td>';
                            echo '<td class="rivi">' . $project_person['project_end_date'] . '</td>';
                            echo '<td class="rivi">' . Report::toString($project_person['project_type']) . '</td>';
                            echo '<td class="rivi">' . Report::toString2($project_person['active']) . '</td>';
                            echo '<td class="rivi">' . $project_person['surname'] . ' ' .
                                            $project_person['firstname'] . '</td>';
                            echo '<td class="rivi">' . $project_person['role_name'] . '</td>';                   
                        echo '</tr>';
                        $prev = $project_person['project_name'];
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