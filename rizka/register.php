<?php

	require_once 'init.php';

	if ( $user->is_LoggedIn() ) Redirect::To('profile');

	$errors = array();

	if(Input::get('submit'))
	{
		if( Token::check_token(Input::get('token')) )
		{
			$validation = new Validation();

			$validation = $validation->check_user(array(
		      'username' => array(
		                    'required' => true,
		                    'min'      => 3,
		                    'max'      => 50,
		                    ),
		      'password' => array(
		                    'required' => true,
		                    'min'      => 3,
		                    ),
		      'password_verify' => array(
                      		'required' => true,
                      		'match'    => 'password'
                    )
				));
			if ( $user->check_user(Input::get('username')) ) 
			{
				if ( $validation->check_passed() )
				{
					$user->register(array(
						'username'=>Input::get('username'),
						'password'=>Input::password_hash(Input::get('password'))
						));
					Session::flash('register','Anda berhasil mendaftar');
					Session::set_session('username',Input::get('username'));
					Redirect::To('profile');
				}else{
					$errors = $validation->check_errors();
				}
			} else {
				$errors[] = 'Username telah terdaftar';
			}
		}
	}

	require_once 'header.php';

?>


<h2>Form Register</h2>

<form action="register.php" method="post">

	<input type="text" name="username" placeholder="Username">
	<input type="password" name="password" placeholder="Password">
	<input type="password" name="password_verify" placeholder="Ulangi Password">
	<input type="hidden" name="token" value="<?php echo Token::generate();?>">
	<ul>
	<?php
	foreach( $errors as $e ){
		echo "<li>$e</li>";
	}
	?>
	</ul>
	<input type="submit" name="submit" value="submit">

</form>
