<?php


namespace dictionary\forms\search;


use dictionary\models\DictSpeciality;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class DictSpecialitySearch extends Model
{
    public $name, $code;

    public function rules(): array
    {
        return [
            [['name','code'], 'safe'],
        ];
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search(array $params): ActiveDataProvider
    {
        $query = DictSpeciality::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        $query
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'code', $this->code]);

        return $dataProvider;
    }

    public function attributeLabels(): array
    {
        return DictSpeciality::labels();
    }

}