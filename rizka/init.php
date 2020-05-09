<?php

	session_start();

	spl_autoload_register(function($class){
		require_once 'kelas/' . $class . '.php';
	});

	$user = new User();
	$admin = new Admin();
?>