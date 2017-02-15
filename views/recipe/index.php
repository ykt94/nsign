<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Ingredients;

/* @var $this yii\web\View */
/* @var $searchModel app\models\RecipesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Recipes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="recipes-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        
        <?= Html::a('Create Recipes', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'recipe_id',
            'recipe',
            

            ['class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete} {link}',
                'buttons' => [
                    'update' => function ($url,$model) {
                        return Html::a(
                        '<span class="glyphicon glyphicon-screenshot"></span>', 
                        $url);
                    },
                    
                    'link' => function ($url,$model,$key) {
                        $url = Url::toRoute(['binder/index', 'recipe_id' => $key]);
                        return Html::a('Ингредиенты', $url);
                    },
                ],                
            ],
        ],
    ]); ?>
</div>
