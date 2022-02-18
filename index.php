<?php

include_once('template.php');

$template = new template();

echo $template->parse(file_get_contents('template.html'), array(
	'var_1' => 'var_1 content',
	'var_2' => true,
	'var_loop' => array(
		array('var' => 'var content 1'),
		array('var' => 'var content 2'),
		array('var' => 'var content 3'),
	),
));

?>