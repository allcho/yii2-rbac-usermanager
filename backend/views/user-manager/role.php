<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Roles';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-role">

    <p>
        <?= Html::a('Create role', ['role-create'], ['class' => 'btn btn-success']) ?>
    </p>



    <div style="height:10px;"></div>
    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'summary' => false,
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
                                    'Роль',
                                    [
                                        'class' => 'label label-success' ,
                                    ]
                    );
                },
            ],
        ],
    ])
    ?>
    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'layout' => '{summary}',
    ]);
    ?>

</div>