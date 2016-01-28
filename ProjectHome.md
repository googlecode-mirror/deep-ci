# 简介 #
这不是一个新的Framwork。

是工作中为了方便快速的开发、基本功能的重用的总结。

是PHP中使用ORM快速开发的实践。


---


新增功能：

  * 自動生成列表、新增、修改、刪除功能。 根据 `Doctrine_Core::generateModelsFromDb` 生成Model。
  * 快速搜索功能。 `<input name="username__like" ` php自动翻译成 `username like 'xxx'`
  * 列表排序功能。
  * [分页](PageBar.md) 整合 CI pagination 以及 `Doctrine_Pager`
  * Validation -- PHP jQuery.validation ORM 之间的自动生成以及验证。（使用的是aps.mvc 3 中的jquery.validate.unobtrusive.js，僅供學習用。）


---


使用方法：
  * 配置好CI （訪問路徑）
  * 配置好數據庫 （必須）
  * 通過瀏覽器訪問 deepci\_helper Controller。 例如 http://localhost/deepci/deepci_helper


---


  * PHP 5.2.3+
    * MVC: Farmwork CodeIgniter (2.0)
    * ORM: Doctrine (1.2)
    * Javascript Based: Jquery