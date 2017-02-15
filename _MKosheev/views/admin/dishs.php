<?php
/**
 * Created by PhpStorm.
 * User: MadMax
 * Date: 06.02.2017
 * Time: 10:16
 *
 * @var \yii\web\View $this
 * @var \yii\data\ActiveDataProvider $dishs
 */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Breadcrumbs;

$this->title = 'Список блюд';

echo Breadcrumbs::widget([
    'homeLink' => [
        'label' => 'Главная',
        'url' => ['/']
    ],
    'links' => [
        ['label' => $this->title],
    ]
]);

$actionSuccessMessage = Yii::$app->session->getFlash('actionSuccess', null);

if ($actionSuccessMessage !== null) {
    echo '<div class="alert alert-success">'.$actionSuccessMessage.'</div>';
}

echo Html::a('Добавить', Url::to(['admin/createdish']), ['class' => 'btn btn-lg btn-success']);

echo GridView::widget([
    'dataProvider' => $dishs,
    'emptyText' => 'Блюд пока нет',
    'summary' => 'Показано <b>{begin, number}-{end, number}</b> из <b>{totalCount, number}</b> {totalCount, plural, one{блюдо} other{блюд}}.',
    'columns' => [
        [
            'class' => 'yii\grid\SerialColumn',
            'headerOptions' => [
                'width' => '30px'
            ]
        ],
        [
            'attribute' => 'available',
            'value' => function(\app\models\Dish $ingredient) {
                return $ingredient->available ? 'Да' : 'Нет';
            },
            'headerOptions' => [
                'width' => '10px'
            ]
        ],
        'name',
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{update}{delete}',
            'buttons' => [
                'update' => function($url, $model, $key) {
                    $options = [
                        'title' => Yii::t('yii', 'Update'),
                        'aria-label' => Yii::t('yii', 'Update'),
                        'data-pjax' => '0',
                    ];
                    $url = Url::to(['/admin/updatedish', 'id' => $key]);
                    return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, $options);
                },
                'delete' => function($url, $model, $key) {
                    $options = [
                        'title' => Yii::t('yii', 'Delete'),
                        'aria-label' => Yii::t('yii', 'Delete'),
                        'data-confirm' => Yii::t('yii', 'Удалить это блюдо?'),
                        'data-method' => 'post',
                        'data-pjax' => '0',
                    ];
                    $url = Url::to(['/admin/deletedish', 'id' => $key]);
                    return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, $options);
                },
            ],
            'headerOptions' => [
                'width' => '70px'
            ]
        ]
    ]
]);

