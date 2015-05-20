<?php
/**
 * Person view to be used to insert and update a person.
 * 
 * @param $data = array(
 *               'id', 
 *               'surname',
 *               'firstname',
 *               'title',
 *               'email',
 *               'phone_number',
 *               'user_id',
 *               'password',
 *               'language_id',
 *               'account_type',
 *               'confirm_password'
 * );
 * 
 * $data['languages'] Languages (array) for the dropdown listbox
 * @param $data['pagetitle'] Title and heading of the page
 * @param $data['add'] Hide or show the Reset button (false/true).
 * @param $data['login_user_id'] User's login id (session data)
 * @param $data['login_id'] User's id (session data)
 * 
 * @package opix
 * @category View
 * @author Wang Yuqing, Tuukka Kiiskinen, Roni Kokkonen
 *
 */
?>
<h1><?php echo $pagetitle ?></h1>

<?php 
    echo form_open('person/save');
    echo form_fieldset();
    
    echo form_hidden('txt_id', set_value('id', $id));
    echo form_hidden('txt_account_type', set_value('account_type', $this->session->userdata('account_type')));
    
    echo form_label('<p><span class="label label-success">Surname: </span></p>',$this->lang->line('label_person_surname'), 'txt_surname');
        $data = array(
        'name' => 'txt_surname',
        'id' => 'txt_surname',
        'value' => set_value('txt_surname', $surname),
        'maxlength' => '100',
        'size' => '30',
        'type' => 'text',
        'class' => "form-control" 
        );
    echo form_input($data);
    echo form_error('txt_surname');
    echo br(1);
    
    echo form_label('<p><span class="label label-success">Firstname: </span></p>',$this->lang->line('label_person_firstname'), 'txt_firstname');
    $data = array(
    'name' => 'txt_firstname',
    'id' => 'txt_firstname',
    'value' => set_value('txt_firstname', $firstname),
    'maxlength' => '100',
    'size' => '30',
    'type' => 'text',
    'class' => "form-control" 
    );
    echo form_input($data);
    echo form_error('txt_firstname');
    echo br(1);
    
    echo form_label('<p><span class="label label-success">Title: </span></p>',$this->lang->line('label_person_title'), 'txt_title');
        $data = array(
        'name' => 'txt_title',
        'id' => 'txt_title',
        'value' => set_value('txt_title', $title),
        'maxlength' => '100',
        'size' => '30',
        'type' => 'text',
        'class' => "form-control" 
        );
    echo form_input($data);
    echo form_error('txt_title');
    echo br(1);
    
    echo form_label('<p><span class="label label-success">Email: </span></p>',$this->lang->line('label_person_email'), 'eml_email');
        $data = array(
        'name' => 'eml_email',
        'id' => 'eml_email',
        'value' => set_value('txt_email', $email),
        'maxlength' => '100',
        'size' => '30',
        'type' => 'email',
        'class' => "form-control" 
        );
    echo form_input($data);
    echo form_error('eml_email');
    echo br(1);
    
    echo form_label('<p><span class="label label-success">Phone Number: </span></p>',$this->lang->line('label_person_phone_number'), 'tel_phone_number');
        $data = array(
        'name' => 'tel_phone_number',
        'id' => 'tel_phone_number',
        'value' => set_value('tel_phone_number', $phone_number),
        'maxlength' => '100',
        'size' => '30',
        'type'=> 'text',
        'class' => "form-control" 
        );
    echo form_input($data);
    echo form_error('tel_phone_number');
    echo br(1);
    
    echo form_label('<p><span class="label label-success">User ID: </span></p>',$this->lang->line('label_person_user_id'), 'txt_user_id');
        $data = array(
        'name' => 'txt_user_id',
        'id' => 'txt_user_id',
        'value' => set_value('txt_user_id', $user_id),
        'maxlength' => '100',
        'size' => '30',
        'type'=> 'text',
        'class' => "form-control" 
        );
    echo form_input($data);
    echo form_error('txt_user_id');
    echo br(1);
    
    if ($add == TRUE)
    {
        echo form_label('<p><span class="label label-success">Passwords: </span></p>',$this->lang->line('label_person_password'), 'pwd_password');
        $data = array(
        'name' => 'pwd_password',
        'id' => 'pwd_password',
        'value' => set_value('pwd_password', $password),
        'maxlength' => '100',
        'size' => '20',
        'type'=> 'password',
        'class' => "form-control"
    );
    echo form_input($data);
    echo form_error('pwd_password');
    echo br(1);
    }
    if ($add == TRUE)
    {
        echo form_label('<p><span class="label label-success">Confirm Password: </span></p>',$this->lang->line('label_confirm_password'), 'pwd_confirm_password');
        $data = array(
        'name' => 'pwd_confirm_password',
        'id' => 'pwd_confirm_password',
        'value' => set_value('pwd_confirm_password', $confirm_password),
        'maxlength' => '100',
        'size' => '20',
        'type'=> 'password',
        'class' => "form-control"
    );
    echo form_input($data);
    echo form_error('pwd_confirm_password');
    echo br(1);
    }
    
    echo form_label('<p><span class="label label-success">Language: </span></p>',$this->lang->line('label_person_language'), 'ddl_language');
    echo'<br/>';
    echo form_dropdown('ddl_language', $languages, $language_id); 
    echo form_error('ddl_language');
    echo br(1);
    echo'<br/>';
    
