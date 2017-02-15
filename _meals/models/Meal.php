<?php

namespace app\models;

use Yii;
use yii\db\Query;

/**
 * This is the model class for table "meal".
 *
 * @property integer $id
 * @property string $name
 *
 * @property Ingredient[] $ingredients
 */
class Meal extends \yii\db\ActiveRecord
{
    public $ingredients;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'meal';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 50],
            [['ingredients'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIngredients()
    {
        return $this->hasMany(Ingredient::className(), ['meal_id' => 'id']);
    }

    public function afterFind()
    {
        parent::afterFind();
        $this->ingredients = \yii\helpers\ArrayHelper::Map(Ingredient::find()
            ->where(['meal_id'=> $this->id])->all(), 'product.id','product.name');
        //var_dump($this->ingredients);
    }

    public function beforeSave($insert)
    {
        foreach (Ingredient::find()->all() as $ingredient) {
            if (! in_array($ingredient->id, $this->ingredients)){
                $ingredient->delete();
            }
        }
        $ingr = $this->hasMany(Ingredient::className(), ['meal_id' => 'id'])->all();
        foreach ($this->ingredients as $ingredient) {
            if (!in_array($ingredient, $ingr)) {
                $newIngr = new Ingredient();
                $newIngr->product_id = $ingredient;
                $newIngr->meal_id = $this->id;
                $newIngr->save();
            }
        }
        return parent::beforeSave($insert);

    }


    public static function clearPost($items){
        $selected = [];
        foreach($items as $id => $item) {
            if ($id == '_csrf') continue;
            $selected[] = $item;
        }
        return $selected;
    }

    public static function selectMealsByIngredients($items) {

        $subQuery = (new Query())->select(['ingredient.meal_id as meal_id','count(ingredient.id) as sum'])
            ->from('ingredient')
            ->groupBy('ingredient.meal_id');
        $res = self::find()->select(
            [
                'meal.id as id',
                'meal.name',
                'if ( max(sub.sum) = count(ingredient.id),true, false) as fullmatch',
            ])->innerJoin('ingredient','meal.id = ingredient.meal_id')
            ->leftJoin(['sub' => $subQuery],'sub.meal_id = meal.id')
            ->where(['ingredient.product_id' => $items])
            ->groupBy('meal.id')
            ->orderBy(' meal.name')->having('fullmatch')
            ->all();
        if (sizeof($res) > 0){
            return $res;
        }

        $res = self::find()->select(
            [
                'meal.id as id',
                'meal.name',
                'count(ingredient.id) as matches'
            ])->innerJoin('ingredient','meal.id = ingredient.meal_id')
            ->leftJoin(['sub' => $subQuery],'sub.meal_id = meal.id')
            ->where(['ingredient.product_id' => $items])
            ->groupBy('meal.id')
            ->orderBy('matches desc, meal.name')->having('(matches >= 2)')
            ->all();

        return $res;
    }
}
