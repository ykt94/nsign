<?php
/**
 * Created by PhpStorm.
 * User: MadMax
 * Date: 06.02.2017
 * Time: 10:54
 * @var \app\models\Ingredient $model
 */

use yii\widgets\ActiveForm;
use yii\helpers\Html;

$form = ActiveForm::begin([
    'id' => 'ingredient-form'
]);

echo $form->field($model, 'name')->textInput();
echo $form->field($model, 'available')->checkbox();

echo $model->isNewRecord ? Html::submitButton('Создать') : Html::submitButton('Сохранить');
ActiveForm::end();
