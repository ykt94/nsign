<?php
/**
 * Created by PhpStorm.
 * User: MadMax
 * Date: 06.02.2017
 * Time: 10:47
 * @var \yii\web\View $this
 * @var \app\models\Dish $model
 */

use yii\widgets\Breadcrumbs;

$this->title = 'Редактирование блюдо #'.$model->id;

echo Breadcrumbs::widget([
    'homeLink' => [
        'label' => 'Главная',
        'url' => ['/']
    ],
    'links' => [
        ['label' => 'Блюда', 'url' => ['dishs']],
        ['label' => $this->title],
    ]
]);

$actionFailedMessage = Yii::$app->session->getFlash('actionFailed', null);

if ($actionFailedMessage !== null) {
    echo '<div class="alert alert-danger">'.$actionFailedMessage.'<br>'.'</div>';
}


echo $this->render('_dishform', [
    'model' => $model,
    'ingredientsForm' => $ingredientsForm,
]);
