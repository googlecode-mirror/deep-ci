## 说明 ##
默认的表单验证使用 ASP.NET MVC 3 的 jquery.validate.unobtrusive.js 来实现。

php中加载方式

```
// 加載 validate.unobtrusive
$this->layout->loadJs('validate.unobtrusive');
```

### 概念及参考 ###
Unobtrusive JavaScript是一種將Javascript從HTML結構抽離的設計概念

Unobtrusive jQuery Validation內建支援的檢核規則(未包含creditcard及remote) 例子。

原文： http://blog.darkthread.net/post-2011-07-27-unobtrusive-jquery-validation.aspx

参考：
[Unobtrusive Client Validation in ASP.NET MVC 3(英文)](http://bradwilson.typepad.com/blog/2010/10/mvc3-unobtrusive-validation.html)
[Unobtrusive JavaScript in ASP.NET MVC 3](http://kb.cnblogs.com/page/80652/)

## 基本规则 ##

```
<div>
<input type="text" id="tReq" name="tReq" data-val="true" 
 data-val-required="不可空白" />
<span data-valmsg-for="tReq"></span>
</div>
<div>
<input type="text" id="tAccept" name="tAccept" value="a.doc" 
 data-val="true" data-val-accept="檔名須為.jpg、.gif或.png"
 data-val-accept-exts="jpg|gif|png" />
<span data-valmsg-for="tAccept"></span>
</div>
<div>
<input type="text" id="tRegex" name="tRegex" value="123-ABC@"
 data-val="true" data-val-regex="車牌格式須為999-999"
 data-val-regex-pattern="[0-9A-Z]{3}-[0-9A-Z]{3}" />
<span data-valmsg-for="tRegex"></span>
</div>
<div>
<input type="text" id="tDigit" name="tDigit" value="-1234"
 data-val="true" data-val-digits="只接受數字字元" />
<span data-valmsg-for="tDigit"></span>
</div>
<div>
<input type="text" id="tNum" name="tNum" value="-1,234.56A"
 data-val="true" data-val-number="必須為有效數字"/>
<span data-valmsg-for="tNum"></span>
</div>
<div>
<input type="text" id="tDate" name="tDate" value="X/01/X2000"
 data-val="true" data-val-date="必須為日期(僅粗略檢查)" />
<span data-valmsg-for="tDate"></span>
</div>
<div>
<input type="text" id="tEmail" name="tEmail" value="jeffrey @mail.com"
 data-val="true" data-val-email="必須為Email" />
<span data-valmsg-for="tEmail"></span>
</div>
<div>
<input type="text" id="tUrl" name="tUrl" value="http:// blog.darkthread.net"
 data-val="true" data-val-url="必須為有效網址" />
<span data-valmsg-for="tUrl"></span>
</div>
<div>
<input type="text" id="tLen" name="tLen" value="TTT"
 data-val="true" data-val-length="長度須介於4到8之間"
 data-val-length-min="4" data-val-length-max="8" />
<span data-valmsg-for="tLen"></span>
</div>
<div>
<input type="text" id="tRange" name="tRange" value="5"
 data-val="true" data-val-range="須介於10到100" 
 data-val-range-min="10" data-val-range-max="100" />
<span data-valmsg-for="tRange"></span>
</div>
<div>
<input type="text" id="tEq" name="tEq" value="99"
 data-val="true" data-val-equalto="必須與上方欄位內容相同"
 data-val-equalto-other="tRange" />
<span data-valmsg-for="tEq"></span>
</div>
```


## 自定义函数 ##

```
<script type="text/javascript">
	//加入自訂規則
	jQuery.validator.addMethod(
	//檢核規則名稱
		'myCheckSum',
		//實做檢查邏輯的函數，共有三個參數
		//value=欄位內容, elem為欄位元素, params為額外參數
		function (value, elem, params) {
			if (!value.match(/^\d{5}$/))
				return false;
			var sum = 0;
			for (var i = 0; i < 4; i++)
				sum += parseInt(value.charAt(i));
			return (sum % 10) == parseInt(value.charAt(4));
		},
		'' //可指定預設錯誤訊息，但在Unobstrusive做法中用不到
	);
	
	jQuery.validator.addMethod(
		"fixEqChk",
		//示範由params傳入額外參數的玩法
		//params會等於下方程式中，rules["fixedEqChk"]所指定的內容
		function (value, elem, params) {
			return value == params.chkValue;
		},
		""
	);

	//設定透過HTML掛載自訂規則的語法
	jQuery.validator.unobtrusive.adapters.add(
		'checksum', [],
		function (options) {
			options.rules["myCheckSum"] = true;
			options.messages['myCheckSum'] = options.message;
		}
	);
	
	jQuery.validator.unobtrusive.adapters.add(
		'fixeqchk', ['value'], //另外指定可用data-val-fixeqchk-value設定比對字串
		function (options) {
			//如果要傳參數給驗證函數，rules['...]會被傳送成上方addMethod裡
			//function(value, elem, params)中的params變數
			options.rules["fixEqChk"] = { chkValue: options.params.value };
			options.messages["fixEqChk"] = options.message;
		}
	);
</script>
```