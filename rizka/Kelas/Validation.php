<?php

class Validation
{

	private $errors = array();
	private $passed = false;

	public function check_user($fields = array())
	{
		foreach($fields as $keys => $values)
		{
			foreach($values as $rule => $rule_value)
			{
				switch($rule)
				{
					case 'required':
					if ( trim(Input::get($keys)) == false && $rule_value == true ){
						$this->addErrors("$keys Harus Diisi");
					}
					break;
					case 'min':
					if ( strlen(Input::get($keys)) < $rule_value ){
						$this->addErrors("$keys minimal $rule_value karakter");
					}
					break;
					case 'max':
					if ( strlen(Input::get($keys)) > $rule_value ){
						$this->addErrors("$keys maksimal $rule_value karakter");
					}
					break;
					case 'match':
					if ( Input::get($keys) != Input::get($rule_value) ){
						$this->addErrors("$keys harus sama dengan $rule_value ");
					}
					break;
					default:
					break;
				} 
			}
		}

		if( empty($this->errors) ){
			$this->passed = true;
		}

		return $this;
	}

	public function addErrors($error)
	{
		$this->errors[] = $error;
	}

	public function check_passed()
	{
		return $this->passed;
	}

	public function check_errors()
	{
		return $this->errors;
	}
}

?>