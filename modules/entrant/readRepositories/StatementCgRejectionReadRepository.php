<?php
namespace modules\entrant\readRepositories;

use dictionary\helpers\DictCompetitiveGroupHelper;
use modules\dictionary\helpers\JobEntrantHelper;
use modules\entrant\helpers\CategoryStruct;
use modules\entrant\helpers\StatementHelper;
use modules\entrant\models\Anketa;
use modules\entrant\models\Statement;
use modules\entrant\models\StatementCg;
use modules\entrant\models\StatementRejectionCg;
use modules\entrant\models\UserAis;
use modules\dictionary\models\JobEntrant;
class StatementCgRejectionReadRepository
{
    private $jobEntrant;

    public function __construct(JobEntrant $jobEntrant)
    {
        $this->jobEntrant = $jobEntrant;
    }

    public function readData() {
        $query = StatementRejectionCg::find()->alias('rjCg')->statusNoDraft('rjCg.');
        $query->innerJoin(StatementCg::tableName() . ' cg', 'cg.id = rjCg.statement_cg');
        $query->innerJoin(Statement::tableName() . ' statement', 'statement.id = cg.statement_id');

        $query->andWhere(['statement.status' => StatementHelper::STATUS_ACCEPTED]);


        if($this->jobEntrant->isCategoryFOK()) {
            $query->andWhere(['statement.faculty_id' => $this->jobEntrant->faculty_id,
                'statement.edu_level' =>[DictCompetitiveGroupHelper::EDUCATION_LEVEL_BACHELOR,
                    DictCompetitiveGroupHelper::EDUCATION_LEVEL_MAGISTER]])
                ->andWhere(['not in',
                    'statement.status', StatementHelper::STATUS_WALT_SPECIAL]);
        }

        if ($this->jobEntrant->isTPGU()) {
            $query->innerJoin(Anketa::tableName(), 'anketa.user_id=statement.user_id');
            $query->andWhere(['anketa.category_id' => CategoryStruct::TPGU_PROJECT]);
        }

        if($this->jobEntrant->isCategoryTarget()) {
            $query->andWhere([
                'statement.special_right' => DictCompetitiveGroupHelper::TARGET_PLACE]);
        }

        if($this->jobEntrant->isCategoryUMS()) {
            $query->innerJoin(Anketa::tableName(), 'anketa.user_id=statement.user_id');
            $query->andWhere(['anketa.category_id'=> [CategoryStruct::GOV_LINE_COMPETITION,
                CategoryStruct::FOREIGNER_CONTRACT_COMPETITION]]);
        }

        if($this->jobEntrant->isCategoryMPGU()) {
            $query->innerJoin(Anketa::tableName(), 'anketa.user_id=statement.user_id');
            $query->andWhere(['anketa.category_id'=> [CategoryStruct::WITHOUT_COMPETITION,
                CategoryStruct::SPECIAL_RIGHT_COMPETITION]]);
        }

        if($this->jobEntrant->isCategoryGraduate()) {
            $query->andWhere([
                'statement.edu_level' => DictCompetitiveGroupHelper::EDUCATION_LEVEL_GRADUATE_SCHOOL]);
        }

        if(in_array($this->jobEntrant->category_id,JobEntrantHelper::listCategoriesFilial())) {
            $query->andWhere(['statement.faculty_id' => $this->jobEntrant->category_id]);
        }

        return $query;
    }
}