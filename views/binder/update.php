<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Binder */

$this->title = 'Update Binder: ' . $model->recipe_id;
$this->params['breadcrumbs'][] = ['label' => 'Binders', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->recipe_id, 'url' => ['view', 'recipe_id' => $model->recipe_id, 'ingredient_id' => $model->ingredient_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="binder-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
