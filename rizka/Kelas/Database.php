<?php

class Database{

	private static $INSTANCE = NULL;
	private $mysqli,
			$HOST = 'localhost',
			$USER = 'root',
			$PASS = '',
			$DBNAME = 'rizka';

	public function __construct()
	{
		$this->mysqli = new mysqli($this->HOST, $this->USER, $this->PASS, $this->DBNAME);
		if ( mysqli_connect_error() ){
			die("DATABASE ERROR" . " -> " . mysqli_connect_error() );
		}
	}

	public static function getInstance()
	{
		if( self::$INSTANCE == NULL )
		{
			self::$INSTANCE = new Database();
		}
		return self::$INSTANCE;
	}

	public function insert($table,$fields = array())
	{
		$column = implode(',',array_keys($fields));
		$arrayValues = array();
		foreach($fields as $key => $values){
			if ( preg_match('/^[0-9]{1,}$/', $values) ){
				$arrayValues[] = $values;
			} else {
				$arrayValues[] = "'" . $values . "'";
			}
		}
		$value = implode(',',$arrayValues);

		$query = "INSERT INTO $table ($column) VALUES ($value)";
		return $this->run_query($query);
	}

	public function run_query($query)
	{
		if ( $this->mysqli->query($query) )
		{
			return true;
		} else {
			return false;
		}
	}

	public function get_data($table,$column,$username)
	{
		if ( !preg_match('/^[0-9]{1,}$/',$username) ){
			$username = "'" . $username . "'";
		}
		$query = "SELECT * FROM $table WHERE $column = $username";
		$query = $this->mysqli->query($query);
		while ( $data = $query->fetch_assoc() )
		{
			return $data;
		}
	}

	public function get_data_all($table)
	{
		$query = " SELECT * FROM $table";
		$query = $this->mysqli->query($query);
		return $query;
	}

	public function change_data($table,$column,$column_value,$username,$username_value)
	{
		$query = "UPDATE $table SET $column = '$column_value' WHERE $username = '$username_value'";
		return ( $this->run_query($query) ) ? true : false; 
	}

	public function update($table,$fields = array(),$column,$column_value)
	{
		$arrayValues = array();
		$arrayKeys = array();
		$no = 0;

		foreach($fields as $key => $values){
			if ( preg_match('/^[0-9]{1,}$/', $values) ){
				$arrayValues[] = $values;
			} else {
				$arrayValues[] = "'" . $values . "'";
			}
			$arrayKey[] = $key;
			$data = $no;
			$no++;
		}

		for ( $i = 0; $i <= $data ; $i++)
		{
			if($i == $data){
				$query .= "UPDATE $table SET $arrayKey[$i] = $arrayValues[$i] where $column = '$column_value'";
			}else if( ($i != $data) AND $i > 0 ){
				$query .= "UPDATE $table SET $arrayKey[$i] = $arrayValues[$i] where $column = '$column_value';";				
			}else{
				$query = "UPDATE $table SET $arrayKey[$i] = $arrayValues[$i] where $column = '$column_value';";
			}
		}

		return $this->multi_query($query);

		// $query = "UPDATE $table SET username = username, password = password WHERE id=id"
	}

	public function multi_query($query)
	{
		if ( $this->mysqli->multi_query($query) )
		{
			return true;
		} else {
			return false;
		}
	}
}
