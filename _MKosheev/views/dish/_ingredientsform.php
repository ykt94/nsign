<?php
/**
 * Created by PhpStorm.
 * User: MadMax
 * Date: 10.02.2017
 * Time: 10:56
 * @var \yii\widgets\ActiveForm $form
 * @var \app\models\IngredientsForm $model
 */

use yii\helpers\Html;
use yii\helpers\ArrayHelper;

echo $form->field($model, 'ingredientIds')->hiddenInput(['id' => 'ingredientIds'])->label(false);
?>

<table width="100%">
    <tr>
        <td width="45%">
            <div class="form-group">
                <label class="control-label">Выбранные ингредиенты</label>
                <?= Html::listBox(null, null, $model->selectedIngredients, [
                    'id' => 'selected-ingredients',
                    'class' => 'form-control ingredients'
                ]); ?>
            </div>
        </td>
        <td width="10%" style="padding: 15px">
            <a href="#" id="btn-select-ingredient" class="btn btn-lg btn-success"><-Выбрать</a>
        </td>
        <td width="45%">
            <div class="form-group">
                <label class="control-label">Доступные ингредиенты</label>
                <?php
                // выделяем из общего списка ингредиентов те, которых еще нет в выбранных
                $items = array_diff($model->allIngredients, $model->selectedIngredients);
                ?>
                <?= Html::listBox(null, null, $items, [
                    'id' => 'all-ingredients',
                    'class' => 'form-control ingredients'
                ]); ?>
            </div>
        </td>
    </tr>
</table>

