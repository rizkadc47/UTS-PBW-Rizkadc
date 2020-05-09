<?php

class Token
{
	public static function generate()
	{
		return Session::set_session('token',md5(uniqid(rand(), true)));
	}

	public static function check_token($token)
	{
		return ( $token === Session::get_session('token') ) ? true : false;
	}
}