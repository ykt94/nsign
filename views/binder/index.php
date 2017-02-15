<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Recipes;

/* @var $this yii\web\View */
/* @var $searchModel app\models\BinderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$recipe = Recipes::findOne($searchModel->recipe_id);

$this->title = $recipe->recipe;
$this->params['breadcrumbs'][] = $this->title;


?>
<div class="binder-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Add ingredient', ['add', 'recipe_id' => $recipe->recipe_id], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'recipe_id',
            //'ingredient_id',
            [
                'attribute' => 'Ingredients',
                'value' => 'ingredient.ingredient'
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
