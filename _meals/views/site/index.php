<?php

/* @var $this yii\web\View */

use yii\widgets\Pjax;
use yii\helpers\Html;

$this->title = 'My Yii Application';

?>
<div class="site-index">
    <?php Pjax::begin(); ?>
    <div class="col-lg-4">
        <h2>Инградиенты</h2>
        <?= Html::beginForm(['site/index'], 'post', ['data-pjax' => '', ]); ?>
        <?php if (isset($products)): ?>
            <?php foreach ($products as $product): ?>
                <?= Html::input('checkbox', 'p'.$product->id, $product->id ) ?><?=$product->name?></br>
            <?php endforeach; ?>

        <?php endif; ?>
        <?= Html::submitButton("Подобрать",  ['class' => 'btn btn-lg btn-success']) ?>
        <?= Html::endForm(); ?>
    </div>

    <div class="body-content">

        <div class="row">
            <?php if (isset($meals)): ?>
                <p><b>Выбрано:  </b>
                <?php foreach ($selected as $product): ?>
                    <?= $product->name.'  ' ?>
                <?php endforeach; ?></p>
                <?php foreach ($meals as $meal): ?>
                    <div class="col-lg-2">
                        <h3 class="row"><?= $meal->name ?></h3>
                        <?php foreach($meal->ingredients as $ingredient): ?>


                            <div class="row">
                                <?= $ingredient->product->name ?>
                            </div>
                        <?php endforeach; ?>

                    </div>
                <?php endforeach; ?>
            <?php elseif (isset($selected)): ?>
                <p><b>Выбрано:  </b>
                    <?php foreach ($selected as $product): ?>
                        <?= $product->name.'  ' ?>
                    <?php endforeach; ?></p>
                <h2>Ничего не найдено!</h2>
            <?php else: ?>
                <h2>Выберите больше ингредиентов!</h2>
            <?php endif; ?>
        </div>

    </div>
    <?php Pjax::end(); ?>
</div>
