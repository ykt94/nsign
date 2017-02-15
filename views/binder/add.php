<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use app\models\Ingredients;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $model app\models\Binder */

$this->title = 'Add ingredient';
//$this->params['breadcrumbs'][] = ['label' => 'Binders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="binder-create">

    <h1><?= Html::encode($this->title) ?></h1>

<?php
    $form = ActiveForm::begin();

    // получаем всех авторов
    $ingredients = Ingredients::find()->all();
    // формируем массив, с ключем равным полю 'id' и значением равным полю 'name' 
    $items = ArrayHelper::map($ingredients,'ingredient_id','ingredient');
    $params = [
        'prompt' => 'Выберите ингредиент'
    ];
    echo $form->field($model, 'ingredient_id')->dropDownList($items,$params);
?>
    <div class="form-group">
<!--        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?> -->
        <?= Html::submitButton('Save' , ['class' => 'btn btn-success']) ?>
    </div>    
    
<?php
    ActiveForm::end();
?>
    
    
    
</div>
