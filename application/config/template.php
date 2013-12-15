<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * Setting the Default Template
 * Template requires that you have at least one active template group set 
 * with a master template defined. 
 */ 
$template['active_group'] = 'default';
$template['default']['template'] = 'template.php'; 

/*
 * Defining Regions: $header, $navigation, $content, $footer 
 */ 

$template['default']['regions'] = array(
  'header',
  'navigation',
  'content',
  'footer'
);

$template['default']['regions']['header'] = array('content' => array('<h1>OpixManager</h1>'));
$template['default']['regions']['footer'] = array('content' => array('<p id="copyright">© Oulu University of Applied Sciences</p>'));

$template['default']['parse_template'] = TRUE;
?>
