# 使用手册

0. 安装项目依赖和 `ChromeDriver` （建议使用 Docker 环境）。

```bash
composer install
```

ChromeDriver 下载地址：http://chromedriver.chromium.org/

1. 修改配置文件 `.env`。

ChromeDriver 安装位置，例如 `CHROME_DRIVER=/usr/local/bin/chromedriver`。

2. 开始使用。 

主要文件为 `app/Console/Commands/VvvdjDl.php`。

```bash
php artisan vvvdj:dl 'http://www.vvvdj.com/radio/3454.html'
```

目前仅支持 `http://www.vvvdj.com/radio/...` 地址。
