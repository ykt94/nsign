<?php

namespace app\controllers;

use Yii;
use app\models\Binder;
use app\models\BinderSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * BinderController implements the CRUD actions for Binder model.
 */
class BinderController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Binder models.
     * @return mixed
     */
    public function actionIndex($recipe_id)
    {
        $searchModel = new BinderSearch();
        
        $searchModel->recipe_id = $recipe_id;
        
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Binder model.
     * @param integer $recipe_id
     * @param integer $ingredient_id
     * @return mixed
     */
    public function actionView($recipe_id, $ingredient_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($recipe_id, $ingredient_id),
        ]);
    }

    /**
     * Creates a new Binder model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Binder();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'recipe_id' => $model->recipe_id, 'ingredient_id' => $model->ingredient_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Binder model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $recipe_id
     * @param integer $ingredient_id
     * @return mixed
     */
    public function actionUpdate($recipe_id, $ingredient_id)
    {
        $model = $this->findModel($recipe_id, $ingredient_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'recipe_id' => $model->recipe_id, 'ingredient_id' => $model->ingredient_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }
    
    public function actionAdd($recipe_id)
    {
        $model = new Binder();
        $model->recipe_id = $recipe_id;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'recipe_id' => $model->recipe_id, 'ingredient_id' => $model->ingredient_id]);
        } else {
            return $this->render('add', ['model' => $model,]);
        }
    }
    

    /**
     * Deletes an existing Binder model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $recipe_id
     * @param integer $ingredient_id
     * @return mixed
     */
    public function actionDelete($recipe_id, $ingredient_id)
    {
        $this->findModel($recipe_id, $ingredient_id)->delete();

        return $this->redirect(['index']);
    }
    
    
    
    

    /**
     * Finds the Binder model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $recipe_id
     * @param integer $ingredient_id
     * @return Binder the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($recipe_id, $ingredient_id)
    {
        if (($model = Binder::findOne(['recipe_id' => $recipe_id, 'ingredient_id' => $ingredient_id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
