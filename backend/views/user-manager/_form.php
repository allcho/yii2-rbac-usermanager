<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="user-form">
<?php if ($model->status == '0'){
    
   echo  '<h2 style="color:red;"> Пользователь ЗАБЛОКИРОВАН!!!</h2>';
}
?>
    <?php $form = ActiveForm::begin(); ?>

       <div class="row">
        <div class="col-md-2">
            <?= $form->field($model, 'username')->textInput(['readonly' => true])->label('Логин') ?>
            <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
            <?= $form->field($password, 'password')->textInput(['maxlength' => true, 'id'=>'random'])->label('Изменить пароль'); ?>
       </div>
        <div class="col-md-10">
            <a id="generate" style="line-height: 6; cursor: pointer;">Генерация пароля!</a>
        </div>
    
    </div>
<div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
         <?php
//         if ($model->userRole !== 'Администратор'){
//                if($model->status != '0'){
//                   echo Html::a('Заблокировать', ['lock', 'id' => $model->id], [
//                       'class' => 'btn btn-warning',
//                       'data' => [
//                           'confirm' => 'Вы уверены что хотите Заблокировать этого пользователя?',
//                           'method' => 'post',
//                       ],
//                    ]);
//
//                }else{
//                     echo Html::a('Разблокировать', ['unlock', 'id' => $model->id], [
//                   'class' => 'btn btn-info',
//                   'data' => [
//                       'confirm' => 'Вы уверены что хотите Разблокировать этого пользователя?',
//                       'method' => 'post',
//                   ],
//                 ]);
//                }
//                
//                echo Html::a('Удалить', ['delete', 'id' => $model->id], [
//                       'class' => 'btn btn-danger',
//                       'style'=> 'margin-left: 5px;',
//                       'data' => [
//                           'confirm' => 'Вы уверены что хотите Удалить этого пользователя?',
//                           'method' => 'post',
//                       ],
//                    ]);
//         }?>
    </div>

    <?php ActiveForm::end(); ?>

</div>