# 规范 #
```
function foo($bar)
{
 // ...
}

foreach ($arr as $key => $val)
{
 // ...
}

if ($foo == $bar)
{
 // ...
}
else
{
 // ...
}

for ($i = 0; $i < 10; $i++)
{
 for ($j = 0; $j < 10; $j++)
 {
  // ...
 }
}
```

```
if ($foo OR $bar)
if ($foo && $bar) // 推荐
if ( ! $foo)
if ( ! is_array($foo))
```

# PhpCode #

```
if ( ! class_exists($class)
	OR strncmp($method, '_', 1) == 0
	OR in_array(strtolower($method), array_map('strtolower', get_class_methods('CI_Controller')))
	)
{
	show_404("{$class}/{$method}");
}
```

```
if ($this->_allow_get_array == FALSE)
{
	$_GET = array();
}
else
{
	if (is_array($_GET) AND count($_GET) > 0)
	{
		foreach ($_GET as $key => $val)
		{
			$_GET[$this->_clean_input_keys($key)] = $this->_clean_input_data($val);
		}
	}
}
```

## some ##
http://www.souzz.net/online/php_coding_standard_cn.html

http://yangyubo.com/google-cpp-styleguide/naming.html

```
class PhpCodeStyel
{
	public static $member_username;
	
	public static function Run()
	{
		$big_age = 100;
		
		if($member_username==10)
		{
			$php_style = new PhpStyle();
			
			$php_style->Run();
			echo $php_style->user;
			echo $php_style->user_age;
			
			PhpStyle::Run();
			
			PdoMember::GetTable()->Find();
			$member = Model_Member::GetCoutentUser();
			
			$q = Doctrine_Query::create()
						->from('RankGroup')
						->where("member_id='{$member->id}'")
						->orderBy('id');
			$q->fetchOne();
		}
	}
}

class PhpStyel
{
	public $user;
	public $user_age;
	
	public function __construct()
	{
		$this->user = 'howard';
		$this->user_age = 20;
	}
	
	public static function Run()
	{
		$string = "hello";
		
		return $string;
	}
	
	public function DoIt()
	{
		$string = 'do';
		
		return $string;
	}
}

// 一般样式

	/**
	 * 說明
	 */

// ------------------------------------------------------------------------

		// -----------------------------------
		// 驗證經銷商不能為空
		// -----------------------------------


// 特殊情況樣式

/**
 * 說明
 */
 
// -----------------------------------
// 驗證經銷商不能為空
// -----------------------------------
```