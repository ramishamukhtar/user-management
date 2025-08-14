<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var common\models\User $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'email')->textInput(['maxlength' => true, 'type' => 'email']) ?>
    <?= $form->field($model, 'password')->passwordInput() ?>
    <?= $form->field($model, 'status')->dropDownList([10 => 'Active', 0 => 'Inactive']) ?>
    <?= $form->field($model, 'role_id')->dropDownList(
        \yii\helpers\ArrayHelper::map(\common\models\Role::find()->where(['<>', 'name', 'admin'])->all(), 'id', 'name'),
        ['prompt' => 'Select Role']
        
    ) ?>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
