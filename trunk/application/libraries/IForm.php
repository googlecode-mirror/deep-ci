<?php
/**
 * Form 表單先骨幹
 *
 * @todo 結合jquery.validate 驗證數據
 */
class IForm
{
	/**
	 * 判斷是否被選中
	 */
	public static function checked($value,$eqValue)
	{
		return ($value==$eqValue) ? ' checked' : '';
	}
	
	/**
	 * 根據 array， ojbect 生成 options html code。
	 * array 可以是 $k=>$v, 也可以是一個有很多欄位的數組。
	 */
	public static function option(&$data,$selected='',$key='',$value='')
	{
		$str = '';
		
		if(is_array($data)) {
			//array
			if(empty($key)||empty($value)) {
				foreach($data as $k=>$v) {
					$selStr = '';
					if($selected!=''&&$selected==$k)
						$selStr = 'selected';
					$str .= '<option value="'.$k.'" '.$selStr.'>'.$v.'</option>'."\r\n";
				}
			} else {
				foreach($data as $r) {
					$selStr = '';
					if($selected!=''&&$selected==$k)
						$selStr = 'selected';
					$str .= '<option value="'.$r[$key].'" '.$selStr.'>'.$r[$value].'</option>'."\r\n";
				}
			}
		}
		
		if(is_object($data)) {
			//object
			foreach($data as $r) {
				$selStr = '';
				if($selected!=''&&$selected==$r->$key)
					$selStr = 'selected';
				$str .= '<option value="'.$r->$key.'" '.$selStr.'>'.$r->$value.'</option>'."\r\n";
			}
		}
		
		return $str;
	}
}