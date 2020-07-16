<?php


namespace modules\entrant\helpers;


class ItemsForSignatureApp
{
    const GENERAL_BACHELOR_SIGNATURE = [1,2,3,4,5,6,7,8,9,10,11,12,13];
    const GENERAL_MAGISTRACY_SIGNATURE = [1,3,4,5,6,7,8,9,10,11,12];
    const GENERAL_GRADUATE_SIGNATURE = [1,3,6,7,8,9,10,11,12];
    const GENERAL_SPO = [1,14,4,6,7,8,9,11,12];
    const SPECIAL_CONDITIONS = 6;

    public static function getItemsText()
    {
        return [
            1 => "С копией Лицензии МПГУ на осуществление образовательной деятельности в сфере высшего образования 
            (серия 90Л01 № 0008862 Рег. № 1818 от 11.12.2015) с приложениями, копией Свидетельства о государственной 
            аккредитации (серия 90А01 № 0001951 Рег. № 1857 от 15.04.2016) с приложениями, Уставом МПГУ, Правилами приёма, 
            Правилами подачи и рассмотрения апелляции ознакомлен(а)",
            2 => "Ознакомлен(а) с информацией о предоставляемых поступающим особых правах и преимуществах
            при приеме на обучение по программам бакалавриата",
            3 => "Высшее образование данного уровня получаю впервые (за исключением поступающих для получения второго 
            и последующего высшего образования данного уровня)",
            4 => "Подтверждаю подачу заявления не более чем в  5 образовательных организаций",
            5 => "Подтверждаю подачу заявлений о приеме не более чем по трем направлениям подготовки в МПГУ",
            6 => "В создании специальных условий для лиц с ОВЗ и инвалидов при проведении вступительных испытаний ",
            7 => "С датой завершения приёма заявления о согласии на зачисление ознакомлен(а)",
            8 => "Я предупрежден(а) о том, что без предоставления в Приёмную комиссию заявления о согласии на зачисление 
            на образовательную программу вопрос о моем зачислении рассматриваться не будет",
            9 => "Я предупрежден(а) о том, что заявление о согласии на зачисление (на места, финансируемые из федерального 
            бюджета) может быть подано не более двух раз",
            10 => "Ознакомлен(а) с информацией об ограниченном количестве мест в общежитии",
            11 => "Даю согласие на обработку своих персональных данных в порядке, установленном Федеральным законом 
            от 27.07.2006 №152-ФЗ «О персональных данных»",
            12 => "Ознакомлен(а) с информацией о необходимости указания в заявлении о приёме достоверных сведений 
            и предоставления подлинных документов.",
            13 => "Подтверждаю отсутствие у меня диплома бакалавра, диплома специалиста, диплома магистра (при поступлении 
            на обучение по программам бакалавриата на места в рамках контрольных цифр приема)",
            14 => "Подтверждаю подачу заявлений о приеме не более чем по трем специальностям среднего профессионального 
            образования",
        ];
    }

}