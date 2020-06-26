<?php
/* @var $this yii\web\View */
/* @var $model modules\entrant\forms\AddressForm */
/* @var $neededCountry bool */

$this->title = ($neededCountry ? "Свидетельство о рождении. " : "Документ, удостоверяющий личность.")." Редактирование.";
$this->params['breadcrumbs'][] = ['label' => 'Персональная карточка поступающего', 'url' => ['default/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render('_form', ['model'=> $model, 'neededCountry' => $neededCountry] )?>
