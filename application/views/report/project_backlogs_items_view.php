<?php
/**
 * Shows selected project's product backlogs and backlog items.
 * @param $data['ppbis']
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
if (isset($ppbis))
{
    $prev = '';
    foreach ($ppbis as $ppbi)
    {                                     
        if ($ppbi['backlog_name'] === $prev)
        {
            echo '<table>';
            echo '<tbody>';
                echo '<tr>';
                    echo '<th class="reunaa">' . $this->lang->line('label_item_name') . '</th>';
                    echo '<th class="reuna">' . $this->lang->line('label_start_date') . '</th>';
                    echo '<th class="reuna">' . $this->lang->line('label_priority') . '</th>';
                    echo '<th class="reuna">' . $this->lang->line('label_business_value') . '</th>';
                    echo '<th class="reuna">' . $this->lang->line('label_estimate_points') . '</th>';
                    echo '<th class="reuna">' . $this->lang->line('label_effort_estimate_hours') . '</th>';                         
                    echo '<th class="reuna">' . $this->lang->line('label_release_target') . '</th>';
                echo '</tr>';

                echo '<tr>'; 
                    echo '<td class="reunaa">' . $ppbi['item_name'] . '</td>';                         
                    echo '<td class="reuna">' . $ppbi['start_date'] . '</td>';
                    echo '<td class="reuna">' . $ppbi['priority'] . '</td>';
                    echo '<td class="reuna">' . $ppbi['business_value'] . '</td>';
                    echo '<td class="reuna">' . $ppbi['estimate_points'] . '</td>';
                    echo '<td class="reuna">' . $ppbi['effort_estimate_hours'] . '</td>';                      
                    echo '<td class="reuna">' . $ppbi['release_target'] . '</td>';
                echo '</tr>';
            echo '</tbody>';
            echo '</table>';
            
            echo '<table>';
            echo '<tbody>';
                echo '<tr>';
                    echo '<th class="reunaa">' . $this->lang->line('label_item_description') . '</th>';
                echo '</tr>';

                echo '<tr>';
                    echo '<td class="reunaa">' . $ppbi['item_description'] . '</td>';
                echo '</tr>';

                echo '<tr>';
                    echo '<th class="reunaa">' . $this->lang->line('label_acceptance_criteria') . '</th>';
                echo '</tr>';

                echo '<tr>';
                    echo '<td class="reunaaa">' . $ppbi['acceptance_criteria'] . '</td>';
                echo '</tr>';
            echo '</tbody>';
            echo '</table>';
            $prev = $ppbi['backlog_name'];
        }

        else
        {
            echo '<table>';
            echo '<tbody>';
                echo '<tr>';
                    echo '<th class="rivi">' . $this->lang->line('label_backlog_name') . '</th>';
                    echo '<td class="rivi">' . $ppbi['backlog_name'] . '</td>';  
                    echo '<th class="rivi">' . $this->lang->line('label_product_owner') . '</th>';
                    echo '<td class="rivi">' . $ppbi['product_owner'] . '</td>'; 
                echo '</tr>';
            echo '</tbody>';
            echo '</table>';
            
            echo '<table>';
            echo '<tbody>';
                echo '<tr>';
                    echo '<th class="reuna">' . $this->lang->line('label_product_visio') . '</th>';
                echo '</tr>';

                echo '<tr>';
                    echo '<td class="reuna">' . $ppbi['product_visio'] . '</td>';
                echo '</tr>';

                echo '<tr>';
                    echo '<th class="reuna">' . $this->lang->line('label_product_current_state') . '</th>';
                echo '</tr>';

                echo '<tr>';
                    echo '<td>' . $ppbi['product_current_state'] . '</td>';
                echo '</tr>';
            echo '</tbody>';
            echo '</table>';
            
            echo '<table>';
            echo '<tbody>';
                echo '<tr>';
                    echo '<th class="reunaa">' . $this->lang->line('label_item_name') . '</th>';
                    echo '<th class="reuna">' . $this->lang->line('label_start_date') . '</th>';
                    echo '<th class="reuna">' . $this->lang->line('label_priority') . '</th>';
                    echo '<th class="reuna">' . $this->lang->line('label_business_value') . '</th>';
                    echo '<th class="reuna">' . $this->lang->line('label_estimate_points') . '</th>';
                    echo '<th class="reuna">' . $this->lang->line('label_effort_estimate_hours') . '</th>';
                    echo '<th class="reuna">' . $this->lang->line('label_release_target') . '</th>';
                echo '</tr>';

                echo '<tr>';
                    echo '<td class="reunaa">' . $ppbi['item_name'] . '</td>'; 
                    echo '<td class="reuna">' . $ppbi['start_date'] . '</td>';
                    echo '<td class="reuna">' . $ppbi['priority'] . '</td>';
                    echo '<td class="reuna">' . $ppbi['business_value'] . '</td>';
                    echo '<td class="reuna">' . $ppbi['estimate_points'] . '</td>';
                    echo '<td class="reuna">' . $ppbi['effort_estimate_hours'] . '</td>';                      
                    echo '<td class="reuna">' . $ppbi['release_target'] . '</td>';
                echo '</tr>';
            echo '</tbody>';
            echo '</table>';
            
            echo '<table>';
            echo '<tbody>';
                echo '<tr>';
                    echo '<th class="reunaa">' . $this->lang->line('label_item_description') . '</th>';
                echo '</tr>';

                echo '<tr>';
                    echo '<td class="reunaa">' . $ppbi['item_description'] . '</td>';
                echo '</tr>';

                echo '<tr>';
                    echo '<th class="reunaa">' . $this->lang->line('label_acceptance_criteria') . '</th>';
                echo '</tr>';

                echo '<tr>';
                    echo '<td class="reunaaa">' . $ppbi['acceptance_criteria'] . '</td>';
                echo '</tr>';
            echo '</tbody>';
            echo '</table>';
            $prev = $ppbi['backlog_name'];
        }                                                                
    }
}
?>
</br>
<input type="button" value="Print" id="1" onclick="printpage()">

<input type="button" value="Back" id="2" onclick="back()">
 
<?php
echo br(1);
echo anchor('report/choose_project', $this->lang->line('link_return'), 'class="returnlink"' );

if ($error_message != '')
{
    echo '<h4>' . $heading . '</h4>';
    echo '<p>' . $error_message . '</p>';
} 
?>