<?php
/**
 * Created by PhpStorm.
 * User: MadMax
 * Date: 10.02.2017
 * Time: 10:50
 */

namespace app\models;

use yii\base\Model;
use yii\helpers\ArrayHelper;

/**
 * Class IngredientsForm
 * @package app\models
 * @property string $ingredientIds
 */
class IngredientsForm extends Model
{
    public $selectedIngredients;
    public $allIngredients;

    public function rules()
    {
        return [
            ['ingredientIds', 'safe']
        ];
    }

    /**
     * Возвращает идентификаторы выбранных ингредиентов в виде строки,
     * идентификаторы разделены ","
     * @return string идентфикаторы выбранных ингредиентов
     */
    public function getIngredientIds()
    {
        $result = '';
        foreach ($this->selectedIngredients as $id => $name) {
            $result = $result.$id.',';
        }

        return rtrim($result, ' \t\n\r\0\x0B,');
    }

    public function setIngredientIds($value)
    {
        $ids = explode(',', ltrim($value, ' \t\n\r\0\x0B,'));
        $this->selectedIngredients = ArrayHelper::map(Ingredient::findAll(['id' => $ids]), 'id', 'name');
    }
}