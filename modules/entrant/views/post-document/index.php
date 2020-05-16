<?php
/* @var $this yii\web\View */

use yii\helpers\Html;

\frontend\assets\modal\ModalAsset::register($this);

$this->title = 'Загрузка документов';

$this->params['breadcrumbs'][] = ['label' => 'Определение условий подачи документов', 'url' => ['/abiturient/anketa/step1']];
$this->params['breadcrumbs'][] = ['label' => 'Выбор уровня образования', 'url' => ['/abiturient/anketa/step2']];
$this->params['breadcrumbs'][] = ['label' => 'Заполнение персональной карточки поступающего', 'url' => ['/abiturient/default/index']];
$this->params['breadcrumbs'][] = $this->title;

$anketa = Yii::$app->user->identity->anketa();
?>

<div class="container">
    <div class="row min-scr">
        <div class="button-left">
            <?= Html::a(Html::tag("span", "", ["class" => "glyphicon glyphicon-arrow-left"]),
                "/abiturient", ["class" => "btn btn-warning btn-lg"]) ?>
        </div>
    </div>
    <h1 align="center"><?= $this->title ?></h1>
    <div class="row">
        <div class="col-md-12">
            <?= \modules\entrant\widgets\passport\PassportMainWidget::widget(['view' => 'file']); ?>

            <?= \modules\entrant\widgets\education\DocumentEducationFileWidget::widget(); ?>

            <?php if ($anketa->isAgreement()): ?>
                <?= \modules\entrant\widgets\agreement\AgreementWidget::widget(['view' => 'file']); ?>
            <?php endif; ?>

            <?php if (!$anketa->isRussia()): ?>
                <?= \modules\entrant\widgets\address\AddressFileWidget::widget(); ?>
            <?php endif; ?>

            <?= \modules\entrant\widgets\other\DocumentOtherFileWidget::widget(); ?>

            <?= \modules\entrant\widgets\submitted\SubmittedDocumentGenerateStatementWidget::widget(); ?>

            <?= \modules\entrant\widgets\statement\StatementIaWidget::widget(['userId' => Yii::$app->user->identity->getId()]); ?>

            <?= \modules\entrant\widgets\statement\StatementPersonalDataWidget::widget(['userId' => Yii::$app->user->identity->getId()]); ?>

            <?= \modules\entrant\widgets\statement\StatementCgConsentWidget::widget(['userId' => Yii::$app->user->identity->getId()]); ?>
        </div>
    </div>
</div>
