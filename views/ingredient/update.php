<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Ingredients */

$this->title = 'Update Ingredients: ' . $model->ingredient;
$this->params['breadcrumbs'][] = ['label' => 'Ingredients', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ingredient_id, 'url' => ['view', 'id' => $model->ingredient_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="ingredients-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
