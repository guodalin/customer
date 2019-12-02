## AIO基础套件 (ALL IN ONE BASE)

91360 PHP 项目组基于 [Laravel Boilerplate](http://laravel-boilerplate.com) 开发的整体一致性软件

### Demo Credentials

**User:** admin@admin.com
**Password:** secret

### Official Documentation

[Click here for the official documentation](http://laravel-boilerplate.com)

### 简介

我们使用了 [Laravel Boilerplate](http://laravel-boilerplate.com) (基于 Laravel) 作为程序的中层应用，以此开发符合我们业务需求的软件应用。

我们在此基础上逐步开发了 视频，会议，网盘等组件，后期将着手将其真正组件化(基于 composer).

程序包含了基础的用户管理，权限管理，日志管理，第三方（微博，QQ，微信）社交账户并支持使用用户名，邮箱，手机号码登录.

### 安装

1. 使用 `git clone` 创建项目
2. 进入项目根目录 执行 `composer install` 和 `npm i` (安装composer 和 npm 依赖)
3. 执行 `composer run post-root-package-install` 安装程序的环境变量并作相应的设置 （数据库连接，项目名称等）
4. 执行 `composer run post-create-project-cmd` 安装程序密钥
5. 执行 `php artisan storage:link` 建立存储文件映射
6. 执行 `php artisan migrate --seed` 导入数据库和种子文件 （需要先创建数据库，推荐使用 utf8mb 编码）
7. 执行 `php artisan geoip:update` 更新 IP 数据库
8. 执行 `php artisan self-diagnosis` 自检程序，确保没有错误
9. (生产环境) 执行 `php artisan optimize` 缓存系统启动文件
10. (生产环境) 执行 `php artisan config:cache` 缓存配置文件
11. (生产环境) 执行 `php artisan route:cache` 缓存路由文件
12. (生产环境) 执行 `php artisan view:cache` 缓存视图文件
13. (生产环境) 执行 `npm run prod` (打包前端脚本)
14. ... 根据需要安装符合本框架的各类组件 （用户中心, 视频, 会议, 切片等)

> 系统内置了三个账户
>
> 1. 超级管理员 admin@admin.com/secret
> 2. 后台管理员 executive@executive.com/secret
> 3. 普通用户 user@user.com/secret

### Issues

如遇到任何问题请访问并 [提交到这里](https://git.comc.91360.com/php/aio-base/issues).

### Contributing

Thank you for considering contributing to the Laravel Boilerplate project! Please feel free to make any pull requests, or e-mail me a feature request you would like to see in the future to Anthony Rappa at rappa819@gmail.com.

### Security Vulnerabilities

If you discover a security vulnerability within this boilerplate, please send an e-mail to Anthony Rappa at rappa819@gmail.com, or create a pull request if possible. All security vulnerabilities will be promptly addressed.

### License

MIT: [http://anthony.mit-license.org](http://anthony.mit-license.org)
