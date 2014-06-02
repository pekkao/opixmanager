<?php

/**
 * Person_roles_view to be used to show all person_roles in an html table..
 * 
 * @param $data = array(
 *               'id',
 *               'role_name',
 *               'role_description'
 *              );
 * 
 * @param $data['pagetitle'] Title and heading of the page
 * @param $data['add'] Hide or show the Reset button (false/true).
 * @param $data['heading'] Heading for the error message.
 * @param $data['error_message'] The error message to be printed.
 * @param $data['login_user_id'] User's login id (session data)
 * @param $data['login_id'] User's id (session data)
 * 
 * @package opix
 * @category View
 * @author Wang Yuqing, Tuukka Kiiskinen, Roni Kokkonen
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
    <?php echo anchor('person_role/add', $this->lang->line('link_add_person_role')) ?>
</p>
<table>
    <thead>
        <tr>
            <?php
            echo '<th>' . $this->lang->line('label_person_role_name') . '</th>';
            echo '<th>' . $this->lang->line('label_person_role_description') . '</th>';
            echo '<th colspan="2"></th>';
            ?>
        </tr>
    </thead>
    <tbody>
        <?php
        if (isset($person_roles))
        {
            foreach ($person_roles as $person_role)
            {
                echo '<tr>';
                echo '<td>' . $person_role->role_name . '</td>';
                echo '<td>' . $person_role->role_description . '</td>';
                echo '<td>' . anchor ('person_role/edit/' . $person_role->id,
                        $this->lang->line('link_edit')) . '</td>';
                echo '<td>';
                     echo form_open('person_role/delete');
                     echo form_hidden('txt_id',set_value('id', $person_role->id));
                     echo '<input type="submit" value = "X" onclick="return deleteconfirm();" />';
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
