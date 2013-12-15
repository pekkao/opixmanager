<?php
/**
 * Shows all customers & projects.
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
                echo '<th>' . $this->lang->line('label_customer') . '</th>';
                echo '<th>' . $this->lang->line('label_address') . '</th>';
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
                $prev = '';
                foreach ($customer_projects as $customer_project)
                {
                    if ($customer_project['customer_name'] === $prev)
                    {
                        echo '<tr>';
                            echo '<td class="reuna">' . '</td>';
                            echo '<td class="reuna">' . '</td>';
                            echo '<td class="reuna">' . $customer_project['project_name'] . '</td>';
                            echo '<td class="reuna">' . $customer_project['project_start_date'] . '</td>';
                            echo '<td class="reuna">' . $customer_project['project_end_date'] . '</td>';
                            echo '<td class="reuna">' . Report::toString($customer_project['project_type']) . '</td>';
                            echo '<td class="reuna">' . Report::toString2($customer_project['active']) . '</td>';
                        echo '</tr>';
                        $prev = $customer_project['customer_name'];
                    }
                    else
                    {
                        echo '<tr>';
                            echo '<td class="rivi">' . $customer_project['customer_name'] . '</td>';
                            echo '<td class="rivi">' . $customer_project['street_address'] . ', ' .
                            $customer_project['post_code'] . ' ' . $customer_project['city'] . '</td>';
                            echo '<td class="rivi">' . $customer_project['project_name'] . '</td>';
                            echo '<td class="rivi">' . $customer_project['project_start_date'] . '</td>';
                            echo '<td class="rivi">' . $customer_project['project_end_date'] . '</td>';
                            echo '<td class="rivi">' . Report::toString($customer_project['project_type']) . '</td>';
                            echo '<td class="rivi">' . Report::toString2($customer_project['active']) . '</td>';
                        echo '</tr>';
                        $prev = $customer_project['customer_name'];
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