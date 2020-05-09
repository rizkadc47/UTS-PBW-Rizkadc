<?php
	require_once 'init.php';
	session_destroy();
	Redirect::to('login');
?>