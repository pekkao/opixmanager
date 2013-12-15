<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<h1><?php echo $pagetitle . $login_user_id ?></h1>

<?php echo form_fieldset(); ?>

<?php
echo anchor('person/read_projects/' . $login_id, 
                        $this->lang->line('link_project'));
echo br(2);

echo anchor('person/edit/' . $login_id,
        $this->lang->line('link_edit'));

echo br(2);

echo anchor('person/edit_password/' . $login_id, 
        $this->lang->line('link_change_password'));
?>

<?php 
if ($error_message != '')
{
    echo '<h4>' . $heading . '</h4>';
    echo '<p>' . $error_message . '</p>';
}
?>