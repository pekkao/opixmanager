<?php
/**
 * Person project view to be used to view person's projects.
 * 
 * @param $data['pagetitle'] Title and heading of the page
 * @param $data['projects'] Person's projects in an array
 * @param $data['add'] Hide or show the Reset button (false/true).
 * @param $data['login_user_id'] User's login id (session data)
 * @param $data['login_id'] User's id (session data)
 * 
 * @package opix
 * @category View
 * @author Tuukka Kiiskinen, Roni Kokkonen
 * 
 *
 */
?>
<h1>
    <?php echo $pagetitle  ?>
</h1>

<table>
    <thead>
        <tr>
            <?php
            echo '<th>' . $this->lang->line('label_project_name') . '</th>';
            echo '<th>' . $this->lang->line('label_role_name') . '</th>';
            echo '<th>' . $this->lang->line('label_start_date') . '</th>';
            echo '<th>' . $this->lang->line('label_end_date') . '</th>';
            echo '<th colspan="3"></th>';
            ?>
        </tr>
    </thead>
    <tbody>
        <?php
        if (isset($projects)) 
        {
            foreach ($projects as $staff) 
            {
                echo '<tr>';
                echo '<td>' . $staff->project_name . '</td>';
                echo '<td>' . $staff->role_name . '</td>';
                echo '<td>' . $staff->start_date . '</td>';
                echo '<td>' . $staff->end_date . '</td>';
                echo '<td>';
                if ($staff -> can_edit == TRUE)
                {
                    echo anchor(
                        'project_staff/edit/' . $staff->id ,
                        $this->lang->line('link_edit'));
                }
                echo  '</td>';
                echo '<td>'; 
                if ($staff -> can_edit == TRUE)
                {
                    echo form_open('project_staff/delete');
                    echo form_hidden('txt_id', set_value('id', $staff->id));
                    echo form_hidden('txt_projectid', set_value('project_id', $staff->project_id));
                    echo '<input type="submit" value="X" />';
                    echo form_close();
                }
                echo '</td>';
                echo '</tr>';
            }
        }
        ?>
    </tbody>
</table>



