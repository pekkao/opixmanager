<?php
/**
 * Contact person view to be used to insert and update a contact person.
 * 
 * @param $data = array(
 *               'id' => $contact_person[0]->id,
 *               'surname' => $contact_person[0]->surname,
 *               'firstname' => $contact_person[0]->firstname,
 *               'title' => $contact_person[0]->title,
 *               'phonenumber' => $contact_person[0]->phonenumber,
 *               'email' => $contact_person[0]->email,
 *               'customerid' => $contact_person[0]->customerid,
 *               'customer_name' => $contact_person[0]->customer_name
 *           );
 * 
 * @param $data['pagetitle'] Title and heading of the page
 * @param $data['add'] Hide or show the Reset button (false/true).
 * @param $data['customers] Data for dropdownlistbox
 */
?>

<h1><?php echo $pagetitle ?></h1>

<?php
echo form_open('contact_person/save');
echo form_fieldset();

echo form_hidden('txt_id', set_value('id', $id));

echo form_label($this->lang->line('label_contact_surname'), 'txt_surname');
$data = array(
    'name' => 'txt_surname',
    'id' => 'txt_surname',
    'value' => set_value('txt_surname', $surname),
    'maxlength' => '100',
    'size' => '50',
    'type' =>'text'
);
echo form_input($data);
echo form_error('txt_surname');
echo br(1);

echo form_label($this->lang->line('label_contact_firstname'), 'txt_firstname');
$data = array(
    'name' => 'txt_firstname',
    'id' => 'txt_firstname',
    'value' => set_value('txt_firstname', $firstname),
    'maxlength' => '100',
    'size' => '50',
    'type' => 'text'
);
echo form_input($data);
echo form_error('txt_firstname');
echo br(1);

echo form_label($this->lang->line('label_contact_title'), 'txt_title');
$data = array(
    'name' => 'txt_title',
    'id' => 'txt_title',
    'value' => set_value('txt_title', $title),
    'maxlength' => '100',
    'size' => '50',
    'type' => 'text'
);
echo form_input($data);
echo form_error('txt_title');
echo br(1);

echo form_label($this->lang->line('label_contact_phonenumber'), 'tel_phonenumber');
$data = array(
    'name' => 'tel_phonenumber',
    'id' => 'tel_phonenumber',
    'value' => set_value('tel_phonenumber', $phone_number),
    'maxlength' => '50',
    'size' => '50',
    'type' => 'text'
);
echo form_input($data);
echo form_error('tel_phonenumber');
echo br(1);

echo form_label($this->lang->line('label_contact_email'), 'eml_email');
$data = array(
    'name' => 'eml_email',
    'id' => 'eml_email',
    'value' => set_value('eml_email', $email),
    'maxlength' => '100',
    'size' => '50',
    'type' => 'email'
);
echo form_input($data);
echo form_error('eml_email');
echo br(1); // four lines to get the droplistbox in right place

//if ($customers != null && $add == FALSE)
if (empty($customer_name))
{
    echo br(3); // four lines to get the droplistbox in right place
    echo form_label($this->lang->line('label_customer_name'), 'ddl_customer');
    echo form_dropdown('ddl_customer', $customers, $customer_id);
}
else
{    
    echo form_hidden('ddl_customer', set_value('customer_id', $customer_id));
    echo form_label($this->lang->line('label_customer_name'), 'ddl_customer'); 
        $data = array(
        'class' => 'sameline'
    );
    echo form_label($customer_name, 'customer', $data);
}
echo br(2);

echo '<p>';
echo form_submit('btn_submit', $this->lang->line('button_save'),'class="newline"');
if ($add == TRUE)
{
    echo '<input type="button" value="' . $this->lang->line('button_reset') .
            '" onclick="location.href=' . "'" . base_url() . 'index.php/contact_person/add/' .
            $customer_id . "'" . '" />';
}

echo anchor('contact_person/index/' . $customer_id, $this->lang->line('link_return'), 'class="returnlink"' );
echo '</p>';
echo form_fieldset_close();
echo form_close();

?>

