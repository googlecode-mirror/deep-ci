# Result #
这里讨论一些 搜索(Select语句)后返回的结果。


$res = $q->fetchOne(); 和 $res = $q->execute(); 返回的都是对象。
$res->id 也是对象。


```
// 当没有结果时
$q->fetchOne(); // 返回 空NULL。 
$q->execute();  // 返回一个对象。不能直接用 if 判断，可以用 $q->count()==0 來判斷


## 在查询一个的情况下 例如 find(), findOne(), fetchOneBy()
## 如果不存在 则返回 false
$member = Doctrine::getTable('Member')->find(1);
if($member) {
	//do 
}
```

# Flush #

有時候 需要在執行過程中 flush 內容到數據庫。

```
## 發送數據
Doctrine_Manager::connection()->flush();
```

# Search #

```
## return one
Doctrine::getTable('Member')->findOneBy('keyword', $key); // findOneBy($fieldName, $value);
Doctrine::getTable('Member')->findOneByKeyword($key);  // 不要使用該方法，容易混淆

## return list
Doctrine::getTable('Member')->findBy('keyword', $key); // findBy($fieldName, $value);
Doctrine::getTable('Member')->findByKeyword($key); // 不要使用該方法，容易混淆

## find by id
Doctrine::getTable('Member')->find(1); // id 为 1 的会员。

## find all
Doctrine::getTable('Member')->findAll();

```

```
## query
$q = Doctrine_Query::create()
		->from('RankGroup')
		->where("member_id = ?", $member->id)
                ->andWhere("address_id = ?", 2)
		->orderBy('id');

$q->execute();
$q->execute()->toArray(); //return array
$q->getSqlQuery();// return SQL
$q->fetchOne(); // *return one or null*
$q->count(); // 返回符合條件的總數

## query 分頁相關
$q = Doctrine_Query::create()
		->from('RankGroup')
		->where("member_id = ?", $member->id)
		->orderBy('id')
                ->offset(10)
                ->limit(50);
```

### 直接使用SQL ###
为了性能方面的优化，可以直接使用SQL

```
//Note: If you want to select a specific connection first, then call:
//Doctrine_Manager::getInstance()->setCurrentConnection(’your_connection_name_1′);
// Get Doctrine_Connection object

$con = Doctrine_Manager::getInstance()->connection();

// SQL 
$sql = "select * from product";

// Execute SQL query, receive Doctrine_Connection_Statement
$st = $con->execute($sql);

// Fetch query result
$result = $st->fetchAll();
```

### Doctrine\_RawSql ###
官方手册提供的，执行Native SQL的方法。 这种方法会得到一个实例化的类（addComponent）。

```
$conn = Doctrine_Manager::connection();
$q = new Doctrine_RawSql($conn);

$q->select('{u.*}')
  ->from('user u')
  ->addComponent('u', 'User');

$users = $q->execute();
print_r($users->toArray());
```

# add, edit, delete #

```
$member = Doctrine::getTable('Member')->find(1);

$member->save(); // add & edit
$member->delete();//delete

//sql delete
$q = Doctrine_Query::create()
		->delete('Member')
		->where('id = ?', $id);
$q->execute();

//sql update
Doctrine_Query::create()
  ->update('User u')
  ->set('u.is_active', '?', true)
  ->where('u.id = ?', 1)
  ->execute();
```

# 表的关联 #

  * 当不使用时，不会执行查询语句，并调用。当使用时 才会被调用
  * 使用Left Join 语句是会自动调用

一些经验：　使用起来，感觉单独使用hasOne可以很方便，hasMany 在单独使用的时候感觉比较别扭。 不过在leftJoin的情况下除外。

```
# $Rank->Member , 不调用时不会查询， 当调用时才会自动查询。
$Rank->Member->usename;

# left join 时调用 
$q = Doctrine_Query::create()
      ->from('Rank r')
      ->leftJoin('r.Member m');
```

```
$this->hasOne('Member', array(
		'local' => 'member_id',
		'foreign' => 'id'
	)
);

$this->hasMany('Email', array(
		'local' => 'id',
		'foreign' => 'user_id'
	)
);
```

## 多對多 ##

