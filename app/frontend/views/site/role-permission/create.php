<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\RolePermission $model */

$this->title = 'Create Role Permission';
?>
<div class="role-permission-create">
    <h1><?= Html::encode($this->title) ?></h1>
    <?= $this->render('@frontend/views/site/role-permission/_form', ['model' => $model]) ?>
</div>
