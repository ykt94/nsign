<?php
/**
 * Created by PhpStorm.
 * User: MadMax
 * Date: 06.02.2017
 * Time: 14:21
 */

namespace app\models;

class SearchForm extends IngredientsForm
{
    public function rules()
    {
        return [
            ['selectedIngredients', 'countValidator', 'params' => ['min' => 2, 'max' => 5]],
            ['ingredientIds', 'safe']
        ];
    }

    public function countValidator($attr, $params)
    {
        if ($this->hasErrors())
            return;

        $minCount = isset($params['min']) ? $params['min'] : 2;
        $maxCount = isset($params['max']) ? $params['max'] : 5;
        if (count($this->selectedIngredients) < $minCount) {
            $this->addError($attr, "Выбрано недостаточно ингредиентов. Нужно не менее $minCount");
        }
        if (count($this->selectedIngredients) > $maxCount) {
            $this->addError($attr, "Выбрано много ингредиентов. Нужно не более $maxCount");
        }
    }
}