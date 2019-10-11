<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Пользователи';
$this->params['breadcrumbs'][] = $this->title;
//var_dump($dataProvider->role);
//die;
?>
<div class="user-index">

    <p>
        <?= Html::a('Добавить пользователя', ['create'], ['class' => 'btn btn-success']) ?>
    </p>



    <div style="height:10px;"></div>
    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'summary' => false,
        'columns' => [
            'id',
            [
                'attribute' => 'username',
                'label' => 'Логин',
            ],
 
            [
                'attribute' => 'status',
                'label' => 'Статус',
                'format' => 'raw',
                'value' => function ($model, $key, $index, $column) {
                    $status = $model->status;
                    if($status === \common\models\User::STATUS_INACTIVE){
                        $label_text = 'Неактивный';
                        $label_class = 'warning';
                    }elseif($status === \common\models\User::STATUS_ACTIVE){
                        $label_text = 'Активный';
                        $label_class = 'success';
                    }else{
                        $label_text = 'Заблокирован';
                        $label_class = 'danger;';
                    }
                    return \yii\helpers\Html::tag(
                                    'span',

                                    $label_text,
             
                                    [
                                        'class' => 'label label-' . $label_class,
                                    ]
                    );
                },
            ],
            'email:email',
            [
                'attribute' => 'role',
                'label' => 'Роль',
                'value' => 'role',
            ],
            ['attribute' => 'created_at',
                'format' => ['datetime', 'php:Y-m-d h:i:s'],
                'headerOptions' => ['width' => '200'],
                'label' => 'Дата создания',
            ],
            ['attribute' => 'updated_at',
                'format' => ['datetime', 'php:Y-m-d h:i:s'],
                'headerOptions' => ['width' => '200'],
                'label' => 'Дата редактирования',
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {lock} {delete}',
                'headerOptions' => ['width' => '300'],
                'buttons' => [
                    'update' => function ($url, $model, $key) {
                        return Html::a('Редактировать', $url) . ' / ';
                    },
                    'lock' => function ($url, $model, $key) {
                        if ($model->status !== 0) {
                            return Html::a('Заблокировать', $url, [
                                        'style' => 'color:#f39c12',
                                        'data' => [
                                            'confirm' => 'Вы уверены что хотите заблокировать пользователя ' . $model->username . '?',
                                            'method' => 'post',
                                        ],
                                    ]) . ' / ';
                        } else {
                            return Html::a('Разблокировать', Yii::$app->UrlManager->createUrl(['/user/unlock', 'id' => $model->id]), [
                                        'style' => 'color:#00c0ef',
                                        'data' => [
                                            'confirm' => 'Вы уверены что хотите разблокировать пользователя ' . $model->username . '?',
                                            'method' => 'post',
                                        ],
                                    ]) . ' / ';
                        }
                    },
                    'delete' => function ($url, $model, $key) {
                        return Html::a('Удалить', $url, [
                                    'style' => 'color:red',
                                    'data' => [
                                        'confirm' => 'Вы уверены что хотите удалить пользователя ' . $model->username . '?',
                                        'method' => 'post',
                                    ],
                        ]);
                    },
                ],
            ],
        ],
    ]);
    ?>
    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'layout' => '{summary}',
    ]);
    ?>
</div>