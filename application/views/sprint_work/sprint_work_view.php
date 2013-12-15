<?php

/**
 * Sprint_work_view to be used to insert and update a sprint_work.
 * 
 * @param $data = array(
                'id'         => $sprint_work[0]->id,
                'work_date'    => $sprint_work[0]->work_date,
                'work_done_hours'  => $sprint_work[0]->work_done_hours,
                'description'      => $sprint_work[0]->description,
                'work_remaining_hours'      => $sprint_work[0]->work_remaining_hours,
                'sprint_task_id'      => $sprint_work[0]->sprint_task_id,
                'person_id' => $sprint_work[0]->person_id
            );   
 * 
 * @param $data['pagetitle'] Title and heading of the page
 * @param $data['add'] Hide or show the Reset button (false/true).
 * @author Tuukka Kiiskinen, Roni Kokkonen
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
echo form_open('sprint_work/save');
echo form_fieldset();

if ($add == TRUE)
{
    echo form_hidden('txt_id', set_value('id', $id));
    echo form_hidden('txt_person_id', set_value('person_id', $person_id));

    echo form_label($this->lang->line('label_sprint_task'), 'ddl_sprint_task_id');
    echo form_dropdown('ddl_sprint_task_id', $tasks, $sprint_task_id);

    echo br(1);

    echo form_label($this->lang->line('label_work_date'), 'dtm_work_date');

    $data = array(
        'name' => 'dtm_work_date',
        'class' => 'datepicker',
        'value' => set_value('dtm_work_date', $work_date),
        'maxlength' => '100',
        'size' => '10',
        'type' =>'text'
    );

    echo form_input($data);
    echo form_error('dtm_work_date');
    echo br(2);

    echo form_label($this->lang->line('label_work_done_hours'), 'txt_work_done_hours');

    $data = array(
        'name' => 'txt_work_done_hours',
        'id' => 'txt_work_done_hours',
        'value' => set_value('txt_work_done_hours', $work_done_hours),
        'maxlength' => '100',
        'size' => '50',
        'type' => 'text'
    );

    echo form_input($data);
    echo form_error('txt_work_done_hours');
    echo br(2);

    echo form_label($this->lang->line('label_work_remaining_hours'), 'txt_work_remaining_hours');

    $data = array(
        'name' => 'txt_work_remaining_hours',
        'id' => 'txt_work_remaining_hours',
        'value' => set_value('txt_work_remaining_hours', $work_remaining_hours),
        'maxlength' => '100',
        'size' => '50',
        'type' => 'text'
    );

    echo form_input($data);
    echo form_error('txt_work_remaining_hours');
    echo br(4);

    echo form_label($this->lang->line('label_description'), 'txt_description');

    $data = array(
        'name' => 'txt_description',
        'id' => 'txt_description',
        'value' => set_value('txt_description', $description),
        'maxlength' => '1000',
        'size' => '50',
        'type' => 'text'
    );

    echo form_textarea($data);
    echo form_error('txt_description');
    echo br(1);

    echo '<p>';
    echo form_submit('btn_submit', $this->lang->line('button_save'),'class="newline"');

    echo '<input type="button" value="' . $this->lang->line('button_reset') .
            '" onclick="location.href=' . "'" . base_url() . 'index.php/sprint_work/add/' . $person_id . '" />';

    echo anchor('sprint_work/index/' . $person_id, $this->lang->line('link_return'), 'class="returnlink"' );
    echo '</p>';
}

else
{
    echo form_hidden('txt_id', set_value('id', $id));
    echo form_hidden('txt_person_id', set_value('person_id', $person_id));
    echo form_hidden('txt_sprint_task_id', set_value('sprint_task_id', $sprint_task_id));

    echo br(1);

    echo form_label($this->lang->line('label_work_date'), 'dtm_work_date');

    $data = array(
        'name' => 'dtm_work_date',
        'class' => 'datepicker',
        'value' => set_value('dtm_work_date', $work_date),
        'maxlength' => '100',
        'size' => '10',
        'type' =>'text'
    );

    echo form_input($data);
    echo form_error('dtm_work_date');
    echo br(2);

    echo form_label($this->lang->line('label_work_done_hours'), 'txt_work_done_hours');

    $data = array(
        'name' => 'txt_work_done_hours',
        'id' => 'txt_work_done_hours',
        'value' => set_value('txt_work_done_hours', $work_done_hours),
        'maxlength' => '100',
        'size' => '50',
        'type' => 'text'
    );

    echo form_input($data);
    echo form_error('txt_work_done_hours');
    echo br(2);

    echo form_label($this->lang->line('label_work_remaining_hours'), 'txt_work_remaining_hours');

    $data = array(
        'name' => 'txt_work_remaining_hours',
        'id' => 'txt_work_remaining_hours',
        'value' => set_value('txt_work_remaining_hours', $work_remaining_hours),
        'maxlength' => '100',
        'size' => '50',
        'type' => 'text'
    );

    echo form_input($data);
    echo form_error('txt_work_remaining_hours');
    echo br(4);

    echo form_label($this->lang->line('label_description'), 'txt_description');

    $data = array(
        'name' => 'txt_description',
        'id' => 'txt_description',
        'value' => set_value('txt_description', $description),
        'maxlength' => '1000',
        'size' => '50',
        'type' => 'text'
    );

    echo form_textarea($data);
    echo form_error('txt_description');
    echo br(1);

    echo '<p>';
    echo form_submit('btn_submit', $this->lang->line('button_save'),'class="newline"');

    echo anchor('sprint_work/index/' . $person_id, $this->lang->line('link_return'), 'class="returnlink"' );
    echo '</p>';
}

echo form_fieldset_close();
echo form_close();

?>
