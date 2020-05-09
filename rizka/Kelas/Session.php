<?php

class Session
{
	public static function set_session($name,$key)
	{
		return $_SESSION[$name] = $key;
	}

	public static function get_session($name)
	{
		return $_SESSION[$name];
	}

	public static function exists($name)
	{
		return ( isset($_SESSION[$name]) ) ? true : false;
	}

	public static function flash($name,$msg = '')
	{
		if( self::exists($name) ){
			$data = self::get_session($name);
			self::del_session($name);
			return $data;
		}else{
			self::set_session($name,$msg);
		}
	}

	public static function del_session($name)
	{
		if( self::exists($name) ){
			unset($_SESSION[$name]);
		}
	}
}