<?php
/**
 * Customer view to be used to insert and update a customer.
 * 
 * @param $data = array(
 *               'id' => $customer[0]->id,
 *               'customer_name' => $customer[0]->customer_name,
 *               'customer_description' => $customer[0]->customer_description,
 *               'street_address' => $customer[0]->street_address,
 *               'post_code' => $customer[0]->post_code,
 *               'city' => $customer[0]->city,
 *               'www' => $customer[0]->www
 *           );
 * 
 * @param $data['pagetitle'] Title and heading of the page
 * @param $data['add'] Hide or show the Reset button (false/true).
 *
 */
?>

<h1><?php echo $pagetitle ?></h1>

<?php
echo form_open('customer/save');
echo form_fieldset();

echo form_hidden('txt_id', set_value('id', $id));

echo form_label($this->lang->line('label_customer_name'), 'txt_customername');
$data = array(
    'name' => 'txt_customername',
    'id' => 'txt_customername',
    'value' => set_value('txt_name', $customer_name),
    'maxlength' => '100',
    'size' => '30',
    'type' => 'text'
);
echo form_input($data);
echo form_error('txt_customername');
echo br(1);

echo form_label($this->lang->line('label_address'), 'txt_streetaddress');
$data = array(
    'name' => 'txt_streetaddress',
    'id' => 'txt_streetaddress',
    'value' => set_value('txt_streetaddress', $street_address),
    'maxlength' => '100',
    'size' => '30',
    'type' => 'text'
);
echo form_input($data);
echo form_error('txt_streetaddress');
echo br(1);

echo form_label($this->lang->line('label_post_code'), 'txt_postcode');
$data = array(
    'name' => 'txt_postcode',
    'id' => 'txt_postcode',
    'value' => set_value('txt_postcode', $post_code),
    'maxlength' => '10',
    'size' => '9',
    'type' => 'text'
);
echo form_input($data);
echo form_error('txt_postcode');
echo br(1);

echo form_label($this->lang->line('label_city'), 'txt_city');
$data = array(
    'name' => 'txt_city',
    'id' => 'txt_city',
    'value' => set_value('txt_city', $city),
    'maxlength' => '100',
    'size' => '30',
    'type' => 'text'
);
echo form_input($data);
echo form_error('txt_city');
echo br(1);

echo form_label($this->lang->line('label_www'), 'txt_www');
$data = array(
    'name' => 'txt_www',
    'id' => 'txt_www',
    'value' => set_value('txt_www', $www),
    'maxlength' => '100',
    'size' => '30',
    'type' => 'text'
);
echo form_input($data);
echo form_error('txt_www');
echo br(2);

echo form_label($this->lang->line('label_customer_description'), 
        'txt_customerdescription');
echo br(4);
$data = array(
    'name' => 'txt_customerdescription',
    'id' => 'txt_customerdescription',
    'value' => set_value('txt_customerdescription', $customer_description),
    'maxlength' => '100',
    'size' => '50',
    'type' => 'text'
);
echo form_textarea($data);
echo form_error('txt_customerdescription');
echo br(2);

echo '<p>';
echo form_submit('btn_submit', $this->lang->line('button_save'), 'class="newline"');
if ($add == TRUE)
{
    echo '<input type="button" value="' . $this->lang->line('button_reset') .
            '" onclick="location.href=' . "'" . base_url() . 'index.php/customer/add' ."'" . '" />';
}
echo anchor('customer', $this->lang->line('link_return'), 'class="returnlink"' );
echo '</p>';
echo form_fieldset_close();
echo form_close();

?>

