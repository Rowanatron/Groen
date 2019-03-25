<?php

	// filepath constanten declaratie

	define("PRIVATE_PATH", dirname(__FILE__)); // app/private/
	
	define("SHARED_PATH", PRIVATE_PATH . '/shared'); // app/private/shared
	define("CLASS_PATH", PRIVATE_PATH . '/class'); // app/private/class	
	define("JS_PATH", PRIVATE_PATH . '/js'); // app/private/js	
	
	define("APP_PATH", dirname(PRIVATE_PATH)); // app/
	
?>