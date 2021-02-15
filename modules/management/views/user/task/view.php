<?php

use modules\management\models\Task;
use yii\helpers\Html;
use yii\widgets\DetailView;
/* @var $this yii\web\View */
/* @var $task modules\management\models\Task*/
$this->title = $task->title;

$this->params['breadcrumbs'][] = ['label' => 'Задачи', 'url' => ['task/index']];
$this->params['breadcrumbs'][] = $this->title;
$director = [[ 'label' => 'ФИО','value' => $task->directorProfile->fio ], 'directorSchedule.email', 'directorProfile.phone',
    [
    'label' => 'Должность',
    'value' => implode(', ', \modules\management\models\ManagementUser::find()->allColumnManagementUser($task->director_user_id)),
    'format' => 'raw',
]];
$responsible = [[ 'label' => 'ФИО', 'value' => $task->responsibleProfile->fio],'responsibleSchedule.email', 'responsibleProfile.phone',  [
    'label' => 'Должность',
    'value' => implode(', ', \modules\management\models\ManagementUser::find()->allColumnManagementUser($task->responsible_user_id)),
    'format' => 'raw',
]];

$taskData = ['title', 'dictTask.name', 'statusName', 'date_end:datetime', 'position', 'note'];
?>
<div class="row">
    <div class="col-md-6">
        <div class="box box-primary">
            <div class="box-header">
                <h4>Постановщик задачи</h4>
            </div>
            <div class="box-body">
                <?= DetailView::widget([
                    'model' => $task,
                    'attributes' => $director,
                ]) ?>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="box box box-warning">
            <div class="box-header">
                <h4>Ответственный</h4>
            </div>
            <div class="box-body">
                <?= DetailView::widget([
                    'model' => $task,
                    'attributes' => $responsible,
                ]) ?>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-8">
        <div class="box box-info">
            <div class="box-header">
                <h4>Описание задачи</h4>
            </div>
            <div class="box-body">
                <?= $task->text ?>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="box box-danger"">
            <div class="box-header">
                <h4>Задача</h4>
            </div>
            <div class="box-body">
                <?= DetailView::widget([
                    'model' => $task,
                    'attributes' => $taskData,
                ]) ?>
            </div>
            <div class="box-footer">
                <?= ($task->isStatusNew() ? Html::a('Взять в работу', ['task/status', 'id' => $task->id, 'status' =>
                    Task::STATUS_WORK],['class'=> "btn btn-primary btn-block", 'data-confirm'=> "Вы уверены, что хотите взять в работу?"]) : "").
                ($task->isStatusWork() || $task->isStatusRework() ? Html::a('Выполнено', ['task/status', 'id' => $task->id, 'status' =>
                    Task::STATUS_DONE],['class'=> "btn btn-success btn-block", 'data-confirm'=> "Вы уверены, что хотите изменить статус?"]) : "")?>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="box box-danger"">
        <div class="box-header">
            <h4>История</h4>
        </div>
        <div class="box-body">
            <?= $this->render('_history',['task' => $task]) ?>
        </div>
    </div>
</div>



