<?php

use yii\helpers\Html;
/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>
<div class="site-index">
<h1>site/index</h1>

<p>
    谁都可以打开这个页面，这并不稀奇    
</p>
<p>
但是只有你的用户名包含“test”，你才能打开 
<?= Html::a('test/index', ['test/index']) ?>
</p>

</div>
