# 说明 #
分页功能大部分功能都是自动生成。 以下说明是为了更方便的修改功能。

  * 快速搜索， 自动生成的查询数据库功能。
  * 排序， 列表排序
  * 分页， 最基本的分页 html code

# 快速搜索 #
不写php代码，快速生成Sql语句。是按照POST变量名称(key), 按照一定规则转换成Sql语句
```
<input type="text" name="username__like">
//转换成， 如果传递值为 howard
$sql .= " and username like 'howard'"
```

## 变量名称(key)命名规则 ##

```
格式1、 fieldname__rule // username__like , date__eq
格式2、 shorttablename_fieldname__rule // m_username__like member表(m 为定义的简写)username字段
格式3、 fieldname__rule__shorttablename // username__like__m 功能同上
```

shorttablename 必须是一个小的字母。

**格式2** 与 **格式3** 功能一样， 当符合 **格式3** 的匹配要求，则不再判断 **格式2** 。 **格式3** 是为了防止一些不符合要求的字段 例如 字段 'p\_price' 。这样就必须使用\*格式3

rules 见下面的表格。


## 命名规则关键字 ##

| **关键字** | **对应值** | **Key值** | **Sql例子** |
|:--------|:--------|:---------|:----------|
| like    | like    | `username__like` | username like 'howard'|
| eq      | =       | `date__eq` | date = '2010-10-10' |
| gt      | >       | `date__gt` | date > '2010-10-10' |
| gteq    | >=      | `date__gteq` | date >= '2010-10-10 |
| lt      | <       | `date__lt` | date < '2010-10-10 |
| lteq    | <=      | `date__lteq` | date <= '2010-10-10 |
| rlike   | `like xxx%` | usernamerlike | username like 'howard%' |
| llike   | `like %xxx` | usernamellike | username like '%howard' |
| flike   | `like %xxx%` | usernameflike | username like '%howard%' |

# 排序 #

```
<table class="tab_content sortabletable autoClass" sort_desc='m.id'>
  <tr>
	<th class="sort" sort_field="m.id">id</th>
	<th class="sort" sort_field="username">username</th>
	<th class="sort" sort_field="passowrd">passowrd</th>
	<th class="sort" sort_field="email">email</th>
	<th class="sort" sort_field="create_date">create_date</th>
	<th class="tal">操作</th>
  </tr>

  ... ...

</table>
```

  * table 必須加入CSS樣式  sortabletable  。
  * sort\_desc='m.id' 表示 字段m.id 倒序排列， 升序表示 sort\_asc='m.id'
    * m.id 表示 m 表的 字段id
    * 該部份是由PHP生成的。 `$pageBar['sort'];` 可以參考下面例子。
  * th 必須有 CSS樣式 class="sort"
    * 如果某列不用 則去掉 CSS樣式 sort
    * sort\_field="username" 表示該欄位對應的字段名稱 username

View頁面 PHP代碼
```
<table class="tab_content sortabletable autoClass" <?php echo $pageBar['sort'];?>>
```

# 分页 #

```
// search data
$this->ViewBag['sData'] = DeepCI::getSearchData();

// query dql
$q = Doctrine_Query::create()
		->from('PdoMember m')
		->orderBy('id desc');

// pageBar
$pageBar = DeepCI::getPageBar($q, $offset);
// echo $pageBar->getSqlQuery();

$this->ViewBag['listRows']	= $pageBar->getResult();
$this->ViewBag['pageBar']	= $pageBar->getHtml();
```

  * `$pageBar->getResult();` 數據庫查詢結果。
  * `$this->ViewBag['pageBar']	= $pageBar->getHtml();` 分頁相關HTML代碼
    * `$pageBar['sort']` 排序方案 例如 `sort_desc='m.id'`
    * `$pageBar['html']` 分頁HTML代買，顯示共多少頁，當前第幾頁等。
    * `$pageBar['select']` 一個下拉菜單，顯示該頁顯示多少條數據。

## 特殊查询 ##
当有特殊查询的时候可以修改 dql
```
// query dql
$q = Doctrine_Query::create()
		->from('PdoMember m')
		->orderBy('id desc');
```

## 特殊判断 ##
当有字段的特殊判断时 , 可以手动添加判断
```
// search data
$sData  = DeepCI::getSearchData();
$this->ViewBag['sData'] = $sData;

if($sData->username!='xxx') {
    page_message_error('index', '用户名不能为xxx');
}
```