<?php


use kartik\date\DatePicker;
use modules\entrant\helpers\SelectDataHelper;
use modules\management\models\DictTask;
use modules\management\models\ManagementUser;
use modules\management\models\Schedule;
use modules\management\models\Task;
use yii\grid\ActionColumn;
use yii\helpers\Html;
use backend\widgets\adminlte\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel modules\management\searches\TaskUserSearch*/


$string = $searchModel->overdue ? ($searchModel->overdue == 'no' ? ". Актуальные" : ". Просроченные") :"";
$this->title = 'Задачи'.$string;
$this->params['breadcrumbs'][] = $this->title;
?>
<div>
    <div class="box">
        <div class="box-header">
            <?= Html::a('Создать', ['task/create'], ['class' => 'btn btn-success']) ?>
        </div>
        <div class="box-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel'=> $searchModel,
                'afterRow' => function (Task $model, $index, $grid) {
                    return '<tr><td colspan="7">'.($model->isStatusDone() ? Html::a('Доработка', ['task/rework', 'id' => $model->id, 'status' =>
                                Task::STATUS_REWORK],['class'=> "btn btn-info btn-block",   'data-pjax' => 'w1', 'data-toggle' => 'modal', 'data-target' => '#modal', 'data-modalTitle' => 'Причина доработки']).
                            Html::a('Приянто в срок', ['task/status', 'id' => $model->id, 'status' =>
                                Task::STATUS_ACCEPTED_TO_TIME],['class'=> "btn btn-success", 'data-confirm'=> "Вы уверены, что хотите изменить статус?"]).
                            Html::a('Принято с просроченной', ['task/status', 'id' => $model->id, 'status' =>
                                Task::STATUS_ACCEPTED_WITCH_OVERDUE],['class'=> "btn btn-warning", 'data-confirm'=> "Вы уверены, что хотите изменить статус?"]).
                            Html::a('Не принято', ['task/status', 'id' => $model->id, 'status' =>
                                Task::STATUS_NOT_EXECUTED],['class'=> "btn btn-danger", 'data-confirm'=> "Вы уверены, что хотите изменить статус?"]) : "").'</td></tr>';
                },
                'columns' => [
                    ['class' => ActionColumn::class,
                        'controller' => "task",
                        'template' => '{view}',
                    ],
                    ['class' => \yii\grid\SerialColumn::class],
                    ['attribute' => 'director_user_id',
                        'format' => "raw",
                        'filter' =>SelectDataHelper::dataSearchModel($searchModel, ManagementUser::find()->allColumn(),'director_user_id', 'directorProfile.fio'),
                        'value' => function($model) {
                            return $model->directorProfile->fio."<br />".$model->directorProfile->phone."<br />".$model->directorSchedule->email;
                        }],
                    'title',
                    ['attribute' => 'dict_task_id',
                        'format' => "raw",
                        'filter' =>SelectDataHelper::dataSearchModel($searchModel, DictTask::find()->allColumn(),'dict_task_id', 'dictTask.name'),
                        'value' => function($model) {
                            return Html::tag('span', $model->dictTask->name, ['class' => 'label label-default', 'style'=>['background-color'=> $model->dictTask->color]]);
                        }],
                    ['attribute' => 'responsible_user_id',
                        'format' => "raw",
                        'filter' =>SelectDataHelper::dataSearchModel($searchModel, Schedule::find()->getAllColumnUser(),'responsible_user_id', 'responsibleProfile.fio'),
                        'value' => function($model) {
                            return $model->responsibleProfile->fio."<br />".$model->responsibleProfile->phone."<br />".$model->responsibleSchedule->email;
                        }],
                    ['attribute' => 'status',
                        'format' => "raw",
                        'filter' => array_filter(array_combine(array_keys((new Task)->getStatusList()), array_column((new Task)->getStatusList(), 'name'))),
                        'value' => function($model) {
                            return Html::tag('span', $model->statusName, ['class' => 'label label-'.$model->statusColor]);
                        }],
                    'position',
                    ['attribute' => 'date_end',
                        'filter' => DatePicker::widget([
                            'model' => $searchModel,
                            'attribute' => 'date_from',
                            'attribute2' => 'date_to',
                            'type' => DatePicker::TYPE_RANGE,
                            'separator' => '-',
                            'pluginOptions' => [
                                'todayHighlight' => true,
                                'autoclose' => true,
                                'format' => 'yyyy-mm-dd',
                            ],
                        ]),
                        'format' => 'datetime',
                    ],
                    ['class' => ActionColumn::class,
                        'controller' => "task",
                        'template' => '{update} {delete} ',
                    ],
                ]
            ]); ?>
        </div>
    </div>
</div>
