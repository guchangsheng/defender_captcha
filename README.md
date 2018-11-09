
 Captcha for Lumen 兼容支持lumen 5.5 

基于 [Captcha for Laravel 5](https://github.com/mewebstudio/captcha) 和 [lumen-captcha](https://github.com/aishan/lumen-captcha)
的修正


#启用cache###env配置如下
CACHE_DRIVER=redis
REDIS_HOST=127.0.0.1
REDIS_PORT=
REDIS_PASSWORD=

####config配置文件
*拷贝config目录下的captcha.php image.php到那项目config目录

##注册
#bootstrap目录下的app.php添加如下
$app->configure('image');
$app->configure('captcha');
$app->register(Yangbx\CaptchaLumen\CaptchaServiceProvider::class);

## Preview
![Preview](http://i.imgur.com/HYtr744.png)

###创建路由

  /************/
    $api->group(['namespace' => 'Yangbx\CaptchaLumen'],function($api){
        //验证码
        $api->get('Info/{type}', ['as' => 'captcha', 'uses' => 'LumenCaptchaController@getCaptchaInfo']);
        $api->get('captcha/{type}/{captchaId}', ['uses' => 'LumenCaptchaController@getCaptcha']);
      
    });
## Links
* [Intervention Image](https://github.com/Intervention/image)
* [L5 Captcha on Github](https://github.com/mewebstudio/captcha)
* [L5 Captcha on Packagist](https://packagist.org/packages/mews/captcha)
* [For L4 on Github](https://github.com/mewebstudio/captcha/tree/master-l4)
* [License](http://www.opensource.org/licenses/mit-license.php)
* [Laravel website](http://laravel.com)
* [Laravel Turkiye website](http://www.laravel.gen.tr)
* [MeWebStudio website](http://www.mewebstudio.com)
