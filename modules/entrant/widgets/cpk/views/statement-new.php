<?php

use yii\grid\ActionColumn;
use modules\entrant\helpers\DateFormatHelper;
use backend\widgets\adminlte\grid\GridView;
use modules\entrant\helpers\SelectDataHelper;
use modules\entrant\helpers\StatementHelper;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    [
                        'attribute' => 'user_id',
                        'value'=> 'profileUser.fio'

                    ],
                    [
                        'attribute' => 'faculty_id',
                        'value' => 'faculty.full_name'
                    ],
                    [
                        'attribute' => 'speciality_id',
                        'value' => 'speciality.codeWithName'
                    ],
                    [
                        'attribute' => 'edu_level',
                        'value'=>'eduLevel',
                    ],
                    [
                        'attribute' => 'created_at',
                        'format' => 'datetime',
                    ],
                    [
                        'class' => \modules\entrant\searches\grid\StatementColumn::class,
                    ],
                    ['value' => function ($model) {
                        return $model->status == StatementHelper::STATUS_WALT ||
                                $model->status == StatementHelper::STATUS_WALT_SPECIAL ?
                            Html::a(Html::tag('span', '', ['class'=>'glyphicon glyphicon-ok']),
                                ['data-entrant/communication/export-statement',
                                    'user' => $model->user_id, 'statement' => $model->id],
                                ['data-method' => 'post', 'class' => 'btn btn-success']) : '';
                    }, 'format'=> 'raw' ],
                    ['class' => ActionColumn::class, 'controller' => 'data-entrant/statement', 'template' => '{view}']
                ],
            ]); ?>
