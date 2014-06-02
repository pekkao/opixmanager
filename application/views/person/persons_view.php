<?php
/**
 * Persons view to be used to show all persons in an html table.
 * 
 * Show persons and with each person a link to edit and delete a person.
 * 
 * @param $data = array(
 *           'id',
 *           'surname', 
 *           'firstname', 
 *           'title', 
 *           'email', 
 *           'phone_number', 
 *           'user_id,
 *           'password',
 *           'language_id',
 *           'language_long',
 *           'account_type'
 *           );
 * 
 * @param $data['persons'] All customers in an array.
 * @param $data['pagetitle'] Title and heading of the page
 * @param $data['heading'] Heading for the error message.
 * @param $data['error_message'] The error message to be printed.
 * @param $data['login_user_id'] User's login id (session data)
 * @param $data['login_id'] User's id (session data)
 * 
 * @package opix
 * @category View
 * @author Wang Yuqing, Tuukka Kiiskinen, Roni Kokkonen
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
    
    function resetpassword()
    {
        var answer = confirm("Do you want to reset password?")
        var ok = alert('Password reseted!')
        
        if (answer){
            document.messages.submit();
        }
        if (ok){
            document.messages.alert();
        }

        return false;
    }
</script>

<h1><?php echo $pagetitle ?></h1>

<?php echo form_fieldset(); ?>

<h5><?php echo $this->lang->line('title_search_person') ?></h5>
<p class="search_info"><?php  echo $this->lang->line('text_search_person') ?></p>

<?php 
    echo form_open('person/find');
    echo form_label($this->lang->line('title_persons'),'src_search');
    $data=array(
        'name' => 'src_search',
        'id' => 'src_search',
        'value' => set_value('src_search', $surname),
        'maxlength' => '30',
        'size' => '30',
        'type' => 'text'
    );
    echo form_input($data);
    echo form_error('src_search');
    echo br(1);

    echo form_submit('btn_submit', $this->lang->line('button_search'), 'class="newline"');
    echo '<input type="button" value="' . $this->lang->line('button_reset').
            '" onclick="location.href=' . "'" . base_url() .
            'index.php/person/clear' . "'" . '" />';
    echo anchor('person' ,$this->lang->line('link_all_persons'), 'class="returnlink"');
    
    echo form_close();
    echo form_fieldset_close();?>

<p class="add_link"><?php echo anchor('person/add', $this->lang->line('link_add_person')); ?>
</p>
<table>
    <thead>          
        <tr>
            <?php   
            echo '<th>' . $this->lang->line('label_person_surname') . '</th>';
            echo '<th>' . $this->lang->line('label_person_firstname') . '</th>'; 
            echo '<th colspan="6"></th>';
            ?>
        </tr>
    </thead>
    <tbody>
        <?php 
        if (isset($persons))
        {
            foreach ($persons as $person) {
                echo '<tr>';
                echo '<td>' . $person->surname . '</td>';        
                echo '<td>' . $person->firstname . '</td>';                 
                echo '<td>' . anchor('person/edit/' . $person->id, 
                        $this->lang->line('link_edit')) . '</td>';
                echo '<td>';
                echo form_open('person/delete');
                    echo form_hidden('txt_id', set_value('id', $person->id));
                    echo '<input type="submit" value="X" onclick="return deleteconfirm();" />';
                    echo form_close();
                echo '</td>';   
                echo '<td>' . anchor('person/read_project/' . $person->id, 
                        $this->lang->line('link_project')) . '</td>';
                if ($this->session->userdata('account_type') == 1)
                {
                    echo '<td>';
                    echo form_open('person/reset_password');
                    echo form_hidden('txt_id', set_value('id', $person->id));
                    echo '<input type="submit" value="Reset password" onclick="return resetpassword();" />'; 
                    echo form_close();
                    echo '</td>';
                }
                echo '<td><div class="pop-up">'; 
                       echo $this->lang->line('label_person_title') . ': ' . $person->title . '</br>' .
                            $this->lang->line('label_person_email') . ': ' . $person->email . '</br>' .
                            $this->lang->line('label_person_phone_number') . ': ' . $person->phone_number . '</br>' .
                            $this->lang->line('label_person_user_id') . ': ' . $person->user_id . '</br>' .
                            $this->lang->line('label_person_language') . ': ' . $person->language_long . '</br>' .
                            $this->lang->line('label_account_type') . ': ' . Person::toString($person->account_type);
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
if ($error_message != '')
{
    echo '<h4>' . $heading . '</h4>';
    echo '<p>' . $error_message . '</p>';
}
?>