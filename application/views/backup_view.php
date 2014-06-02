<?php
/**
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

<h1><?php echo $pagetitle ?></h1>

<?php 
echo form_open('backup/backupdb');
echo form_submit('btn_submit', $this->lang->line('button_backup'));
echo br(1);
?>
