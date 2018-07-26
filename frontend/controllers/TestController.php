<?php

namespace frontend\controllers;

use yii\filters\AccessControl;
use Yii;

class TestController extends \yii\web\Controller
{

     /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [                    
                    [
                        'allow' => true,
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
