<?php

use yii\helpers\Html;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Role Permissions';
?>
<div class="role-permission-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <p><?= Html::a('Create Role Permission', ['create'], ['class' => 'btn btn-success']) ?></p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'role_id',
            'permission_id',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
