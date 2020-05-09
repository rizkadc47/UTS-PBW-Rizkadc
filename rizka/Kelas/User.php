<?php

class User{
	private $_db;

	public function __construct()
	{
		$this->_db = Database::getInstance();
	}

	public function register($fields = array())
	{
		return ( $this->_db->insert('users',$fields) ) ? true : false;
	}

	public function check_user($username)
	{
		$data = $this->_db->get_data('users','username',$username);
		return( empty($data) ) ? true : false;
	}

	public function login($username)
	{
		return $this->_db->get_data('users','username',$username);
	}

	public function get_data($table,$column,$value)
	{
		return ($this->_db->get_data($table,$column,$value));		
	}

	public function update($table,$fields = array(),$key,$value)
	{
		if ( $this->_db->update($table,$fields,$key,$value)) return true ; 
		else return false;
	}

	public function change_password($password)
	{
		if ( $this->_db->change_data('users','password',$password,'username',Session::get_session('username')) ) 
			return true;
		else
			return false;
	}

	public function is_admin($username)
	{
		$data = $this->_db->get_data('users','username',$username);
		if ( $data['role'] == 1){
			return true;
		} else { 
			return false;
		}
	}

	public function is_LoggedIn()
	{
		if ( Session::exists('username') ){
			return true;
		} else {
			return false;
		}
	}
}