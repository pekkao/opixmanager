<?php
/**
 * Contact persons view to be used to show all contact persons in an html table.
 * 
 * Show contact persons and with each contact person a link to edit and delete a contact person.
 * 
 * @param $data = array(
 *           'id',
 *           'surname',
 *           'firstname',
 *           'title',
 *           'phonenumber',
 *           'email',
 *           'customerid',
 *           'customer_name'
 *           );
 * @param $data['contact_persons'] All contact persons in an array.
 * @param $data['pagetitle'] Title and heading of the page
 * @param $data['heading'] Heading for the error message.
 * @param $data['error_message'] The error message to be printed.
 * @param $data['currentcustomerid] The customerid of customer contacts, zero means all contacts.
 * @param $data['login_user_id'] User's login id (session data)
 * @param $data['login_id'] User's id (session data)
 * 
 * @package opix
 * @category View
 * @author Liisa Auer
 */
?>
<script type="text/javascript">
       $(document).ready(function() {
        //If Javascript is running, change css on product-description to display:block
        //then hide the div, ready to animate
        $("div.pop-up").css({'display':'block','opacity':'0'})
      });
      
      $(document).ready(function() {
        $("a.trigger").hover(
          function () {
            $(this).prev().stop().animate({
              opacity: 1
            }, 500);
          },
          function () {
            $(this).prev().stop().animate({
              opacity: 0
            }, 200);
          }
        )
      });
      function deleteconfirm()
    {
        var answer = confirm("Are you sure you want to delete?")
        if (answer){
            document.messages.submit();
        }

        return false;  
    }
</script>

<h1><?php echo $pagetitle ?></h1>

<?php
if ($this->session->userdata('account_type') == 1)
{
    echo '<p>';
     echo anchor('contact_person/add/' . $currentcustomerid , 
            $this->lang->line('link_add_contact_person'));
    echo '</p>';
}
?>
<table>
    <thead>
        <tr>
            <?php
            echo '<th>' . $this->lang->line('label_contact_surname') . '</th>';
            echo '<th>' . $this->lang->line('label_contact_firstname') . '</th>';            
            echo '<th colspan="2"></th>';
            ?>
        </tr>
    </thead>
    <tbody>
        <?php
        if (isset($contact_persons)) {
            foreach ($contact_persons as $contact_person) {
                echo '<tr>';
                echo '<td>' . $contact_person->surname . '</td>';
                echo '<td>' . $contact_person->firstname . '</td>';                               

                echo '<td>';
                if ($this->session->userdata('account_type') == 1)
                {
                    echo anchor(
                        'contact_person/edit/' . $contact_person->id . '/' . $contact_person->customer_id,
                        $this->lang->line('link_edit'));
                    echo '</td>';
                }
                echo '<td>';
                if ($this->session->userdata('account_type') == 1)
                {
                    echo form_open('contact_person/delete');
                    echo form_hidden('txt_id', set_value('id', $contact_person->id));
                    echo form_hidden('txt_customer_id', set_value('customer_id', $contact_person->customer_id));
                    echo '<input type="submit" value="X" onclick="return deleteconfirm();" />';
                    echo form_close();
                }
                echo '</td>';
                echo '<td><div class="pop-up">'; 
                       echo $this->lang->line('label_contact_title') . ': ' . $contact_person->title . '</br>' .
                            $this->lang->line('label_contact_phonenumber') . ': ' . $contact_person->phone_number . '</br>' .
                            $this->lang->line('label_contact_email') . ': ' . $contact_person->email;                       
                echo '</div>';
                echo '<a href="#" class="trigger">' . img('img/information.jpg') . '</a>';
                echo '</td>';                
                echo '</tr>';
            }
        }
        ?>
    </tbody>
</table>

<?php 
// printing the error message if exists
if ($error_message != '')
{
    echo '<h4>' . $heading . '</h4>';
    echo '<p>' . $error_message . '</p>';
}
?>
