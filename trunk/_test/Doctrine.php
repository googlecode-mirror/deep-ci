<?php
## һЩ���õ�ʹ�÷��� ##

## return one
Doctrine_Core::getTable('SystemConfig')->findOneByKeyword($key); 

## return list
Doctrine_Core::getTable('SystemConfig')->findByKeyword($key);

## find by id
Doctrine_Core::getTable('Member')->find(1); // id Ϊ 1 �Ļ�Ա��

## ��codeinteger ���� 
Doctrine_Core::getTable('Member')->getBySegment(3); # /member/info/4 idΪ4�Ļ�Ա

## query
$q = Doctrine_Query::create()
		->from('RankGroup')
		->where("member_id='{$member->id}'")
		->orderBy('id');
$q->fetchOne(); //return one
$q->execute();
$q->execute()->toArray();
$q->getSqlQuery();

## �ж�
## �ڲ�ѯһ��������� ���� find, findOne, fetchOne, getBySegment 
## ��������� �򷵻� false
$member = Doctrine_Core::getTable('Member')->find(1);
if($member) {
	//do 
}
