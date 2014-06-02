<?php
/**
 * Customer view to be used to insert and update a customer.
 * 
 * @param $data = array(
 *               'id',
 *               'customer_name', 
 *               'customer_description',
 *               'street_address', 
 *               'post_code', 
 *               'city', 
 *               'www'
 *           );
 * 
 * @param $data['pagetitle'] Title and heading of the page
 * @param $data['add'] Hide or show the Reset button (false/true).
 * @param $data['login_user_id'] User's login id (session data)
 * @param $data['login_id'] User's id (session data)
 *
 * @package opix
 * @category View
 * @author Liisa Auer, Tuukka Kiiskinen, Roni Kokkonen
 */
?>

<h1><?php echo $pagetitle ?></h1>

<?php
echo form_open('customer/save');
echo form_fieldset();

echo form_hidden('txt_id', set_value('id', $id));

echo form_label($this->lang->line('label_customer_name'), 'txt_customer_name');
$data = array(
    'name' => 'txt_customer_name',
    'id' => 'txt_customer_name',
    'value' => set_value('txt_name', $customer_name),
    'maxlength' => '100',
    'size' => '30',
    'type' => 'text'
);
echo form_input($data);
echo form_error('txt_customer_name');
echo br(1);

echo form_label($this->lang->line('label_address'), 'txt_street_address');
$data = array(
    'name' => 'txt_street_address',
    'id' => 'txt_street_address',
    'value' => set_value('txt_street_address', $street_address),
    'maxlength' => '100',
    'size' => '30',
    'type' => 'text'
);
echo form_input($data);
echo form_error('txt_street_address');
echo br(1);

echo form_label($this->lang->line('label_post_code'), 'txt_post_code');
$data = array(
    'name' => 'txt_post_code',
    'id' => 'txt_post_code',
    'value' => set_value('txt_post_code', $post_code),
    'maxlength' => '10',
    'size' => '9',
    'type' => 'text'
);
echo form_input($data);
echo form_error('txt_post_code');
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
    'name' => 'txt_customer_description',
    'id' => 'txt_customer_description',
    'value' => set_value('txt_customer_description', $customer_description),
    'maxlength' => '100',
    'size' => '50',
    'type' => 'text'
);
echo form_textarea($data);
echo form_error('txt_customer_description');
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

