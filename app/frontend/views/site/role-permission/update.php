<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\RolePermission $model */

$this->title = "Update Role Permission: Role {$model->role_id} - Permission {$model->permission_id}";
?>
<div class="role-permission-update">
    <h1><?= Html::encode($this->title) ?></h1>
    <?= $this->render('@frontend/views/site/role-permission/_form', ['model' => $model]) ?>
</div>
