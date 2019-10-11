<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\User */
allcho\rbac\backend\assets\UsermanagerAsset::register($this);
$this->title = 'Редактирование пользователя: ' . $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Пользователь', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->username, 'url' => ['update', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактирование';
?>
<div class="user-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'password' => $password,
    ]) ?>

</div>
