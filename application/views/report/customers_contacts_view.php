<?php
/**
 * Shows all customers & contacts.
 * @param $data['customer_persons']
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
                echo '<th>' . $this->lang->line('label_name') . '</th>';
                echo '<th>' . $this->lang->line('label_contact_phonenumber') . '</th>';
                echo '<th>' . $this->lang->line('label_contact_email') . '</th>';
                echo '<th colspan="3"></th>';
                ?>
            </tr>
        </thead>
        <tbody>
            <?php
            if (isset($customer_persons))
            {
                $prev = '';
                foreach ($customer_persons as $customer_person)
                {
                    
                    if ($customer_person['customer_name'] === $prev)
                    {
                        echo '<tr>';
                        echo '<td class="reuna">' . '</td>';
                        echo '<td class="reuna">' . '</td>';
                        echo '<td class="reuna">' . $customer_person['surname'] . ' ' . $customer_person['firstname'] . '</td>';
                        echo '<td class="reuna">' . $customer_person['phone_number'] . '</td>';
                        echo '<td class="reuna">' . $customer_person['email'] . '</td>';                        
                        $prev = $customer_person['customer_name'];
                        echo '</tr>';
                    }
                    else
                    {
                        echo '<tr>';
                        echo '<td class="rivi">' . $customer_person['customer_name'] . '</td>';
                        echo '<td class="rivi">' . $customer_person['street_address'] . ', ' .
                        $customer_person['post_code'] . ' ' . $customer_person['city'] . '</td>';
                        echo '<td class="rivi">' . $customer_person['surname'] . ' ' . $customer_person['firstname'] . '</td>';
                        echo '<td class="rivi">' . $customer_person['phone_number'] . '</td>';
                        echo '<td class="rivi">' . $customer_person['email'] . '</td>';                    
                        $prev = $customer_person['customer_name'];
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