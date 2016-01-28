#验证的一些使用方法

# 修改默认显示的数据 #

默认代码
```
$validation = DeepCI::createValidation('PdoDomainCertificate', $domainCertificate->toArray());
```

修改显示的数据
```
$dataArr = $domainCertificate->toArray();
$dataArr['create_time'] = substr($dataArr['create_time'],0,10);
$dataArr['end_time']	= substr($dataArr['end_time'],0,10);

$validation = DeepCI::createValidation('PdoDomainCertificate', $dataArr);
```