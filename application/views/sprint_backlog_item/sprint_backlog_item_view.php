<?php
/**
 *  Add Sprint backlog item view to be used to add a sprint backlog item in an html table.
 * 
 * @param  $data = array(
            'id' => '',
            'sprint_backlog_id' => '',
            'product_backlog_item_id' => '',
        );
 * @param $data['backlogs'] backlog item names and ids
 * @param $data['pagetitle'] Title and heading of the page
 
 * @package opix
 * @category View
 * @author Roni Kokkonen, Tuukka Kiiskinen
 */
?>

<h1><?php echo $pagetitle ?></h1>

<?php 
echo form_fieldset();
echo form_open('sprint_backlog_item/save');
echo form_hidden('sprint_backlog_id', $sprintbacklog_id);
echo form_hidden('txt_project_id', set_value('project_id', $project_id));

echo '<table>';
echo '<tr>';
    echo '<td>' . $this->lang->line('label_select') . '</td>';
    echo '<td>' . $this->lang->line('label_item_name') . '</td>';
echo '</tr>';

foreach ($backlogs as $backlog)  
{
    echo '<tr>';
    echo '<td>';
    // show the data for the checkbox (checked/not checked)
        echo form_checkbox('chk_new_backlog' . '[]', $backlog['product_backlog_item_id'], $backlog['selected']);
    echo '</td>';

    echo '<td>' . $backlog['item_name'] . '</td>';
    echo '</td>';

    echo '</tr>';
}

echo '</table>';
echo br(1);
echo form_submit('btn_save', $this->lang->line('button_save'));
echo anchor('sprint_backlog_item/index/' . $project_id . '/' . $sprintbacklog_id,
        $this->lang->line('link_return'), 'class="returnlink"');

echo form_fieldset_close();
echo form_close();
echo br(2);
?>