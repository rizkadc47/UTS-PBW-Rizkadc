<?php

	require_once 'init.php';

	if ( !$user->is_LoggedIn() ) {
		Session::flash('profile','Anda belum login');
		Redirect::To('login');
	}

	if ( Session::exists('change_password')){
		echo Session::flash('change_password');
	}
	$errors = array();
	$profile = $user->get_data('users','username',Session::get_session('username'));
	if(Input::get('submit'))
	{
		if( Token::check_token(Input::get('token')) )
		{
			$validation = new Validation();

			$validation = $validation->check_user(array(
		      'password_lama' => array(
		                    'required' => true,
		                    'min'      => 5,
		                    'max'      => 30
		                    ),
		      'password_baru' => array(
		                    'required' => true,
		                    'min'      => 5,
		                    'max'      => 30
		                    ),
		      'password_verifikasi' => array(
		                    'required' => true,
		      				'match'	   => 'password_baru'
		                    )
			));
			if ( $validation->check_passed() )
			{
				$data = $user->get_data( 'users','username',Session::get_session('username') );
				if(password_verify(Input::get('password_lama'),$data['password'])){
					$user->change_password( Input::password_hash(Input::get('password_baru')) );
					Session::flash('change_password','Berhasil Ganti Password');
					Redirect::To('changepass');
				}else{
					$errors[] = 'Password Lama Tidak Sesuai';
				}
			} else {
				$errors = $validation->check_errors();
			}//end of check passed

		}//end of check_token

	}//end of input::get

	require_once 'header.php';

?>
	<body>
   
	<div class="profile">
		<h3 class="title-profile">Ubah Password</h3>
		<form method="post" action="changepass.php">
		Password Lama: <input type="password" name="password_lama"><br/>
		Password Baru : <input type="password" name="password_baru"><br/>
		Verifikasi Password Baru : <input type="password" name="password_verifikasi"><br/>
		<input type="hidden" name="token" value="<?php echo Token::generate();?>">
		<ul>
		<?php
		foreach($errors as $e)
		{
			echo "<li>$e</li>";
		}
		?>
		</ul>
		<input type="submit" value="SUBMIT" name="submit">
		</form>
	</div>

