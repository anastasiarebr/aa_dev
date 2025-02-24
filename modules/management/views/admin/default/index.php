<?php
/* @var $this yii\web\View */

$this->title = 'Задачи';
$this->params['breadcrumbs'][] = $this->title;

use backend\widgets\adminlte\components\AdminLTE;
use modules\management\models\Task;
use modules\management\widgets\InfoTaskWidget;
use modules\management\widgets\InfoTaskFullWidget;
use yii\helpers\Html;

?>

<div class="box">
    <div class="box-body box-primary">
        <div class="box-header">
            <?= Html::a('Новая задача', ['task/create'], ['class' => 'btn btn-success']) ?>
        </div>
        <div class="row">
            <div class="col-md-6">
                <?= InfoTaskFullWidget::widget([
                    'colorBox' => AdminLTE::BG_OLIVE,
                    'icon'=> 'tasks',
                    'overdue' => false,
                    'admin' => true,
                    'link' => 'management-admin'])
                ?>
            </div>
            <div class="col-md-6">
                <?= InfoTaskFullWidget::widget([
                    'colorBox' => AdminLTE::BG_RED,
                    'icon'=> 'times-circle',
                    'admin' => true,
                    'link' => 'management-admin'])
                ?>
            </div>
        </div>
    </div>
</div>
<div class="box">
    <div class="box-body">
        <div class="row">
            <div class="col-md-3">
                <?= InfoTaskWidget::widget([
                    'colorBox' => AdminLTE::BG_OLIVE,
                    'icon'=> 'plus',
                    'status' => Task::STATUS_NEW,
                    'admin' => true,
                    'link' => 'management-admin'])
                ?>
            </div>
            <div class="col-md-3">
                <?= InfoTaskWidget::widget([
                    'colorBox' => AdminLTE::BG_BLUE,
                    'icon'=> 'building',
                    'status' => Task::STATUS_WORK,
                    'admin' => true,
                    'link' => 'management-admin'])
                ?>
            </div>
            <div class="col-md-3">
                <?= InfoTaskWidget::widget([
                    'colorBox' => AdminLTE::BG_ORANGE,
                    'icon'=> 'check-square-o',
                    'status' => Task::STATUS_DONE,
                    'admin' => true,
                    'link' => 'management-admin'])
                ?>
            </div>
            <div class="col-md-3">
                <?= InfoTaskWidget::widget([
                    'colorBox' => AdminLTE::BG_GREEN,
                    'icon'=> 'hourglass-end',
                    'status' => Task::STATUS_ACCEPTED_TO_TIME,
                    'admin' => true,
                    'link' => 'management-admin'])
                ?>
            </div>
        </div>
    </div>
</div>
<div class="box box-danger">
    <div class="box-body">
        <div class="row">
            <div class="col-md-4">
                <?= InfoTaskWidget::widget([
                    'colorBox' => AdminLTE::BG_LIGHT_BLUE,
                    'icon'=> 'pencil-square-o',
                    'status' => Task::STATUS_REWORK,
                    'admin' => true,
                    'link' => 'management-admin'])
                ?>
            </div>
            <div class="col-md-4">
                <?= InfoTaskWidget::widget([
                    'colorBox' => AdminLTE::BG_YELLOW,
                    'icon'=> 'clock-o',
                    'status' => Task::STATUS_ACCEPTED_WITCH_OVERDUE,
                    'admin' => true,
                    'link' => 'management-admin'])
                ?>
            </div>
            <div class="col-md-4">
                <?= InfoTaskWidget::widget([
                    'colorBox' => AdminLTE::BG_RED,
                    'icon'=> 'minus-circle ',
                    'status' => Task::STATUS_NOT_EXECUTED,
                    'admin' => true,
                    'link' => 'management-admin'])
                ?>
            </div>
        </div>
    </div>
</div>

