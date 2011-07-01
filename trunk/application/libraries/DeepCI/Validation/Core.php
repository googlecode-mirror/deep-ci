<?php

class DeepCI_Validation_Core
{
	public $rules = array();
	
	public $nowField = '';
	
	public $errorMessage = '';
	
	public $defaultValue = array();
	
	// ------------------------------------------------------------------------
	
	/**
	 * 初始化 設定驗證的類
	 */
	public function __construct($className, $defaultValue='')
	{
		if (empty($className)) {
			throw new Exception('model name is empty.');
		}

		try {
			$modle = new $className;
		} catch(Exception $e) {
			throw new Exception($className.' not fond.');
		}
		
		if($modle instanceof DeepCI_Validation_PdoInterface) {
			$this->rules = $modle->validation();
		}
		
		if ( ! empty($defaultValue)) {
			$this->defaultValue = $defaultValue;
		}
	}
	
	// ------------------------------------------------------------------------
	
	/**
	 * 執行php驗證
	 */
	public function run($data='')
	{
		if (empty($data)) {
			$data = $_POST;
		}
		
		$rules = $this->rules;
		
		if(empty($rules)) {
			return true;
		}
		
		// -----------------------------------
		// 逐條來驗證
		// -----------------------------------
		foreach($rules as $field=>$fieldRules) {
			foreach($fieldRules as $r) {
				$res = $this->_checkDatal($data, $r, $field);
				if($res!==true) {
					return false;
				}
			}
		}
		
		return true;
	}
	
	private function _checkDatal($data, $rule, $field)
	{
		if(!is_array($rule) || empty($rule[0])) {
			return true;
		}
		
		$fieldData = @$data[$field];

		switch ($rule[0]) {
			case 'required':
				if(empty($fieldData)) {
					$msg = (empty($rule[1])) ? $field.' 不能為空' : $rule[1];
					$this->errorMessage = $msg;
					return false;
				}
				break;
			case 'email':
				if(empty($fieldData)) {
					$msg = (empty($rule[1])) ? $field.' 不是有有效的Email' : $rule[1];
					$this->errorMessage = $msg;
					return false;
				}
				break;
			case 'url':
				if(empty($fieldData)) {
					$msg = (empty($rule[1])) ? $field.' 不是有效的URL' : $rule[1];
					$this->errorMessage = $msg;
					return false;
				}
				break;
			case 'number':
				if ( ! preg_match("/^-?(?:\d+|\d{1,3}(?:,\d{3})+)(?:\.\d+)?$/",$fieldData)) {
					$msg = (empty($rule[1])) ? $field.' 不是有效的數字' : $rule[1];
					$this->errorMessage = $msg;
					return false;
				}
				break;
			case 'date':
				if(strtotime($fieldData)===false) {
					$msg = (empty($rule[1])) ? $field.' 不是有效的日期' : $rule[1];
					$this->errorMessage = $msg;
					return false;
				}
				break;
			case 'regex':
				$preg = $rule[1];
				$preg = ( preg_match("/^\^/i", $preg) ) ? $preg : '^'.$preg;
				$preg = ( preg_match("/\$$/i", $preg) ) ? $preg : $preg.'$';
				$preg = '/'.$preg.'/';
				if( ! preg_match($preg, $fieldData)) {
					$msg =(empty($rule[2])) ? $field.' 不匹配' : $rule[2];
					$this->errorMessage = $msg;
					return false;
				}
				break;
			case 'equalto':
				$otherData = @$data[$rule[1]];
				if($otherData != $fieldData) {
					$msg = (empty($rule[2])) ? $field.' 于'.$rule[1].'不一樣' : $rule[2];
					$this->errorMessage = $msg;
					return false;
				}
				break;
		}
		
		return true;
	}
	
	public function getMessage()
	{
		return $this->errorMessage;
	}
	
	public function getMessageSpanHtml($field='')
	{
		if(empty($field))
			$field = $this->nowField;
		
		if(empty($field) or empty($this->rules)) {
			return '';
		}
		
		$rules = $this->rules;
		if(empty($rules[$field])) {
			return '';
		}
		
		$this->nowField = '';
		echo '<span class="field-validation-valid" data-valmsg-for="'.$field.'" data-valmsg-replace="true"></span>';
	}
	
	public function getSubInputHtml($field)
	{
		if(empty($field) or empty($this->rules)) {
			return '';
		}
		
		$rules = $this->rules;
		if(empty($rules[$field])) {
			return '';
		}
		
		$this->nowField = $field;
		
		$html = '';
		foreach($rules[$field] as $r) {
			$html .= $this->_createValidationHtml($r, $field);
		}
		
		if(!empty($html)) {
			$html = ' data-val="true"'.$html;
		}
		
		//默認值
		$defaultValue =& $this->defaultValue;
		if(!empty($defaultValue[$field])) {
			$html = ' value="'.$defaultValue[$field].'" '.$html;
		}
		
		return 'name="'.$field.'" id="'.$field.'"'.$html;
	}
	
	private function _createValidationHtml($rule, $field)
	{
		if(!is_array($rule) || empty($rule[0])) {
			return '';
		}

		$html = '';
		switch ($rule[0]) {
			case 'required':
				$msg = (empty($rule[1])) ? $field.' 不能為空' : $rule[1];
				$html = ' data-val-required="'.$msg.'"';
				break;
			case 'email':
				$msg = (empty($rule[1])) ? $field.' 不是有有效的Email' : $rule[1];
				$html = ' data-val-email="'.$msg.'"';
				break;
			case 'url':
				$msg = (empty($rule[1])) ? $field.' 不是有效的URL' : $rule[1];
				$html = ' data-val-url="'.$msg.'"';
				break;
			case 'number':
				$msg = (empty($rule[1])) ? $field.' 不是有效的數字' : $rule[1];
				$html = ' data-val-number="'.$msg.'"';
				break;
			case 'date':
				$msg = (empty($rule[1])) ? $field.' 不是有效的日期' : $rule[1];
				$html = ' data-val-date="'.$msg.'"';
				break;
			case 'regex':
				$msg = (empty($rule[2])) ? $field.' 不匹配' : $rule[2];
				$html = ' data-val-regex-pattern="'.$rule[1].'" data-val-regex="'.$msg.'"';
				break;
			case 'equalto':
				$msg = (empty($rule[2])) ? $field.' 于'.$rule[1].'不一樣' : $rule[2];
				$html = ' data-val-equalto="'.$msg.'" data-val-equalto-other="'.$rule[1].'"';
				break;
		}

		return $html;
	}
}