if ($add == TRUE)
{
    echo form_label('<p><span class="label label-success">Account Type: </span></p>',$this->lang->line('label_account_type'), 'rdo_account_type');
     echo'<br/>';
    echo form_label(Person::toString(Person::MEMBER));
    echo form_radio('rdo_account_type', Person::MEMBER, TRUE);
    echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp';
    echo form_label(Person::toString(Person::ADMIN));
    echo form_radio('rdo_account_type', Person::ADMIN);
    echo form_error('rdo_account_type');
    echo br(1); 
}

else
{
    if ($this->session->userdata('account_type') == 1)
    {
        echo form_label('<p><span class="label label-success">Account Type: </span></p>',$this->lang->line('label_account_type'), 'rdo_account_type'); 
        echo'<br/>';
        if ($account_type == Person::MEMBER)
        {
            echo form_label(Person::toString(Person::MEMBER));
            echo form_radio('rdo_account_type', Person::MEMBER, Person::SELECTED);
            echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp';
            echo form_label(Person::toString(Person::ADMIN));
            echo form_radio('rdo_account_type', Person::ADMIN);
        }

        else
        {
            echo form_label(Person::toString(Person::MEMBER));
            echo form_radio('rdo_account_type', Person::MEMBER);
            echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp';
            echo form_label(Person::toString(Person::ADMIN));
            echo form_radio('rdo_account_type', Person::ADMIN, Person::SELECTED);
        }
    }
    else
    {
        if ($account_type == Person::MEMBER)
        {
            echo form_hidden('rdo_account_type', Person::MEMBER, Person::SELECTED);
        }
        else
        {
            echo form_hidden('rdo_account_type', Person::ADMIN, Person::SELECTED);
        }
    }
echo br(1);
}
    
    echo '<p>';
    echo'<br/>';
    echo form_submit('btn_submit', $this->lang->line('button_save'), 'class="btn btn-primary"');
    
    if ($add == TRUE)
    {
        echo '<input type="button" value="' . $this->lang->line('button_reset') .
            '" onclick="location.href=' . "'" . base_url() . 'index.php/person/add' ."'" . '" />';
    }
    if ($this->session->userdata('account_type') == 1)
    {
        echo anchor('person', $this->lang->line('link_return'), 'class="returnlink"' );
    }
    else
    {
         echo anchor('home', $this->lang->line('link_return'), 'class="returnlink"' );   
    }
    
    echo '</p>';
    echo form_fieldset_close();
    echo form_close();
?>
