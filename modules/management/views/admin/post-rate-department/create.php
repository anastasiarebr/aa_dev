<?php
/* @var $this yii\web\View */
/* @var $model modules\management\forms\PostManagementForm */
$this->title = "Справочник должностей. Добавление.";

$this->params['breadcrumbs'][] = ['label' => 'Справочник должностей', 'url' => ['post-rate-department/index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<?= $this->render('_form', ['model'=> $model] )?>

