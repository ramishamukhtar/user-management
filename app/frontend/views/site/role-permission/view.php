<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\RolePermission $model */

$this->title = "Role {$model->role_id} - Permission {$model->permission_id}";
?>
<div class="role-permission-view">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a('Update', ['update', 'role_id' => $model->role_id, 'permission_id' => $model->permission_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'role_id' => $model->role_id, 'permission_id' => $model->permission_id], [
            'class' => 'btn btn-danger',
            'data' => ['confirm' => 'Are you sure?', 'method' => 'post'],
        ]) ?>
    </p>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => ['role_id', 'permission_id'],
    ]) ?>
</div>
