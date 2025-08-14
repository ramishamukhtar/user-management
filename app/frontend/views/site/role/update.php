<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Role $model */

$this->title = 'Update Role: ' . $model->name;
?>
<div class="role-update">
    <h1><?= Html::encode($this->title) ?></h1>
    <?= $this->render('@frontend/views/site/role/_form', ['model' => $model]) ?>
</div>
