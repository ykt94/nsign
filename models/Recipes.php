<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%recipes}}".
 *
 * @property integer $recipe_id
 * @property string $recipe
 *
 * @property RecipeIngredient[] $recipeIngredients
 */
class Recipes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%recipes}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['recipe'], 'required'],
            [['recipe'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'recipe_id' => 'Recipe ID',
            'recipe' => 'Recipe',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRecipeIngredients()
    {
        return $this->hasMany(RecipeIngredient::className(), ['recipe_id' => 'recipe_id']);
    }
    
    
    public function getIngredients()
    {
        return $this->hasMany(Ingredients::className(), ['ingredient_id' => 'ingredient_id'])
            ->viaTable('recipe_ingredient', ['recipe_id' => 'recipe_id']);
    }
    
}
