<?php
/**
 * Shows selected customer's projects.
 * @param $data['customer_projects']
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
                echo '<th colspan="3"></th>';
                ?>
            </tr>
        </thead>
        <tbody>
            <?php
            if (isset($customer_projects))
            {
                foreach ($customer_projects as $customer_project)
                {
                    echo '<tr>';                   
                    echo '<td>' . $customer_project['project_name'] . '</td>';
                    echo '<td>' . $customer_project['project_start_date'] . '</td>';  
                    echo '<td>' . $customer_project['project_end_date'] . '</td>';
                    echo '<td>' . Report::toString($customer_project['project_type']) . '</td>';
                    echo '<td>' . Report::toString2($customer_project['active']) . '</td>';
                    echo '</tr>';
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
echo anchor('report/choose_customer_project', $this->lang->line('link_return'), 'class="returnlink"' );

if ($error_message != '')
{
    echo '<h4>' . $heading . '</h4>';
    echo '<p>' . $error_message . '</p>';
} 
?>