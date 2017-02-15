<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Binder;

/**
 * BinderSearch represents the model behind the search form about `app\models\Binder`.
 */
class BinderSearch extends Binder
{
    /**
     * @inheritdoc
     */
    
    public $ingredient;
    
    public function rules()
    {
        return [
            [['recipe_id', 'ingredient_id'], 'integer'],
            [['ingredient','recipe'],'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Binder::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'recipe_id' => $this->recipe_id,
            'ingredient_id' => $this->ingredient_id,
        ]);

        return $dataProvider;
    }
}
