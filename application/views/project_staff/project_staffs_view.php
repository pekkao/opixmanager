<?php
/**
 * Project staffs view to be used to show all project staffs in an html table.
 * 
 * Show Project staffs and with each Project staff a link to edit and delete Project staff.
 * 
 * @param  $data = array(
 *       'id' => '',
 *       'surname' => '',
 *       'firstname' => '',
 *       'role' => '',
 *       'start_date' => '',
 *       'end_date' => '',
 *   );
 * @param $data['project_staff'] Project staff names and ids
 * @param $data['pagetitle'] Title and heading of the page
 
 * @package opix
 * @category View
 * @author Arto Ruonala, Pipsa Korkiakoski, Antti Aho, Liisa Auer
 */
?>

<script type="text/javascript">
       function deleteconfirm()
    {
        var answer = confirm("Are you sure you want to delete?")
        if (answer){
            document.messages.submit();
        }

        return false;  
    }
</script>

<h1><?php echo $pagetitle ?></h1>

<p>
<?php echo anchor('project_staff/add/' . $currentid, 
     $this->lang->line('link_add_project_staff')) 
?>
</p>

<table>
    <thead>
        <tr>
            <?php
            echo '<th>' . $this->lang->line('label_surname') . '</th>';
            echo '<th>' . $this->lang->line('label_firstname') . '</th>';
            echo '<th>' . $this->lang->line('label_role') . '</th>';
            echo '<th>' . $this->lang->line('label_start_date') . '</th>';
            echo '<th>' . $this->lang->line('label_end_date') . '</th>';
            echo '<th colspan="2"></th>';
            ?>
        </tr>
    </thead>
    <tbody>
        <?php
        if (isset($project_staffs)) {
            foreach ($project_staffs as $staff) {
                echo '<tr>';
                echo '<td>' . $staff->surname . '</td>';
                echo '<td>' . $staff->firstname . '</td>';
                echo '<td>' . $staff->role_name . '</td>';
                echo '<td>' . $staff->start_date . '</td>';
                echo '<td>' . $staff->end_date . '</td>';
                echo '<td>' . anchor(
                        'project_staff/edit/' . $staff->id ,
                        $this->lang->line('link_edit')) . '</td>';
                echo '<td>'; 
                    echo form_open('project_staff/delete');
                    echo form_hidden('txt_id', set_value('id', $staff->id));
                    echo form_hidden('txt_project_id', set_value('project_id', $staff->project_id));
                    echo '<input type="submit" value="X" onclick="return deleteconfirm();" />';
                    echo form_close();
                echo '</td>';
                echo '</tr>';
            }
        }
        ?>
    </tbody>
</table>

<?php 
if ($error_message != '')
{
    echo '<h4>' . $heading . '</h4>';
    echo '<p>' . $error_message . '</p>';
}
?>
