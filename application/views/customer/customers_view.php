<?php
/**
 * Customers view to be used to show all customers in an html table.
 * 
 * Show customers and with each customer a link to edit and delete a customer.
 * 
 * @param $data = array(
 *           'id' => '',
 *           'customer_name' => '',
 *           'customer_description' => '',
 *           'street_address' => '',
 *           'post_code' => '',
 *           'city' => '',
 *           'www' => ''
 *           );
 * @param $data['customers'] All customers in an array.
 * @param $data['pagetitle'] Title and heading of the page
 * @param $data['heading'] Heading for the error message.
 * @param $data['error_message'] The error message to be printed.
 
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

<?php echo form_fieldset(); ?>

<h5><?php echo $this->lang->line('title_search_customer') ?></h5>
<p class="search_info"><?php echo $this->lang->line('text_search_customer') ?></p>

<?php 
echo form_open("customer/find");

echo form_label($this->lang->line('label_customer_name'), 'src_search');
$data = array(
    'name' => 'src_search',
    'id' => 'src_search',
    'value' => set_value('src_search', $customer_name),
    'maxlength' => '50',
    'size' => '20',
    'type' => 'text'
);
echo form_input($data);
echo form_error('src_search');
echo br(1);

echo form_submit('btnSubmit', $this->lang->line('button_search'), 'class="newline"');
echo '<input type="button" value="' . $this->lang->line('button_reset') .
            '" onclick="location.href=' . "'" . base_url() .
            'index.php/customer/clear' . "'" . '" />';
echo anchor('customer', $this->lang->line('link_all'), 'class="returnlink"');

echo form_close();
echo form_fieldset_close();?>


<p class="add_link">
<?php echo anchor('customer/add', $this->lang->line('link_add_customer')) ?>
</p>
<table>
    <thead>     
        <tr>
            <?php
            echo '<th>' . $this->lang->line('label_customer_name') . '</th>';         
            echo '<th colspan="4"></th>';
            ?>
        </tr>
    </thead>
    <tbody>
        <?php         
        if (isset($customers)) {
            foreach ($customers as $customer) {
                echo '<tr>';                
                echo '<td>' . $customer->customer_name . '</td>';
                echo '<td>' . anchor('customer/edit/' . $customer->id, 
                        $this->lang->line('link_edit')) . '</td>';
                echo '<td>';
                    echo form_open('customer/delete');
                    echo form_hidden('txt_id', set_value('id', $customer->id));
                    echo '<input type="submit" value="X" onclick="return deleteconfirm();" />';
                    echo form_close();
                echo '</td>';
                echo '<td>' . anchor('contact_person/index/' . $customer->id, 
                        $this->lang->line('link_contacts')) . '</td>';
                echo '<td><div class="pop-up">';
                    echo 
                         $customer->street_address . ' ' . '</br>' .
                         $customer->post_code . ' ' .
                         $customer->city . '</br>' . 
                         $customer->www . '</br>' .
                         $this->lang->line('label_customer_description') . ': ' . $customer->customer_description;    
                echo '</div>'; 
                echo '<a href="#" class="trigger">' . img('application/img/information.jpg') . '</a>';
                echo '</td>';
                echo '<td>';                
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