<?php
/**
 * Project staffs view to be used to show all project staffs in an html table.
 * 
 * Show Project staffs and with each Project staff a link to edit and delete Project staff.
 * 
 * @param  $data = array(
 *       'id', 
 *       'project_id', 
 *       'surname', 
 *       'firstname', 
 *       'role', 
 *       'start_date', 
 *       'end_date', 
 *   );
 * 
 * @param $data['project_staff'] Project staff names and ids
 * @param $data['pagetitle'] Title and heading of the page
 * @param $data['heading'] Heading for the error message.
 * @param $data['error_message'] The error message to be printed.
 * @param $data['login_user_id'] User's login id (session data)
 * @param $data['login_id'] User's id (session data)
 * 
 * @package opix
 * @category View
 * @author Arto Ruonala, Pipsa Korkiakoski, Antti Aho, Liisa Auer,
 *      Tuukka Kiiskinen, Roni Kokkonen
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
<?php 
    if (($this->session->userdata('account_type') == 1) ||
           $editor == true)
    {
        echo anchor('project_staff/add/' . $currentid, 
             $this->lang->line('link_add_project_staff')); 
    }
?>
</p>

<div class="table-responsive">
<table class="table table-striped table-condensed">
    <thead>
        <tr class="success">
            <?php
            echo '<th>' . $this->lang->line('label_surname') . '</th>';
            echo '<th>' . $this->lang->line('label_firstname') . '</th>';
            echo '<th>' . $this->lang->line('label_role') . '</th>';
            echo '<th>' . $this->lang->line('label_start_date') . '</th>';
            echo '<th>' . $this->lang->line('label_end_date') . '</th>';
            echo '<th>' . $this->lang->line('label_project_staff_edit') . '</th>';
            echo '<th colspan="2"></th>';
            echo '<th>' . $this->lang->line('label_project_data_edit') . '</th>';
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

                echo '<td>';                
                if ($staff->can_edit_project_staff == 1) {
                    echo $this->lang->line('yes');
                } 
                echo '</td>';                
                
                echo '<td>';
                if (($this->session->userdata('account_type') == 1) ||
                       $editor == true)
                {
                    echo anchor(
                        'project_staff/edit/' . $staff->id ,
                       '<span class="glyphicon glyphicon-edit"></span>');
                }
                echo '</td>';                
                
                echo '<td>'; 
                if (($this->session->userdata('account_type') == 1) ||
                       $editor == true)
                {
                    echo form_open('project_staff/delete');
                    echo form_hidden('txt_id', set_value('id', $staff->id));
                    echo form_hidden('txt_project_id', set_value('project_id', $staff->project_id));
                    echo '<span class="glyphicon glyphicon-remove-circle" <input onclick="return deleteconfirm();" /></span>';
                    echo form_close();
                }
                echo '</td>';
                
                echo '<td>'; 
                    if ($staff->can_edit_project_data == 1) {
                        echo $this->lang->line('yes');
                    }                     
                echo '</td>'; 
                
                echo '</tr>';
            }
        }
        ?>
    </tbody>
</table>
</div>
<?php 
if ($error_message != '')
{
    echo '<h4>' . $heading . '</h4>';
    echo '<p>' . $error_message . '</p>';
}
?>
