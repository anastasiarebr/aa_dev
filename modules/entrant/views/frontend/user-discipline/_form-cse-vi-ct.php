<?php
/* @var $this yii\web\View */
/* @var $model modules\entrant\forms\UserDisciplineCseForm */
/* @var $nameExam */
/* @var $isBelarus */

use dictionary\models\DictDiscipline;
use modules\entrant\models\UserDiscipline;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
$this->title = "Вступительные испытания + ЕГЭ".($isBelarus ? "+ ЦТ.":".")." Уточнение. ". $nameExam;

$this->params['breadcrumbs'][] = ['label' => 'Заполнение персональной карточки поступающего', 'url' => ['/abiturient/default/index']];
$this->params['breadcrumbs'][] = $this->title;

$data = (new UserDiscipline())->getTypeListKey('name_short');
if (!$isBelarus) {
    unset($data[UserDiscipline::CT_VI], $data[UserDiscipline::CT]);
}
?>
<div class="container">
    <div class="row">
        <div class="mt-20">
            <div class="row min-scr">
                <div class="button-left">
                    <?= Html::a(Html::tag("span", "", ["class" => "glyphicon glyphicon-arrow-left"]),
                        "/abiturient", ["class" => "btn btn-warning btn-lg"]) ?>
                </div>
            </div>
            <h4><?= $this->title ?></h4>
            <p class="label label-danger" align="justify">Если вы не знаете балл ЕГЭ/ЦТ, то введите значение 50</p>
            <?php $form = ActiveForm::begin(); ?>
            <?= $form->field($model, "discipline_id")->hiddenInput(['value'=> $model->discipline_id ?: $keyExam])->label(false) ?>
            <?php $field = $form->field($model, "discipline_select_id")->label(false); ?>
            <?php $dictDiscipline = DictDiscipline::findOne($model->discipline_id ?: $keyExam)?>
            <?php if($dictDiscipline && $dictDiscipline->composite_discipline) : ?>
                <?= $field->dropDownList($dictDiscipline->getComposite()
                    ->joinWith('dictDisciplineSelect')
                    ->select('name')
                    ->indexBy('discipline_select_id')
                    ->column())?>
            <?php else: ?>
                <?= $field->hiddenInput(['value'=> $model->discipline_select_id ?: $keyExam])?>
            <?php endif; ?>
            <?= $form->field($model, "type")->dropDownList($data) ?>
            <?= $form->field($model, "mark")->textInput() ?>
            <?= $form->field($model, "year")->textInput() ?>
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
          <?php  ActiveForm::end(); ?>
        </div>
    </div>
</div>
<?php
$this->registerJS(<<<JS
var typeSelect = $("#userdisciplinecseform-type");
var year = $("#userdisciplinecseform-year");
var mark = $("#userdisciplinecseform-mark");
$(typeSelect).on("change init", function() {
     if(this.value == 2){
         year.attr('disabled', true).val('');
         mark.attr('disabled', true).val('');
     }else {
         mark.attr('disabled', false);
         year.attr('disabled', false);
     }
}).trigger("init");
JS
);
