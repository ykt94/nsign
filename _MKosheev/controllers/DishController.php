<?php
/**
 * Created by PhpStorm.
 * User: MadMax
 * Date: 06.02.2017
 * Time: 14:18
 */

namespace app\controllers;

use app\models\Ingredient;
use app\models\SearchForm;
use yii\helpers\ArrayHelper;
use yii\web\Controller;

class DishController extends Controller
{
    public function actionSearch()
    {
        $model = new SearchForm([
            'selectedIngredients' => [],
            'allIngredients' => ArrayHelper::map(Ingredient::findAll(['available' => 1]), 'id', 'name')
        ]);

        if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
            // запрос для проверки точного собпадения ингредиентов
            $queryString1 = 'SELECT tbl_dish.name, COUNT(tbl_cookbook.ingredient_id) AS i_count
                            FROM tbl_dish INNER JOIN tbl_cookbook ON tbl_dish.id = tbl_cookbook.dish_id
                            WHERE tbl_dish.id NOT IN (
                                SELECT dish_id
                                FROM tbl_cookbook
                                WHERE ingredient_id NOT IN ('.$model->ingredientIds.')
                                GROUP BY dish_id
                            )
                            GROUP BY tbl_dish.id
                            HAVING i_count = '.count($model->selectedIngredients);
            // запрос на проверку частичного собпадения ингредиентов
            $queryString2 = 'SELECT tbl_dish.name, COUNT(tbl_cookbook.ingredient_id) AS i_count
                            FROM tbl_dish INNER JOIN tbl_cookbook ON tbl_dish.id = tbl_cookbook.dish_id
                            WHERE tbl_dish.id NOT IN (
                                SELECT dish_id
                                FROM tbl_cookbook
                                WHERE ingredient_id NOT IN ('.$model->ingredientIds.')
                                GROUP BY dish_id
                            )
                            GROUP BY tbl_dish.id
                            HAVING i_count >= 2 AND i_count <= 5
                            ORDER BY i_count DESC';
            $cmd1 = \Yii::$app->db->createCommand($queryString1);
            $cmd2 = \Yii::$app->db->createCommand($queryString2);
            try {
                $dishs = $cmd1->queryAll();
                // если запрос на точное совпадение ничего не дал, то делаем запрос на частичное совпадение
                if (empty($dishs))
                    $dishs = $cmd2->queryAll();
            }
            catch (\Exception $e) {
                \Yii::$app->session->setFlash('actionFailed', 'При выполнении поиска произошла ошибка. Попробуйте еще раз или обратитесь к администратору');
            }
        }

        return $this->render('search', [
            'model' => $model,
            'dishs' => $dishs
        ]);
    }
}