<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
?>
<h1>test/index</h1>

<p>
    你能来到这里，说明你的用户名包含“test”
    
</p>
<p>
但是如果你的用户名包含“testing”，你将无法打开 
<?= Html::a('test/nottesting', ['test/nottesting']) ?>
</p>
