<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Permission $model */

$this->title = 'Create Permission';
?>
<div class="permission-create">
    <h1><?= Html::encode($this->title) ?></h1>
    <?= $this->render('@frontend/views/site/permission/_form', ['model' => $model]) ?>
</div>
