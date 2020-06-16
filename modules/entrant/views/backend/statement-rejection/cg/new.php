<?php

use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $searchModel modules\entrant\searches\StatementSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $status integer */

$this->title = "Отозванные заявления о согласии на зачисление (Новые)" ;
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="user-index">
    <div class="box">
        <div class="box-body">
             <?= ListView::widget([
            'dataProvider' => $dataProvider,
            'itemView' => '_list',
            ]) ?>

        </div>
    </div>
</div>

