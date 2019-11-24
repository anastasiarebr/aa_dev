<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use dictionary\helpers\CategoryDocHelper;

/* @var $this yii\web\View */
/* @var $olympic \olympic\models\OlimpicList  */


$this->title = "Просмотр";
$this->params['breadcrumbs'][] = ['label' => 'Олимпиады', 'url' => ['olympic/olympic/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-md-6">
    <div class="box box-default">
        <div class="box box-header">
            <p><?= Html::a('Вернуться', ['olympic/olympic/view', 'id' => $olympic->olimpic_id], ['class' => 'btn btn-info']) ?>
                <?= Html::a('Обновить', ['update', 'id' => $olympic->id], ['class' => 'btn btn-primary']) ?>
                <?= Html::a('Удалить', ['delete', 'id' => $olympic->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => 'Вы уверены, что хотите удалить?',
                        'method' => 'post',
                    ],
                ]) ?>
            </p>
        </div>
        <div class="box-body">
            <?= DetailView::widget([
                'model' => $olympic,
                'attributes' => [
                    'name',
                    'year',
                    ['attribute' => 'faculty_id',
                        'value' => \dictionary\helpers\DictFacultyHelper::facultyName($olympic->faculty_id)],
                     ['attribute' => 'chairman_id',
                         'value' => \dictionary\helpers\DictChairmansHelper::chairmansFullNameOne($olympic->chairman_id)],
                     ['attribute' => 'number_of_tours','value' => \olympic\helpers\OlympicHelper::numberOfToursName($olympic->number_of_tours)],
                     ['attribute' => 'form_of_passage','value' => \olympic\helpers\OlympicHelper::formOfPassageName($olympic->form_of_passage)],
                     ['attribute' => 'edu_level_olymp','value' => \olympic\helpers\OlympicHelper::levelOlimpName($olympic->edu_level_olymp)],
                    'date_time_start_reg:datetime',
                    'date_time_finish_reg:datetime',
                    'time_of_distants_tour',
                    'date_time_start_tour:datetime',
                    'address:ntext',
                    'time_of_tour',
                    'requiment_to_work_of_distance_tour:raw',
                    'requiment_to_work:raw',
                    'criteria_for_evaluating_dt:raw',
                    'criteria_for_evaluating:raw',
                    ['attribute' => 'showing_works_and_appeal','value' => \olympic\helpers\OlympicHelper::showingWorkName($olympic->showing_works_and_appeal)],
                ],
            ]) ?>
        </div>
        </div>
    </div>
    <div class="col-md-6">
        <?= \backend\widgets\olimpic\SpecialTypeOlympicWidget::widget(['olympic_id' => $olympic->id]) ?>
        <?= \backend\widgets\olimpic\OlympicNominationWidget::widget(['olympic_id' => $olympic->id]) ?>
        <?php if($olympic->isDistanceTour) : ?>
        <?= \backend\widgets\testing\TestWidget::widget(['olympic_id' => $olympic->id]) ?>
        <? endif; ?>
    </div>
</div>

