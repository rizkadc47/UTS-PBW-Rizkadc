<?php

	require_once 'init.php';

	if ( $user->is_LoggedIn() ) Redirect::To('profile');

	if ( Session::exists('profile') ){
		echo Session::flash('profile');
	}
	$errors = array();

	if(Input::get('submit'))
	{
		if( Token::check_token(Input::get('token')) )
		{
			$validation = new Validation();

			$validation = $validation->check_user(array(
		      'username' => array(
		                    'required' => true,
		                    ),
		      'password' => array(
		                    'required' => true,
		                    )
				));
			if ( !$user->check_user(Input::get('username')) ) 
			{
				if ( $validation->check_passed() )
				{
					$data = $user->login(Input::get('username'),Input::get('password'));
					if(password_verify(Input::get('password'),$data['password'])){
						Session::set_session('username',Input::get('username'));
						Redirect::To('profile');
					}else{
						$errors[] = 'Password Anda Salah';
					}

				}else{
					$errors = $validation->check_errors();
				}
			} else {
				$errors[] = 'Username Belum telah terdaftar';
			}
		}
	}

	require_once 'header.php';

?>


<h2>LOGIN</h2>

<form action="login.php" method="post">

	<input type="text" name="username" placeholder="Username">
	<input type="password" name="password" placeholder="Password">
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
