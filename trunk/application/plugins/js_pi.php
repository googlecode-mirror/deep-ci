<?php
function js()
{
	return new JSClass();
}


/**
 * JS class
 */
class JSClass
{
	function load($jsLibrary)
	{
		$jsUrl = base_url().'static/jscripts/';
		switch($jsLibrary) {
			case 'validate':
				echo '<link href="'.$jsUrl.'lib/jquery.validate/style.css" rel="stylesheet" type="text/css" />'."\n";
				echo '<script type="text/javascript" src="'.$jsUrl.'lib/jquery.validate.min.js"></script>'."\n";
				break;
			case 'greybox':
				$s = '<script type="text/javascript">var GB_ROOT_DIR = "'.$jsUrl.'greybox/";</script>'."\n";
				$s .= '<script type="text/javascript" src="'.$jsUrl.'greybox/AJS.js"></script>'."\n";
				$s .= '<script type="text/javascript" src="'.$jsUrl.'greybox/AJS_fx.js"></script>'."\n";
				$s .= '<script type="text/javascript" src="'.$jsUrl.'greybox/gb_scripts.js"></script>'."\n";
				$s .= '<link href="'.$jsUrl.'greybox/gb_styles.css" rel="stylesheet" type="text/css" />'."\n";
				echo $s;
				break;
			default:
				echo '<script type="text/javascript" src="'.$jsUrl.$jsLibrary.'.js"></script>'."\n";
				break;
		}
	}
	
   /**
	* show a alert box.
	*
	* @param string $Text  the text to be showd in the alert box.
	*/
	var $Charset = "UTF-8";

	function alert($Text)
	{
		echo "<HTML>\n<HEAD>\n<meta http-equiv=\"Content-Type\"  content=\"text/html; charset={$this -> Charset}\">\n</HEAD>\n<BODY>\n";
		echo '<Script language="Javascript">alert("'.$Text.'");</Script>';
		echo "\n";
		echo "\n</body></html>";
	}
	
   /**
	* change the location of the $Target window to the $URL.
	*
	* @param string $URL    
	* @param string $Target
	*/
	function goto($URL,$Target="self")
	{
		if ($URL == "Back")
		{
			echo "<HTML>\n<HEAD>\n<TITLE>  </TITLE>\n<meta http-equiv=\"Content-Type\"  content=\"text/html; charset={$this -> Charset}\">\n</HEAD>\n<BODY>\n";
			echo "<Script Language=\"Javascript\">history.go(-1)</Script>";
		    echo "\n</body></html>";
		}
		elseif ($URL == "Back2")
		{
			echo "<HTML>\n<HEAD>\n<TITLE>  </TITLE>\n<meta http-equiv=\"Content-Type\"  content=\"text/html; charset={$this -> Charset}\">\n</HEAD>\n<BODY>\n";
			echo "<Script Language=\"Javascript\">history.go(-2)</Script>";
		    echo "\n</body></html>";
		}
		else
		{
			echo "<HTML>\n<HEAD>\n<TITLE>  </TITLE>\n<meta http-equiv=\"Content-Type\"  content=\"text/html; charset={$this -> Charset}\">\n</HEAD>\n<BODY>\n";
			if(!preg_match('/^http\:\/\//i',$URL)) $URL = site_url($URL);
			echo "<Script Language=\"Javascript\">".$Target.".location=\"".$URL."\"</Script>";
		    echo "\n</body></html>";
		}
	}
	
	//function goto
	
}