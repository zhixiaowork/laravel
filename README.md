<p align="center"><img src="https://res.cloudinary.com/dtfbvvkyp/image/upload/v1566331377/laravel-logolockup-cmyk-red.svg" width="400"></p>


## Laravel 开箱即用框架

**演示地址:[http://laravel.iat.net.cn](http://laravel.iat.net.cn)**

## 功能说明

### 后台

* 整合[Ant Design](https://ant.design/)前端框架
* 登录、忘记密码、重置密码
* 用户管理
* 角色管理
* 管理员管理
* 日志记录
* 日志管理
* 错误页面
* 图片上传、管理
* 微信公众号配置

### 前台

* 登录
* 日志记录

### api

* api封装
* 日志记录

### 微信公众号

* 授权登录
* 菜单
* 自定义回复

### 微信小程序

* 授权登录
* 开箱即用框架[weapp](https://github.com/zhixiaowork/weapp)

## 安装说明

1、clone代码

    git clone https://github.com/zhixiaowork/laravel.git
     
2、修改权限

    chmod -R 777 storage
    chmod -R 777 bootstrap/cache
    
3、安装依赖

    composer install
    
4、数据迁移
    
    cp .env.example .env

5、数据导入
    
    导入根目录下laravel.sql文件
   
6、nginx配置
    
    server {
        listen 80;
    
        root /var/www/html/laravel/public; // 代码路径
        index index.php index.html;
    
        server_name laravel.dev; // 域名
    
        location / {
            try_files $uri $uri/ /index.php?$query_string;
        }
    
        location ~ \.php$ {
            fastcgi_pass   unix:/var/run/php/php7.2-fpm.sock;
            fastcgi_index  index.php;
            fastcgi_param  SCRIPT_FILENAME  $document_root$fastcgi_script_name;
            include        fastcgi_params;
        }
    }
    
7、访问

* 首页 http://laravel.dev
    
* 后台: http://laravel.dev/admin

  * 账号: admin
  * 密码: admin


8、部署改进事项

    * 自动加载器改进

    当你准备往生产环境部署应用时，确保你优化了你的 Composer 类的自动加载映射，这样可以使 Composer 可以很快的找到正确的加载文件去加载给定的类:

    `composer install --optimize-autoloader --no-dev`

    小提示：除了优化自动加载器，你还应该确保在你的项目代码仓库中包含了 composer.lock 这个文件。当你的项目代码中有 composer.lock 这个文件时，便可以更快的安装项目中需要的依赖项。


    * 优化配置加载

    当你将应用程序部署到生产环境时，你应当确保在你部署过程中运行 config:cache Artisan 命令：

    `php artisan config:cache`

    此命令将所有 Laravel 的配置文件合并到一个缓存文件，这将极大地减少框架在加载配置值时必须对文件系统进行访问的次数。

    注意：如果在你部署过程中执行 config:cache 命令，你应当确保你仅从你的配置文件中调用 env 函数。一旦配置被缓存，.env 文件将不被加载并且对 env 函数的所有调用将返回 null。


    * 优化路由加载

    如果你想构建具有许多路由的大型应用程序，你应当确保在部署的过程中运行 route:cache Artisan 命令：

    `php artisan route:cache`

    此命令将为所有路由注册缩减到一个缓存文件中的单个方法调用，从而在注册数百个路由时提高了路由注册的性能。

    注意：由于此功能使用 PHP 序列化，你仅能缓存专门使用基于控制器路由的应用程序路由。PHP 不能序列化闭包路由。


    * 优化 View 加载

    当你把你的应用程序部署到生产环境，你应当确保在部署过程中运行 view:cache Artisan 命令:

    `php artisan view:cache`
    此命令预编译了所有的 Blade views，因此不会按需编译它们，从而提高了每个返回 view 请求的性能。


## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
