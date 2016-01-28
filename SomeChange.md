# CodeIgniter #

textarea 多出來換行為題

~/system/core/Input.php 文件中
```
$str = str_replace(array("\r\n", "\r"), PHP_EOL, $str);
```

更改為

```
$str = preg_replace('/(?:\r\n|[\r\n])/', PHP_EOL, $str);
```

參考 https://bitbucket.org/ellislab/codeigniter-reactor/issue/108/standardize-newlines-bug