# 定制yii2的权限控制

基于yii2-advanced模板

## 启动此项目

### 迁出

```
git clone xxx
cd xxx
```

### 初始化环境，选dev可以看调试信息

```
./init
```

### 准备好mysql数据库，填好配置

`common/config/main-local.php`

```
<?php
return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=test',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
    ],
];
```

### 初始化数据库

```
./yii migrate
```

### 启动服务并体验

```
./yii serve --docroot="frontend/web/"
```

## 核心代码解释

`frontend/controllers/TestController`

```
<?php
namespace frontend\controllers;
use yii\filters\AccessControl;
use Yii;

class TestController extends \yii\web\Controller
{
    //使用behaviors，权限控制只是behavior的一种，了解更多：http://www.digpage.com/behavior.html
    public function behaviors()
    {
        return [
            'access' => [
                //使用AccessControl类来管理权限，了解更多：https://www.yiiframework.com/doc/api/2.0/yii-filters-accesscontrol
                'class' => AccessControl::className(),
                'rules' => [                    
                    [
                        //规则这里只指定了allow，没有指定action，默认为应用所有action， 了解更多：https://www.yiiframework.com/doc/api/2.0/yii-filters-accessrule
                        'allow' => true,

                        //使用一个回调来决定是否应用此规则，了解更多：https://www.yiiframework.com/doc/api/2.0/yii-filters-accessrule#$matchCallback-detail
                        'matchCallback' => function ($rule, $action) {
                            //登录才能访问
                            if(Yii::$app->user->isGuest){
                                return false;
                            }                            
                            
                            //只有用户名包含test的用户才能访问
                            $user = Yii::$app->user->getIdentity();
                            if(strpos($user->username,'test')>=0){
                                
                                //nottesting不允许包含testing的用户访问
                                if($action->id =='nottesting' && strpos($user->username,'testing')>=0){
                                    return false;
                                }  

                                return true;
                            }                              
                        },
                    ],
                ],
            ],
        ];
    }
    public function actionIndex()
    {
        return $this->render('index');
    }    
    public function actionNottesting()
    {
        return $this->render('nottesting');
    }
}

```