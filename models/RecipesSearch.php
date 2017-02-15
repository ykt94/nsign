<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Recipes;

/**
 * RecipesSearch represents the model behind the search form about `app\models\Recipes`.
 */
class RecipesSearch extends Recipes
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['recipe_id'], 'integer'],
            [['recipe'], 'safe'],
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
        $query = Recipes::find();

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
        ]);

        $query->andFilterWhere(['like', 'recipe', $this->recipe]);

        return $dataProvider;
    }
}
