<?php
namespace app\models;

use yii\base\Model;

class ChoiceForm extends Model
{
    public $choice;

    public function rules()
    {
        return [
            [['choice'], 'required'],
        ];
    }
}