<?php

use modules\exam\models\ExamResult;
use testing\helpers\TestQuestionHelper;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var  $attempt  \modules\exam\models\ExamAttempt */
$s = $attempt->test->exam->discipline_id == 22;
?>
<div class="box box-default">
    <div class="box-body">
        <?= \backend\widgets\adminlte\grid\GridView::widget([
            'dataProvider' => $dataProvider,
            'showHeader' => false,
            'rowOptions' => function( ExamResult $model){
                if (($model->question->type_id == TestQuestionHelper::TYPE_ANSWER_DETAILED ||
                        $model->question->type_id == TestQuestionHelper::TYPE_FILE)  &&  is_null($model->mark)) {
                    return ['class' => 'warning'];
                }
                 else {
                     return ['class' => 'default'];
                }
            },
            'columns' => [
                ['class' => \yii\grid\SerialColumn::class,  'header'=> '№ п/п',],
               ['attribute'=>'question_id',
                   'header'=> 'Вопрос',
               'class'=> \modules\exam\widgets\exam\gird\ViewAnswerAttemptTestColumn::class],
                ['attribute'=>'mark',
                    'header'=> 'Оценка. Итого: '.$attempt->getResult()->sum('mark'),
                    'value'=> 'mark'],
                ['class' => \yii\grid\ActionColumn::class,
                    'template' => '{update}',
                    'controller' => 'exam-result',
                    'buttons'=> [
                        'update' => function ($url,$model) {
                            return $model->question->type_id  == TestQuestionHelper::TYPE_ANSWER_DETAILED ||
                            $model->question->type_id  == TestQuestionHelper::TYPE_FILE ?
                                Html::a(
                                '<span class="glyphicon glyphicon-edit"></span>',
                                   ['exam-result/update', 'attempt_id' => $model->attempt_id,
                                       'question_id' => $model->question_id, 'tq_id' =>$model->tq_id],
                                ['data-pjax' => 'w0', 'data-toggle' => 'modal', 'data-modalTitle' =>'Редактировать оценку', 'data-target' => '#modal']) :"";
                        },
                ],
            ],
        ]]) ?>
    </div>
</div>

