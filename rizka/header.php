<!DOCTYPE HTML>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="style.css">
</head>
<body>
	<header>
		<h2 class="navbar-title">Portal Event Rizkadc</h2>

		<div class="navbar-menu">
			<?php
			if ( Session::exists('username') ){
			?>
			<a href="changepass.php">Ubah Password</a>
			<a href="logout.php">Logout</a>
			<?php
			}else{
			?>
			<a href="login.php">Login</a>
			<a href="register.php">Register</a>
			<?php
		}
			?>
		</div>

		<div class="clear-fix"></div>
	</header>
