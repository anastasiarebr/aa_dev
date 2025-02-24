<?php
/* @var $model modules\entrant\forms\OtherDocumentForm */
/* @var $form yii\bootstrap\ActiveForm */

use kartik\date\DatePicker;
use modules\dictionary\helpers\DictDefaultHelper;
use modules\dictionary\helpers\DictIncomingDocumentTypeHelper;
use modules\entrant\helpers\DateFormatHelper;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
\modules\entrant\assets\other\OtherDocumentAsset::register($this);

?>
 <?php $form = ActiveForm::begin(['id'=> 'form-other-documents', 'enableAjaxValidation' => $model->isAjax]); ?>
      <?php if($model->type !=43): ?>
      <?= $form->field($model, 'type')->dropDownList($model->listTypesDocument()) ?>
      <?php endif; ?>
        <div id="other-document-full">
            <?= $form->field($model, 'series')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'number')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'date')->widget(DatePicker::class, DateFormatHelper::dateSettingWidget()); ?>
            <?= $form->field($model, 'authority')->textInput(['maxlength' => true]) ?>
            <?php if($model->isExemption || $model->exemption_id): ?>
                <?= $form->field($model, 'exemption_id')->dropDownList(DictDefaultHelper::categoryExemptionList()) ?>
            <?php endif; ?>
        </div>
        <?php if($model->type !=43): ?>
        <?= $form->field($model, 'amount')->textInput() ?>
        <?php endif; ?>
        <div class="form-group">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
        </div>
<?php ActiveForm::end(); ?>