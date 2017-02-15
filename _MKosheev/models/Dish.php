<?php
/**
 * Created by PhpStorm.
 * User: MadMax
 * Date: 03.02.2017
 * Time: 14:49
 */

namespace app\models;

use yii\db\ActiveRecord;

/**
 * Class Dish Описывает рецепт отдельно взятого блюда
 * @package app\models
 * @property integer $id Идентификатор
 * @property boolean $available Признак доступности данного блюда для поиска
 * @property string $name Название блюда
 * @property string $description Собственно сам рецепт
 */
class Dish extends ActiveRecord
{
    public function rules()
    {
        return [
            ['name', 'required', 'message' => 'Поле не может быть пустым'],
            ['name', 'string', 'max' => 255],
            ['name', 'unique', 'message' => '{attribute} "{value}" уже используется'],
            [['available', 'description'], 'safe']
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'Идентификатор',
            'available' => 'Доступен',
            'name' => 'Название'
        ];
    }

    public function getIngredients()
    {
        return $this->hasMany(Ingredient::className(), ['id' => 'ingredient_id'])
            ->viaTable('tbl_cookbook', ['dish_id' => 'id']);
    }
}