<?php


namespace dictionary\forms\search;


use dictionary\models\DictDiscipline;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class DictDisciplineSearch extends Model
{
    public $name, $is_och;

    public function rules(): array
    {
        return [
            [['is_och',], 'integer'],
            [['name',], 'safe'],
        ];
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search(array $params): ActiveDataProvider
    {
        $query = DictDiscipline::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        $query
            ->andFilterWhere([ 'is_och' => $this->is_och]);

        $query
            ->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }

    public function attributeLabels(): array
    {
        return DictDiscipline::labels();
    }

}