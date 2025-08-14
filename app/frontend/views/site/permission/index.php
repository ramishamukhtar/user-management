<?php

use yii\helpers\Html;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Permissions';
?>
<div class="permission-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <p><?= Html::a('Create Permission', ['create'], ['class' => 'btn btn-success']) ?></p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            'name',
            'parent_id',
            'route',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
