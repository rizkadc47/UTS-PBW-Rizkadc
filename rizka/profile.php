<?php

	require_once 'init.php';

	if ( !$user->is_LoggedIn() ) {
		Session::flash('profile','Anda belum login');
		Redirect::To('login');
	}

	if ( Session::exists('register')){
		echo Session::flash('register');
	}

	$profile = $user->get_data('users','username',Session::get_session('username'));
	require_once 'header.php';

?>
	
	<div class="profile">
	
		
		Welcome <?php echo $profile['username'];?><br/>
	</div>

