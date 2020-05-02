<?php
use yii\helpers\Html;
/* @var $this yii\web\View */
/* @var $statements yii\db\BaseActiveRecord */
/* @var $statement modules\entrant\models\Statement*/
/* @var $isUserSchool bool */
?>
<table class="table table-bordered">
    <?php foreach ($statements as $statement):  ?>
    <tr>
        <td><?= $statement->id ?>
        <td><?= $statement->status ? "Загружено" : Html::a('docx', ['statement/doc', 'id' =>  $statement->id], ['class' => 'btn btn-large btn-primary']) ." ". Html::a('pdf', ['statement/pdf', 'id' =>  $statement->id], ['class' => 'btn btn-large btn-danger'])?></td>
    </tr>
    <?php endforeach; ?>
</table>