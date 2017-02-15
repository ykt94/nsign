<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%ingredients}}".
 *
 * @property integer $ingredient_id
 * @property string $ingredient
 * @property integer $enable
 *
 * @property RecipeIngredient[] $recipeIngredients
 */
class Ingredients extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%ingredients}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ingredient', 'enable'], 'required'],
            [['enable'], 'integer'],
            [['ingredient'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ingredient_id' => 'Ingredient ID',
            'ingredient' => 'Ingredient',
            'enable' => 'Enable',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRecipeIngredients()
    {
        return $this->hasMany(RecipeIngredient::className(), ['ingredient_id' => 'ingredient_id']);
    }
}
