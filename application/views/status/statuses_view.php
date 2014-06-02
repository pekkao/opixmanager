<?php

/**
 * Statuses_view to be used to show all statuses in an html table..
 * 
 * @param $data = array(
 *               'id',
 *               'status_name',
 *               'status_description' 
 *              );
 * 
 * @param $data['pagetitle'] Title and heading of the page
 * @param $data['heading'] Heading for the error message.
 * @param $data['error_message'] The error message to be printed.
 * @param $data['login_user_id'] User's login id (session data)
 * @param $data['login_id'] User's id (session data)
 * 
 * @package opix
 * @category View
 * @author Tuukka Kiiskinen, Roni Kokkonen
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
    <?php echo anchor('status/add', $this->lang->line('link_add_status')) ?>
</p>
<table>
    <thead>
        <tr>
            <?php
            echo '<th>' . $this->lang->line('label_status_name') . '</th>';
            echo '<th>' . $this->lang->line('label_status_description') . '</th>';
            echo '<th colspan="2"></th>';
            ?>
        </tr>
    </thead>
    <tbody>
        <?php
        if (isset($statuses))
        {
            foreach ($statuses as $status)
            {
                echo '<tr>';
                echo '<td>' . $status->status_name . '</td>';
                echo '<td>' . $status->status_description . '</td>';
                echo '<td>' . anchor ('status/edit/' . $status->id,
                        $this->lang->line('link_edit')) . '</td>';
                echo '<td>';
                     echo form_open('status/delete');
                     echo form_hidden('txt_id', set_value('id', $status->id));
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
