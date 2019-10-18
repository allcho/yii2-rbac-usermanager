<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <p>
        <?= Html::a('Create user', ['create'], ['class' => 'btn btn-success']) ?>
    </p>



    <div style="height:10px;"></div>
    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'summary' => false,
        'columns' => [
            'id',
            'username',
 
            [
                'attribute' => 'status',
                'label' => 'Status',
                'format' => 'raw',
                'value' => function ($model, $key, $index, $column) {
                    $status = $model->status;
                    if ($status === \common\models\User::STATUS_INACTIVE) {
                        $label_text = 'Not active';
                        $label_class = 'warning';
                    } elseif ($status === \common\models\User::STATUS_ACTIVE) {
                        $label_text = 'Active';
                        $label_class = 'success';
                    } else {
                        $label_text = 'Block';
                        $label_class = 'danger';
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
            'role',
                        
            ['attribute' => 'created_at',
                'format' => ['datetime', 'php:Y-m-d h:i:s'],
                'headerOptions' => ['width' => '200'],
                'label' => 'Created date',
            ],
            ['attribute' => 'updated_at',
                'format' => ['datetime', 'php:Y-m-d h:i:s'],
                'headerOptions' => ['width' => '200'],
                'label' => 'Updated date',
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'header' => 'Actions',
                'headerOptions' => ['width' => '80'],
                'template' => '{update}{lock}{delete}',
                'buttons' => [
                    'lock' => function ($url, $model, $key) {
                        if ($model->status !== 0) {
                            return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
                                        'style' => 'padding:0 10px',
                                        'title' => 'lock',
                                        'data' => [
                                            'confirm' => 'Do you want block ' . $model->username . '?',
                                            'method' => 'post',
                                        ],
                            ]);
                        } else {
                            return Html::a('<span class="glyphicon glyphicon-eye-close"></span>', Yii::$app->UrlManager->createUrl(['/usermanager/unlock', 'id' => $model->id]), [
                                        'style' => 'padding:0 10px; color:red;',
                                        'title' => 'unlock',
                                        'data' => [
                                            'confirm' => 'Do you want unlock  ' . $model->username . '?',
                                            'method' => 'post',
                                        ],
                                    ]);
                        }
                    },
                    'delete' => function ($url, $model, $key) {                   
                            return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                                        'title' => 'delete',
                                        'data' => [
                                            'confirm' => 'Do you want delete ' . $model->username . '?',
                                            'method' => 'post',
                                        ],
                            ]);
                    },
                ]
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