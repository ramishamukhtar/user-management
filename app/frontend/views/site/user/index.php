<?php

use yii\grid\GridView;
use yii\helpers\Html;

/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p><?= Html::a('Create User', ['create'], ['class' => 'btn btn-success']) ?></p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'username',
            'email',
            [
                'attribute' => 'role_id',
                'label' => 'Role',
                'value' => function($model) { return $model->role ? ucfirst($model->role->name) : '-'; }
            ],
            [
                'attribute' => 'status',
                'value' => function($model) { return $model->status == 10 ? 'Active' : 'Inactive'; }
            ],

            ['class' => 'yii\grid\ActionColumn', 'template' => '{view} {update} {delete}'],
        ],
    ]); ?>
</div>
