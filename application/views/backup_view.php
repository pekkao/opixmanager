<?php
/**
 * @package opix
 * @category View
 * @author Roni Kokkonen, Tuukka Kiiskinen
 */
?>

<h1><?php echo $pagetitle ?></h1>

<?php 
echo form_open('backup/backupdb');
echo form_submit('btn_submit', $this->lang->line('button_backup'));
echo br(1);
?>
