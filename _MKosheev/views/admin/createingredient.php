<?php
/**
 * Created by PhpStorm.
 * User: MadMax
 * Date: 06.02.2017
 * Time: 10:47
 * @var \yii\web\View $this
 * @var \app\models\Ingredient $model
 */

use yii\widgets\Breadcrumbs;

$this->title = 'Новый ингредиент';

echo Breadcrumbs::widget([
    'homeLink' => [
        'label' => 'Главная',
        'url' => ['/']
    ],
    'links' => [
        ['label' => 'Ингредиенты', 'url' => ['ingredients']],
        ['label' => $this->title],
    ]
]);

$actionFailedMessage = Yii::$app->session->getFlash('actionFailed', null);

if ($actionFailedMessage !== null) {
    echo '<div class="alert alert-danger">'.$actionFailedMessage.'<br>'.'</div>';
}


echo $this->render('_ingredientform', [
    'model' => $model
]);
