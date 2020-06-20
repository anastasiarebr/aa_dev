<?php
/* @var $this yii\web\View */
/* @var $gender string */
/* @var $anketa array */

/* @var $statement modules\entrant\models\Statement */
use dictionary\helpers\DictCompetitiveGroupHelper;
use modules\entrant\helpers\FileCgHelper;
use modules\entrant\helpers\AdditionalInformationHelper;
use modules\entrant\helpers\ItemsForSignatureApp;
use modules\entrant\helpers\LanguageHelper;
use modules\entrant\helpers\PreemptiveRightHelper;

$userCg = FileCgHelper::cgUser($statement->user_id, $statement->faculty_id, $statement->speciality_id, $statement->special_right,  $statement->columnIdCg());

$cse = DictCompetitiveGroupHelper::groupByExamsCseFacultyEduLevelSpecialization($statement->user_id,
    $statement->faculty_id, $statement->speciality_id, $statement->columnIdCg(), true);
$noCse = DictCompetitiveGroupHelper::groupByExamsCseFacultyEduLevelSpecialization($statement->user_id,
    $statement->faculty_id, $statement->speciality_id, $statement->columnIdCg(), false);
$language = LanguageHelper::all($statement->user_id);
$information = AdditionalInformationHelper::dataArray($statement->user_id);
$prRight = PreemptiveRightHelper::allOtherDoc($statement->user_id);

$och = false;
?>

<table class="table table-bordered app-table">
    <tbody>
    <tr>
        <th rowspan="2">№</th>
        <th colspan="2" align="center">Условия поступления</th>
        <th rowspan="2">Основание приема</th>
        <th align="center" colspan="2">Вид финансирования</th>
    </tr>
    <tr>
        <th>Направление подготовки</th>
        <th>Форма обучения</th>
        <th>Федеральный бюджет</th>
        <th>Платное обучение</th>
    </tr>
    <?php foreach ($userCg as $key => $value): if($value['form'] == "очная") { $och = true;} ?>
        <tr>
            <td width="4%"><?= ++$key ?>.</td>
            <td width="30%"><?= $value["speciality"] ?></td>
            <td width="10%"><?= $value['form'] ?></td>
            <td width="11%"><?= $value['special_right'] ?></td>
            <td width="13%">
                <?= $value['budget'] ?? "" ?></td>
            <td width="10%" class="text-center"><?= $value['contract'] ?? "" ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?php if($cse): ?>
    <p>
        Прошу в качестве вступительных испытаний засчитать следующие результаты ЕГЭ: <?= $cse ?>
    </p>
<?php endif; ?>
<?php if($noCse): ?>
    <p>
        Прошу допустить меня к вступительным испытаниям по следующим предметам: <?= $noCse ?><br/>
        Основание для допуска к сдаче вступительных испытаний: <?= $anketa['currentEduLevel'] ?>.
    </p>
<?php endif; ?>
<p align="center"><strong>О себе сообщаю следующее:</strong></p>

<table width="100%">
    <tr>
        <td width="80%"> <?php if ($och): ?>
                В общежитии: <?= $information['hostel'] ? 'Нуждаюсь' : 'Не нуждаюсь' ?><br/>
            <?php endif; ?>
            Изучил(а) иностранные языки: <?= $language ?><br/>
        </td>
        <td width="20%">Пол: <?= $gender ?></td>
    </tr>
</table>
<table width="100%">
    <tr>
        <td></td>
        <td class="box-30-15 bordered-cell text-center"><?= $prRight ? "X": "" ?></td>
        <td width="100px">Имею</td>
        <td class="box-30-15 bordered-cell text-center"><?= !$prRight ? "X": "" ?></td>
        <td>Не имею</td>
    </tr>
</table>
<?php if($prRight) :?>
    <p class="underline-text"> на основании: <?= $prRight ?></p>
<?php endif; ?>
<?php
$signaturePoint = ItemsForSignatureApp::GENERAL_SPO;
if(!$och) {
    unset($signaturePoint[9]);
}
foreach ($signaturePoint as $signature) :?>

    <p class="mt-15"><?= ItemsForSignatureApp::getItemsText()[$signature] ?></p>
    <?php if ($signature == ItemsForSignatureApp::SPECIAL_CONDITIONS) : ?>
        <table width="100%">
            <tr>
                <td></td>
                <td class="box-30-15 bordered-cell text-center"><?= $information['voz'] ? "X" : "" ?></td>
                <td class="w-100">Нуждаюсь</td>
                <td class="box-30-15 bordered-cell text-center"><?= !$information['voz'] ? "X" : "" ?></td>
                <td>Не нуждаюсь</td>
            </tr>
        </table>
    <?php endif; ?>
    <table width="100%">
        <tr>
            <td width="80%" rowspan="2"></td>
            <td class="bb"></td>
        </tr>
        <tr>
            <td class="v-align-top text-center fs-7">(Подпись поступающего)
            </td>
        </tr>
    </table>
<?php endforeach; ?>
<div class="mt-50">
    <table>
        <tr>
            <td>«</td>
            <td class="bb w-20"></td>
            <td>»</td>
            <td class="bb w-40"></td>
            <td>2020</td>
            <td>г.</td>
            <td class="w-470"></td>
            <td class="bb w-145"></td>
        </tr>
        <tr>
            <td colspan="6" class="text-right fs-7">(Дата заполнения)</td>
            <td></td>
            <td class="text-center fs-7">(Подпись поступающего)</td>
        </tr>
    </table>
    <div class="mt-30">
        <table>
            <tr>
                <td><strong>Подпись сотрудника ОК, принявшего заявление</strong></td>
                <td class="bb w-120"></td>
                <td>(</td>
                <td class="bb w-200"></td>
                <td>)</td>
                <td></td>
            </tr>
            <tr>
                <td></td>1
                <td class="text-center fs-7">(Подпись)</td>
                <td></td>
                <td class="text-center fs-7">(Фамилия И.О.)</td>
                <td></td>
                <td></td>
            </tr>
        </table>
        <table>
            <tr>
                <td class="w-50"></td>
                <td>«</td>
                <td class="bb w-50"></td>
                <td>»</td>
                <td class="bb w-50"></td>
                <td>2020 г.</td>
            </tr>
        </table>
    </div>
</div>
