<?php
namespace modules\management;

use yii\base\Module;
use yii\filters\AccessControl;

class AdminManagement extends Module
{
    public $controllerNamespace = 'modules\management\controllers\admin';

    public function behaviors(){
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['dev']
                    ]
                ],
            ],
        ];
    }
}