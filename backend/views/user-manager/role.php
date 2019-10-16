<?php 

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel common\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Пользователи';
$this->params['breadcrumbs'][] = $this->title;
//var_dump($dataProvider->role);
//die;
//print_r($roles);
?>
<div class="user-role">

    <p>
        <?= Html::a('Добавить новую роль', ['create'], ['class' => 'btn btn-success']) ?>
    </p>



    <div style="height:10px;"></div>
  <?= GridView::widget([
    'dataProvider' => $model,
    'columns' => [
        'name',
        'description',
        [
        'attribute' => 'type', 
        'label' => 'Тип',
       'format' => 'raw',

        'value' => function ($model, $key, $index, $column) {
            $status = $model->type === 1;
            return \yii\helpers\Html::tag(
                'span',
                $status ? 'Роль' : 'Разрешение',
                [
                    'class' => 'label label-' . ($status ? 'success' : 'danger'),

                ]
            );
            },

        ],
    ],
]) ?>

</div>