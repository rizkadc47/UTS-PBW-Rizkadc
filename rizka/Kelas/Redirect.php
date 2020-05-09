<?php

class Redirect{

	public static function To($name)
	{
		return header('location:'.$name.'.php');
	}
}
