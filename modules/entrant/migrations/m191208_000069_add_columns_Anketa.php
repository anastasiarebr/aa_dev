<?php

namespace modules\entrant\migrations;
use modules\entrant\models\Agreement;
use modules\entrant\models\Anketa;
use \yii\db\Migration;

class m191208_000069_add_columns_Anketa extends Migration
{
    private function table() {
        return Anketa::tableName();
    }

    public function up()
    {
        $this->addColumn($this->table(),'is_foreigner_edu_organization', $this->integer()->defaultValue(0));
    }

    public function down()
    {
        $this->dropColumn($this->table(),'is_foreigner_edu_organization');

    }

}
