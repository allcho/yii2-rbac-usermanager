<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = 'Create Role or Permission';
$this->params['breadcrumbs'][] = ['label' => 'Role', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="role-create-form">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(); ?>

       <div class="row">
        <div class="col-md-2">
            <?= $form->field($model, 'role')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'type')->dropDownList(['1' => 'Role', '2' => 'Permission']); ?>
            <?= $form->field($model, 'desc')->textInput(['maxlength' => true]); ?>
             <?= $form->field($model, 'parent')->dropDownList(yii\helpers\ArrayHelper::map($roles, 'name', 'children')); ?>
       </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton('Create', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
