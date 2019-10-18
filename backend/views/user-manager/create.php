<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = 'Create User';
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(); ?>

       <div class="row">
        <div class="col-md-2">
            <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'role')->dropDownList(yii\helpers\ArrayHelper::map($roles, 'name', 'name')); ?>
            <?= $form->field($model, 'password')->textInput(['maxlength' => true, 'id'=>'random']); ?>
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
