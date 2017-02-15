<?php
/**
 * Created by PhpStorm.
 * User: MadMax
 * Date: 06.02.2017
 * Time: 9:52
 */

namespace app\controllers;

use app\models\Dish;
use app\models\IngredientsForm;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use app\models\Ingredient;
use yii\web\NotFoundHttpException;

class AdminController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function($rule, $action) {
                            return (\Yii::$app->user->identity != null ? \Yii::$app->user->identity->isAdmin : false);
                        }
                    ]
                ]
            ]
        ];
    }

    public function actionIngredients()
    {
        $ingredients = new ActiveDataProvider([
            'query' => Ingredient::find(),
            'pagination' => [
                'pageSize' => 20
            ]
        ]);

        return $this->render('ingredients', [
            'ingredients' => $ingredients
        ]);
    }

    public function actionDishs()
    {
        $dishs = new ActiveDataProvider([
            'query' => Dish::find(),
            'pagination' => [
                'pageSize' => 20
            ]
        ]);

        return $this->render('dishs', [
            'dishs' => $dishs
        ]);
    }

    public function actionCreateingredient()
    {
        $ingredient = new Ingredient();

        if ($ingredient->load(\Yii::$app->request->post())) {
            try {
                if (!$ingredient->save())
                    throw new \Exception();
                \Yii::$app->session->setFlash('actionSuccess', 'Ингредиент успешно создан', false);
                $this->redirect(['ingredients']);
            }
            catch (\Exception $e) {
                \Yii::$app->session->setFlash('actionFailed', 'При сохрании ингредиента произошла ошибка');
            }
        }
        return $this->render('createingredient', [
            'model' => $ingredient
        ]);
    }

    public function actionCreatedish()
    {
        $dish = new Dish();
        $ingredientsForm = new IngredientsForm([
            'selectedIngredients' => [],
            'allIngredients' => ArrayHelper::map(Ingredient::findAll(['available' => 1]), 'id', 'name')
        ]);

        if ($dish->load(\Yii::$app->request->post())) {
            try {
                if (!$dish->save())
                    throw new \Exception();
                // сохраняем данные по ингредиентам
                $ingredientsForm->load(\Yii::$app->request->post());
                $rows = [];
                foreach ($ingredientsForm->selectedIngredients as $ingredientId => $ingredientName) {
                    $rows[] = [$dish->id, $ingredientId];
                }
                \Yii::$app->db->createCommand()
                    ->batchInsert('tbl_cookbook', ['dish_id', 'ingredient_id'], $rows)
                    ->execute();
                \Yii::$app->session->setFlash('actionSuccess', 'Блюдо успешно создано', false);
                $this->redirect(['dishs']);
            }
            catch(\Exception $e) {
                \Yii::$app->session->setFlash('actionFailed', 'При сохрании блюда произошла ошибка');
            }
        }
        return $this->render('createdish', [
            'model' => $dish,
            'ingredientsForm' => $ingredientsForm
        ]);
    }

    public function actionUpdateingredient($id)
    {
        $ingredient = Ingredient::findOne(['id' => $id]);

        if ($ingredient === null)
            throw new NotFoundHttpException('Ингредиент не найден');

        if ($ingredient->load(\Yii::$app->request->post())) {
            try {
                if (!$ingredient->save())
                    throw new \Exception();
                \Yii::$app->session->setFlash('actionSuccess', 'Ингредиент успешно изменен', false);
                $this->redirect(['ingredients']);
            }
            catch (\Exception $e) {
                \Yii::$app->session->setFlash('actionFailed', 'При сохрании ингредиента произошла ошибка');
            }
        }
        return $this->render('updateingredient', [
            'model' => $ingredient
        ]);
    }

    public function actionUpdatedish($id)
    {
        $dish = Dish::findOne(['id' => $id]);

        if ($dish === null)
            throw new NotFoundHttpException('Блюдо не найдено');

        $ingredientsForm = new IngredientsForm([
            'selectedIngredients' => ArrayHelper::map($dish->ingredients, 'id', 'name'),
            'allIngredients' => ArrayHelper::map(Ingredient::findAll(['available' => 1]), 'id', 'name')
        ]);

        if ($dish->load(\Yii::$app->request->post())) {
            try {
                if (!$dish->save())
                    throw new \Exception();
                // удаляем все данные по ингредиентам
                \Yii::$app->db->createCommand()
                    ->delete('tbl_cookbook', ['dish_id' => $dish->id])
                    ->execute();
                // сохраняем данные по ингредиентам
                $ingredientsForm->load(\Yii::$app->request->post());
                $rows = [];
                foreach ($ingredientsForm->selectedIngredients as $ingredientId => $ingredientName) {
                    $rows[] = [$dish->id, $ingredientId];
                }
                \Yii::$app->db->createCommand()
                    ->batchInsert('tbl_cookbook', ['dish_id', 'ingredient_id'], $rows)
                    ->execute();
                \Yii::$app->session->setFlash('actionSuccess', 'Блюдо успешно изменено', false);
                $this->redirect(['dishs']);
            }
            catch(\Exception $e) {
                \Yii::$app->session->setFlash('actionFailed', 'При сохрании блюда произошла ошибка'.$e->getMessage());
            }
        }
        return $this->render('updatedish', [
            'model' => $dish,
            'ingredientsForm' => $ingredientsForm
        ]);
    }

    public function actionDeleteingredient($id)
    {
        $ingredient = Ingredient::findOne(['id' => $id]);

        if ($ingredient === null)
            throw new NotFoundHttpException('Ингредиент не найден');

        $ingredient->available = false;

        if ($ingredient->save(true, ['available'])) {
            \Yii::$app->session->setFlash('actionSuccess', 'Ингредиент успешно удален', false);
        }
        else {
            \Yii::$app->session->setFlash('actionFailed', 'Во время удаления ингредиента произошла ошибка');
        }

        $ingredients = new ActiveDataProvider([
            'query' => Ingredient::find(),
            'pagination' => [
                'pageSize' => 20
            ]
        ]);

        return $this->render('ingredients', [
            'ingredients' => $ingredients
        ]);
    }

    public function actionDeletedish($id)
    {
        $dish = Dish::findOne(['id' => $id]);

        if ($dish === null)
            throw new NotFoundHttpException('Блюдо не найдено');

        $dish->available = false;

        if ($dish->save(true, ['available'])) {
            \Yii::$app->session->setFlash('actionSuccess', 'Блюдо успешно удалено', false);
        }
        else {
            \Yii::$app->session->setFlash('actionFailed', 'Во время удаления блюда произошла ошибка');
        }

        $dishs = new ActiveDataProvider([
            'query' => Dish::find(),
            'pagination' => [
                'pageSize' => 20
            ]
        ]);

        return $this->render('dishs', [
            'dishs' => $dishs
        ]);
    }
}