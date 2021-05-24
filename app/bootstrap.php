<?php
	# load config
	require_once "config/config.php";

	# load helpers	
	require_once "Mail.php";
	require_once "helpers/fpdm.php";
	require_once "helpers/Utility.php";
	require_once "helpers/PHPExcel.php";
	require_once "helpers/Validate.php";
	
	# autoload core libraries
	spl_autoload_register(function($className) {
		require_once "libraries/$className.php";
	});
?>