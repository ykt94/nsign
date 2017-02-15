<?php
/**
 * Created by PhpStorm.
 * User: MadMax
 * Date: 06.02.2017
 * Time: 10:54
 * @var \yii\web\View $this
 * @var \app\models\Dish $model
 * @var \app\models\IngredientsForm $ingredientsForm
 */

use yii\widgets\ActiveForm;
use yii\helpers\Html;

$form = ActiveForm::begin([
    'id' => 'dish-form'
]);

echo $form->field($model, 'name')->textInput();
echo $form->field($model, 'available')->checkbox();
echo $this->render('../dish/_ingredientsform', [
    'form' => $form,
    'model' => $ingredientsForm,
]);

echo $model->isNewRecord ? Html::submitButton('Создать') : Html::submitButton('Сохранить');
ActiveForm::end();
