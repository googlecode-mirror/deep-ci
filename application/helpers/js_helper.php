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
				echo '<script type="text/javascript" src="'.$jsUrl.'lib/jquery.validate.unobtrusive.min.js"></script>'."\n";
				break;
			case 'validate.unobtrusive':
				echo '<link href="'.$jsUrl.'lib/jquery.validate/style.css" rel="stylesheet" type="text/css" />'."\n";
				echo '<script type="text/javascript" src="'.$jsUrl.'lib/jquery.validate.min.js"></script>'."\n";
				echo '<script type="text/javascript" src="'.$jsUrl.'lib/jquery.validate.unobtrusive.min.js"></script>'."\n";
				break;
			case 'greybox':
				$s = '<script type="text/javascript">var GB_ROOT_DIR = "'.$jsUrl.'lib/greybox/";</script>'."\n";
				$s .= '<script type="text/javascript" src="'.$jsUrl.'lib/greybox/AJS.js"></script>'."\n";
				$s .= '<script type="text/javascript" src="'.$jsUrl.'lib/greybox/AJS_fx.js"></script>'."\n";
				$s .= '<script type="text/javascript" src="'.$jsUrl.'lib/greybox/gb_scripts.js"></script>'."\n";
				$s .= '<link href="'.$jsUrl.'lib/greybox/gb_styles.css" rel="stylesheet" type="text/css" />'."\n";
				echo $s;
				break;
			case 'Wdate':
				echo '<script type="text/javascript" src="'.$jsUrl.'lib/My97DatePicker/WdatePicker.js"></script>'."\n";
				break;
			case 'jNotify':
				echo '<link href="'.$jsUrl.'lib/jquery.jnotify/style.css" rel="stylesheet" type="text/css" />'."\n";
				echo '<script type="text/javascript" src="'.$jsUrl.'lib/jquery.jnotify.js"></script>'."\n";
				break;
			default:
				echo '<script type="text/javascript" src="'.$jsUrl.$jsLibrary.'.js"></script>'."\n";
				break;
		}
	}
}