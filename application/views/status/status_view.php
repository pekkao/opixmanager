<?php
/**
 * Status_view to be used to insert and update a status.
 * 
 * @param $data = array(
 *               'id' => $status[0]->id,
 *               'status_name' => $status[0]->status_name,
 *               'status_description' => $status[0]->status_description
 *              );
 * 
 * @param $data['pagetitle'] Title and heading of the page
 * @param $data['add'] Hide or show the Reset button (false/true).
 * @param $data['login_user_id'] User's login id (session data)
 * @param $data['login_id'] User's id (session data)
 * 
 * @package opix
 * @category View
 * @author Tuukka Kiiskinen, Roni Kokkonen
 */
?>
<h1>
    <?php echo $pagetitle ?>
</h1>
<?php echo form_open('status/save');
echo form_fieldset();

echo form_hidden('txt_id', set_value('id', $id));

echo form_label($this->lang->line('label_status_name'), 'txt_statusname');

$data = array(
    'name' => 'txt_statusname',
    'id' => 'txt_statusname',
    'value' => set_value('txt_name', $status_name),
    'maxlength' => '100',
    'size' => '50',
    'type' => 'text'
);

echo form_input($data);
echo form_error('txt_statusname');
echo br(1);

echo form_label($this->lang->line('label_status_description'), 'txt_status_description');
echo br(1);

$data = array(
    'name' => 'txt_status_description',
    'id' => 'txt_status_description',
    'value' => set_value('txt_status_description', $status_description),
    'maxlength' => '100',
    'size' => '50',
    'type' => 'text'
);

echo form_textarea($data);
echo br(2);

echo '<p>';
echo form_submit('btn_submit', $this->lang->line('button_save'), 'class = "newline"');

if ($add == TRUE)
{
    echo '<input type="button" value="' . $this->lang->line('button_reset').
            '" onclick="location.href=' . "'" . base_url() .
            'index.php/status/add' . "'" . '" />';
}

echo anchor('status', $this->lang->line('link_return'), 'class="returnlink"');
echo '</p>';
echo form_fieldset_close();
echo form_close();

?>
