<?php
/**
 * Created by PhpStorm.
 * User: MadMax
 * Date: 03.02.2017
 * Time: 14:09
 */

namespace app\models;

use yii\db\ActiveRecord;

/**
 * Class Ingredient описывает ингредиенты,
 * используемые для приготовления блюд
 * @package app\models
 * @property integer $id Идентификатор
 * @property boolean $available Признак доступности ингредиента для поиска
 * @property string $name Название ингредиента
 */
class Ingredient extends ActiveRecord
{
    public function rules()
    {
        return [
            ['name', 'required', 'message' => 'Поле не может быть пустым'],
            ['name', 'string', 'max' => 255],
            ['name', 'unique', 'message' => '{attribute} "{value}" уже используется'],
            ['available', 'safe']
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
}