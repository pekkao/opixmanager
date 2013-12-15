<?php
/**
 * Shows selected customer's contacts.
 * @param $data['customer_contacts']
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
                echo '<th>' . $this->lang->line('label_name') . '</th>';
                echo '<th>' . $this->lang->line('label_contact_phonenumber') . '</th>';
                echo '<th>' . $this->lang->line('label_contact_email') . '</th>';
                echo '<th colspan="3"></th>';
                ?>
            </tr>
        </thead>
        <tbody>
            <?php
            if (isset($customer_contacts))
            {
                foreach ($customer_contacts as $customer_contact)
                {
                    echo '<tr>';                   
                    echo '<td>' . $customer_contact['surname'] . ' ' .
                                    $customer_contact['firstname'] . '</td>';
                    echo '<td>' . $customer_contact['phone_number'] . '</td>';  
                    echo '<td>' . $customer_contact['email'] . '</td>';
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
echo anchor('report/choose_customer', $this->lang->line('link_return'), 'class="returnlink"' );

if ($error_message != '')
{
    echo '<h4>' . $heading . '</h4>';
    echo '<p>' . $error_message . '</p>';
} 
?>