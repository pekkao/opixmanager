<?php
/**
 * Person password view to be used to change a person's password.
 * 
 * @param $data = array(
 *           'id' => ''
 *      );
 * 
 * @param $data['pagetitle'] Title and heading of the page
 * @param $data['heading'] Heading for the error message.
 * @param $data['error_message'] The error message to be printed.
 * @param $data['login_user_id'] User's login id (session data)
 * @param $data['login_id'] User's id (session data)
 * 
 * @package opix
 * @category View
 * @author Tuukka Kiiskinen, Roni Kokkonen
 */
?>

<h1><?php echo $pagetitle ?></h1>

<?php 
    echo form_open('person/save_password');
    echo form_fieldset();
    
    echo form_hidden('txt_id', set_value('id', $id));
    
    echo form_label($this->lang->line('label_person_old_password'), 'pwd_old_password');
    $data = array(
    'name' => 'pwd_old_password',
    'id' => 'pwd_old_password',
    'type'=> 'password'
    );
    echo form_input($data);
    echo form_error('pwd_old_password');
    echo br(1);
    
    echo form_label($this->lang->line('label_person_new_password'), 'pwd_new_password');
    $data = array(
    'name' => 'pwd_new_password',
    'id' => 'pwd_new_password',
    'type'=> 'password'
    );
    echo form_input($data);
    echo form_error('pwd_new_password');
    echo br(1);
    
    echo form_label($this->lang->line('label_person_confirm_password'), 'pwd_confirm_password');
    $data = array(
    'name' => 'pwd_confirm_password',
    'id' => 'pwd_confirm_password',
    'type'=> 'password'
    );
    echo form_input($data);
    echo form_error('pwd_confirm_password');
    echo br(1);
    
    echo '<p>';
    echo form_submit('btn_submit', $this->lang->line('button_save'), 'class="newline"');
    echo anchor('home', $this->lang->line('link_return'), 'class="returnlink"' );
    echo '</p>';
    echo form_fieldset_close();
    echo form_close();    
?>

<?php 
if (isset($error_message))
{
    echo '<p>' . $error_message . '</p>';
}
?>
