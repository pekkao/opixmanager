<?php

/**
 * Product_backlog__item_view to be used to insert and update a product_backlog_item.
 * 
 * @param $data = array(
 *               'id' => $product_backlog_item[0]->id,
 *               'item_name' => $product_backlog_item[0]->item_name,
 *               'item_description' => $product_backlog_item[0]->item_description,
 *               'item_priority' => $product_backlog_item[0]->item_priority,
 *               'item_business_value' => $product_backlog_item[0]->item_business_value,
 *               'item_estimate_points' => $product_backlog_item[0]->item_estimate_points,
 *               'item_effort_estimate_points' => $product_backlog_item[0]->item_effort_estimate_points,
 *               'item_acceptance_criteria' => $product_backlog_item[0]->item_acceptance_criteria,
 *               'item_release_target' => $product_backlog_item[0]->item_release_target,
 *              );
 * 
 * @param $data['pagetitle'] Title and heading of the page
 * @param $data['add'] Hide or show the Reset button (false/true).
 *
 */

?>

<link rel="stylesheet" href="http://code.jquery.com/ui/1.9.2/themes/base/jquery-ui.css" />
<script src="http://code.jquery.com/jquery-1.8.3.js"></script>
<script src="http://code.jquery.com/ui/1.9.2/jquery-ui.js"></script>
<script> $(function() {
        $( ".datepicker" ).datepicker({
            dateFormat: "yy-mm-dd",
            showOtherMonths: true,
            selectOtherMonths: true,
            showAnim: "slideDown"
        });
    });
</script>

<h1><?php echo $pagetitle ?></h1>

<?php
echo form_open('product_backlog_item/save');
echo form_fieldset();

echo form_hidden('txt_id', set_value('id', $id));
echo form_hidden('txt_product_backlog_id', set_value('product_backlog_id', $product_backlog_id));
echo form_hidden('txt_project_id', set_value('project_id', $project_id));

echo form_label($this->lang->line('label_item_name'), 'txt_item_name');

$data = array(
    'name' => 'txt_item_name',
    'id' => 'txt_item_name',
    'value' => set_value('txt_item_name', $item_name),
    'maxlength' => '100',
    'size' => '50',
    'type' => 'text'
);

echo form_input($data);
echo form_error('txt_item_name');
echo br(1);

echo form_label($this->lang->line('label_item_description'), 'txt_item_description');

$data = array(
    'name' => 'txt_item_description',
    'id' => 'txt_item_description',
    'value' => set_value('txt_item_description', $item_description),
    'maxlength' => '100',
    'size' => '50',
    'type' => 'text'
);

echo br(1);
echo form_textarea($data);
echo form_error('txt_item_description');
echo br(1);

echo form_label($this->lang->line('label_start_date'), 'dtm_start_date');

$data = array(
    'name' => 'dtm_start_date',
    'class' => 'datepicker',
    'value' => set_value('dtm_start_date', $start_date),
    'maxlength' => '100',
    'size' => '10',
    'type' => 'date'
);

echo form_input($data);
echo form_error('dtm_start_date');
echo br(1);

echo form_label($this->lang->line('label_priority'), 'txt_priority');

$data = array(
    'name' => 'txt_priority',
    'id' => 'txt_priority',
    'value' => set_value('txt_priority', $priority),
    'maxlength' => '100',
    'size' => '50',
    'type' => 'text'
);

echo form_input($data);
echo form_error('txt_priority');
echo br(1);

echo form_label($this->lang->line('label_business_value'), 'txt_business_value');

$data = array(
    'name' => 'txt_business_value',
    'id' => 'txt_business_value',
    'value' => set_value('txt_business_value', $business_value),
    'maxlength' => '100',
    'size' => '50',
    'type' => 'text'
);

echo form_input($data);
echo form_error('txt_business_value');
echo br(1);

echo form_label($this->lang->line('label_estimate_points'), 'txt_estimate_points');

$data = array(
    'name' => 'txt_estimate_points',
    'id' => 'txt_estimate_points',
    'value' => set_value('txt_estimate_points', $estimate_points),
    'maxlength' => '100',
    'size' => '50',
    'type' => 'text'
);

echo form_input($data);
echo form_error('txt_estimate_points');
echo br(1);

echo form_label($this->lang->line('label_effort_estimate_hours'), 'txt_effort_estimate_hours');

$data = array(
    'name' => 'txt_effort_estimate_hours',
    'id' => 'txt_effort_estimate_hours',
    'value' => set_value('txt_estimate_points', $effort_estimate_hours),
    'maxlength' => '100',
    'size' => '50',
    'type' => 'text'
);

echo form_input($data);
echo form_error('txt_effort_estimate_hours');
echo br(6);

echo form_label($this->lang->line('label_acceptance_criteria'), 'txt_acceptance_criteria');

$data = array(
    'name' => 'txt_acceptance_criteria',
    'id' => 'txt_acceptance_criteria',
    'value' => set_value('txt_acceptance_criteria', $acceptance_criteria),
    'maxlength' => '100',
    'size' => '50',
    'type' => 'text'
);

echo form_textarea($data);
echo form_error('txt_acceptance_criteria');
echo br(1);

echo form_label($this->lang->line('label_release_target'), 'txt_release_target');

$data = array(
    'name' => 'txt_release_target',
    'id' => 'txt_release_target',
    'value' => set_value('txt_acceptance_criteria', $release_target),
    'maxlength' => '100',
    'size' => '50',
    'type' =>'text'
);

echo form_input($data);
echo form_error('txt_release_target');
echo br(1);

echo form_label($this->lang->line('label_item_type_name'), 'ddl_item_type');
echo form_dropdown('ddl_item_type', $item_types, $item_type_id, 'class="sameline"');
echo br(1);

echo form_label($this->lang->line('label_status'), 'ddl_status');
echo form_dropdown('ddl_status', $status, $status_id, 'class="sameline"');
echo br(1);

echo '<p>';
echo form_submit('btn_submit', $this->lang->line('button_save'), 'class="newline"');

if ($add == TRUE)
{
    echo '<input type="button" value="' . $this->lang->line('button_reset') .
            '" onclick="location.href=' . "'" . base_url() . 'index.php/product_backlog_item/add/' .
            $project_id . '/' . $product_backlog_id . "'" . '" />';
}

echo anchor('product_backlog_item/index/' . $project_id . 
        '/' . $product_backlog_id, 
        $this->lang->line('link_return'), 'class="returnlink"');
echo '</p>';
echo form_fieldset_close();
echo form_close();

?>