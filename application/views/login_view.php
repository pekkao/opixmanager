<?php
/**
 * Login view
 * 
 * @param $data = array(
 *           'user_id',
 *           'password',
 *   );
 * @param $data['user_id'] User login id
 * @param $data['password'] User password
 * @param $data['pagetitle'] Title and heading of the page
 * 
 * @package opix
 * @category View
 * @author Roni Kokkonen, Tuukka Kiiskinen
 */
?>
<h1><?php echo $pagetitle ?></h1>

<?php

echo form_fieldset();
echo form_open('verify_login');

echo form_label($this->lang->line('label_user_id'), 'txt_user_id');
$data = array(
    'name' => 'txt_user_id',
    'id' => 'txt_user_id',
    'value' => set_value('txt_user_id'),
    'maxlength' => '100',
    'size' => '20',
    'type' =>'text',
     'class' => "form-control"
);

echo form_input($data);
echo br(1);

echo form_label($this->lang->line('label_password'), 'pwd_password');
$data = array(
    'name' => 'pwd_password',
    'id' => 'pwd_password',
    'value' => set_value('pwd_password', $password),
    'maxlength' => '100',
    'size' => '21',
    'type' =>'password',
    'class' => "form-control"
);

echo form_input($data);
echo br(1);

echo form_submit('btn_submit', $this->lang->line('button_login'),'class="btn btn-primary"');

echo form_close();
echo form_fieldset_close();
echo br(1);
echo validation_errors();
?>
