<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

$this->title = $name;

$data = [
    'name'=>$name,
    'message'=>$message,
    'exception'=>$exception,
];

if($exception->statusCode == 403){    
     echo $this->render('error/403');
     return;
}

echo $this->render('error/default');
?>