local 是 本類id 對應 PdoVirtualHostM表中的字段

foreign 是 對應表的id 對應 PdoVirtualHostM表中的字段
```
// 必須兩個類都要配置正確
$this->hasMany('PdoVirtualHostServer as Servers', array(
		'refClass' => 'PdoVirtualHostM',
		'local' => 'virtual_host_id',
		'foreign' => 'virtual_host_server_id'
	)
);
```

調用
```
$m	= Model_VirtualHost::getTable()->find($i);

$m->Servers[0] = $virtualHostServer;
$m->save();
```

清除關聯
```
$member->unlink('VirtualHostServers');
$member->save();
```

## 注意 ##

```
$virtualHostServer->Service; // 這樣的調用，建議只在多表聯合查詢的時候是有（leftjoin）。 
$this->getService(); // 函數中， 不要使用 return $this->Service; *容易產生級聯保存的錯誤！！！ *
```

# Cache #
ORM确实方便开发，但是当使用过多的 使用复杂的数据关系，以及调用过多的查询相关，会明显慢下来。

  * 数据使用一个Sql语句查询。不在依赖定义的关系。
    * 由于使用leftjoin()时会会自动加载定义的关系， 所以可以把一些关系直接使用leftjoin()写出来，哪怕没有判断条件。
  * 使用Cache。
    * 注意cache的時間，這個cache只有过期后才会更新数据。

# 指定不同的數據庫 #

```
Doctrine_Manager::getInstance()->bindComponent('User', 'main')
User 使用 mian 連接
```

```
// 定义
$cacheConn = Doctrine_Manager::connection(new PDO('sqlite:'.VARPATH.'/cache.sqlite'));
$cacheDriver = new Doctrine_Cache_Db(array('connection' => $cacheConn, 'tableName' => 'cache'));
//$cacheDriver->createTable();//第一次使用时执行。

Doctrine_Manager::getInstance()->setAttribute(Doctrine_Core::ATTR_RESULT_CACHE, $cacheDriver);
Doctrine_Manager::getInstance()->setAttribute(Doctrine::ATTR_RESULT_CACHE_LIFESPAN, 1800);

// 使用
$q = Doctrine_Query::create()
	->from('RankLog')
	->where("rank_id={$this->id}")
	->orderBy('rank_order desc')
	->limit(2)
	->useResultCache(true)
	->setResultCacheLifeSpan(3600);
```

## 优点 ##

1、快速修改
```
$member->email = 'xxx@gmail.com';
$member->save();
```

2、关联性
```
// 假设相关关联已经设定好。
$domain->member; // 获取 domain 记录对应的 member 。 
$domain->member->username; // member 名称
$member->domain;
```

2、快速查取
```
Doctrine::getTable('Member')->find(1); // id 是 1 的会员
Doctrine::getTable('Member')->findBy('age', 20);  // age 是 20 的所有会员
Doctrine::getTable('Member')->findOneBy('email', 'xxx@gmail.com'); // 返回一个会员， 
```

## 級聯保存 ##

如果有個Order的表，對應的類如下
```
// 錯誤的調用Member記錄
// 如果有設定hasOne的關聯，可以直接用以下方法調用。
// 這樣做是為了利用關聯查詢，一次性查詢出來，以便提高性能，但是可能會出錯。關於性能參見下面的一節
function getMember() {
    return $this->Member;
}
```

在其他的頁面調用
```
$member = $order->getMember();

$order->state = 'ok';
$order->save(); // 當$member為空的時候就會出錯。Doctrine 會自動保存一個空的member記錄，這個時候很可能會出錯。
```



```
// 正確的調用Member記錄
function getMember() {
    // 重新查一下Member表。
}
```

## 查詢關聯&性能 ##

正確的關聯應該如下：
```
$this->hasOne('Forum_Board as Board', array(
  'local' => 'board_id',
  'foreign' => 'id'
 )
);


$this->hasMany('Phonenumber as Phonenumbers', array(
  'local' => 'id',
  'foreign' => 'user_id'
 )
);
```

在使用查詢的時候可以使用Leftjoin函數 來制定關聯數據庫，這樣就一次性查詢出來了。 待用的方式
```
$r->Board;
```
這樣可以節省性能。