<?php
/**
 * Created by PhpStorm.
 * User: MadMax
 * Date: 06.02.2017
 * Time: 14:19
 * @var \yii\web\View $this
 * @var \app\models\SearchForm $model
 * @var array $dishs Найденые блюда
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Breadcrumbs;
?>

<?php
$this->title = 'Поиск блюд';

echo Breadcrumbs::widget([
    'homeLink' => [
        'label' => 'Главная',
        'url' => ['/']
    ],
    'links' => [
        ['label' => $this->title],
    ]
]);

?>

<?php

$script = <<< JS
function checkIngredients(event)
{
    if ($("#selected-ingredients option").length < 2) {
        $("#error-message").html('<div class="error-summary">Выберете больше ингредиентов</div>');
        event.preventDefault();
    }
}
JS;

$this->registerJs($script, \yii\web\View::POS_BEGIN);

$form = ActiveForm::begin([]);
echo $this->render('_ingredientsform', [
    'form' => $form,
    'model' => $model
]);
echo '<div id="error-message">';
if ($model->hasErrors('selectedIngredients')) {
    echo '<div class="error-summary">';
    echo $model->getFirstError('selectedIngredients');
    echo '</div>';
}
echo '</div>';
echo Html::submitButton('Найти', ['onclick' => '(function ( $event ) {checkIngredients(event)})();']);
ActiveForm::end();
?>

<?php
if (isset($dishs)) {
    echo '<div class="form-group">';
    echo '<h2>Найденные блюда</h2>';
    if (count($dishs) > 0) {
        echo '<table>';
        echo '<thead><tr>Название</tr></thead>';
        foreach($dishs as $dish) {
            echo '<tr>';
            echo '<td>'.$dish['name'].'</td>';
            echo '</tr>';
        }
        echo '</table>';
    }
    else {
        echo 'Из выбранных ингредиентов ничего приготовить нельзя';
    }
    echo '</div>';
}
?>