<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Binder */

$this->title = $model->recipe_id;
$this->params['breadcrumbs'][] = ['label' => 'Binders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="binder-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'recipe_id' => $model->recipe_id, 'ingredient_id' => $model->ingredient_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'recipe_id' => $model->recipe_id, 'ingredient_id' => $model->ingredient_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'recipe_id',
            'ingredient_id',
        ],
    ]) ?>

</div>
