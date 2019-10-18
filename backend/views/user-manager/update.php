<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\User */
$this->title = 'Update user: ' . $model->username;
$this->params['breadcrumbs'][] = ['label' => 'User', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->username, 'url' => ['update', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="user-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(); ?>

       <div class="row">
        <div class="col-md-2">
            <?= $form->field($profile, 'username')->textInput(['maxlength' => true]) ?>
            <?= $form->field($profile, 'email')->textInput(['maxlength' => true]) ?>
            <?= $form->field($profile, 'role')->dropDownList(yii\helpers\ArrayHelper::map($roles, 'name', 'name')); ?>
            <?= $form->field($profile, 'password')->textInput(['maxlength' => true, 'id'=>'random']); ?>
       </div>
        <div class="col-md-10">
            <a id="generate" style="line-height: 6; cursor: pointer;">Generate</a>
        </div>
    
    </div>
    <div class="form-group">
        <?= Html::submitButton('Create', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>


</div>
