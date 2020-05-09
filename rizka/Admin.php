<?php

class Admin{

	private $_db;

	public function __construct()
	{
		$this->_db = Database::getInstance();
	}

	public function change_navbar($table,$column,$column_value,$username,$username_value)
	{
		return ($this->_db->change_data($table,$column,$column_value,$username,$username_value)) ? true : false;
	}

	public function tambahberita($fields = array())
	{
		return $this->_db->insert('news',$fields);
	}

	public function get_berita($table)
	{
		return $this->_db->get_data_all($table);
	}
	public function tambahvideo($fields = array())
	{
		return $this->_db->insert('video',$fields);
	}
	public function get_video($table)
	{
		return $this->_db->get_data_all($table);
	}
}