<?php

// This is a simplified example, which doesn't cover security of uploaded files. 
// This example just demonstrate the logic behind the process.
$dir = '/dnscit8/quizadmin/scripts/files/';

$st = dirname(__FILE__) . '/files/';;

$file = $st.$_FILES['file']['name'];

 // copying
copy($_FILES['file']['tmp_name'], $file);
					
$array = array(
	'filelink' => $dir.$_FILES['file']['name'],
	'filename' => $_FILES['file']['name']
);

echo stripslashes(json_encode($array));
	
?>