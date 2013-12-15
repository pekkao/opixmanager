<?php

/**
 * Product_backlog_view to be used to insert and update a product_backlog.
 * 
 * @param $data = array(
 *               'id' => $product_backlog[0]->id,
 *               'backlog_name' => $product_backlog[0]->backlog_name,
 *               'product_visio' => $product_backlog[0]->product_visio
 *               'product_current_state' => $product_backlog[0]->product_current_state,
 *               'product_owner' => $product_backlog[0]->product_owner,
 *              );
 * 
 * @param $data['pagetitle'] Title and heading of the page
 * @param $data['add'] Hide or show the Reset button (false/true).
 *
 */

?>
<h1><?php echo $pagetitle ?></h1>

<?php
echo form_open('product_backlog/save');
echo form_fieldset();

echo form_hidden('txt_id', set_value('id', $id));
echo form_hidden('txt_project_id', set_value('id', $project_id));

echo form_label($this->lang->line('label_backlog_name'), 'txt_backlog_name');

$data = array(
    'name' => 'txt_backlog_name',
    'id' => 'txt_backlog_name',
    'value' => set_value('txt_backlog_name', $backlog_name),
    'maxlength' => '100',
    'size' => '50',
    'type' =>'text'
);

echo form_input($data);
echo form_error('txt_backlog_name');
echo br(2);

echo form_label($this->lang->line('label_product_visio'), 'txt_product_visio');

$data = array(
    'name' => 'txt_product_visio',
    'id' => 'txt_product_visio',
    'value' => set_value('txt_product_visio', $product_visio),
    'maxlength' => '100',
    'size' => '50',
    'type' => 'text'
);

echo form_textarea($data);
echo form_error('txt_product_visio');
echo br(2);

echo form_label($this->lang->line('label_product_current_state'), 'txt_product_current_state');

$data = array(
    'name' => 'txt_product_current_state',
    'id' => 'txt_product_current_state',
    'value' => set_value('txt_product_current_state', $product_current_state),
    'maxlength' => '100',
    'size' => '50',
    'type' => 'text'
);

echo form_textarea($data);
echo form_error('txt_product_current_state');
echo br(1);

echo form_label($this->lang->line('label_product_owner'), 'ddl_product_owner');
echo form_dropdown('ddl_product_owner', $persons, $product_owner);
echo br(1);

echo '<p>';
echo form_submit('btn_submit', $this->lang->line('button_save'),'class="newline"');

if ($add == TRUE)
{
    echo '<input type="button" value="' . $this->lang->line('button_reset') .
            '" onclick="location.href=' . "'" . base_url() . 'index.php/product_backlog/add/' .
            $project_id . "'" . '" />';
}

echo anchor('product_backlog/index/' . $project_id, $this->lang->line('link_return'), 'class="returnlink"' );
echo '</p>';
echo form_fieldset_close();
echo form_close();

?>
