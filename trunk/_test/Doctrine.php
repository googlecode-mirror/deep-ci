<?php
## 一些常用的使用方法 ##

## return one
Doctrine_Core::getTable('SystemConfig')->findOneByKeyword($key); 

## return list
Doctrine_Core::getTable('SystemConfig')->findByKeyword($key);

## find by id
Doctrine_Core::getTable('Member')->find(1); // id 为 1 的会员。

## 于codeinteger 整合 
Doctrine_Core::getTable('Member')->getBySegment(3); # /member/info/4 id为4的会员

## query
$q = Doctrine_Query::create()
		->from('RankGroup')
		->where("member_id='{$member->id}'")
		->orderBy('id');
$q->fetchOne(); //return one
$q->execute();
$q->execute()->toArray();
$q->getSqlQuery();

## 判断
## 在查询一个的情况下 例如 find, findOne, fetchOne, getBySegment 
## 如果不存在 则返回 false
$member = Doctrine_Core::getTable('Member')->find(1);
if($member) {
	//do 
}
