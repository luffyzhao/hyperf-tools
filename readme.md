# laravel erp管理后台权限认证

### 安装

>  composer require luffyzhao/hyperf-tools

#### 发布配置文件
> php bin/hyperf.php vendor:publish luffyzhao/hyperf-tools


#### 管理模块
> php bin/hyperf.php gen:repository

> php bin/hyperf.php gen:search

> php bin/hyperf.php gen:service

#### jwt 配置

> php bin/hyperf.php gen:jwt-secret
> php bin/hyperf.php gen:jwt-keypair

#### .env 文件
```angular2html
JWT_BLACKLIST_GRACE_PERIOD=5  设置宽限期（以秒为单位）以防止并发请求失败。
JWT_TTL=3600 指定令牌有效的时长（以秒为单位）。默认为 1 小时
```
