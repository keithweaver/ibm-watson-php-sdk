<?php
	require_once "../vendor/autoload.php";
	
	$class = new \Kweaver\Watson\SkeletonClass();
	
	echo $class->echoPhrase("It's working");

?>