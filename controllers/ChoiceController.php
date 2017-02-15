<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\ChoiceForm;
use app\models\Binder;
use app\models\Recipes;

/**
 * Description of Choice
 *
 * @author 1303
 */
class ChoiceController extends Controller {
    //put your code here
    public function actionIndex(){
        $model = new ChoiceForm();
        if ($model->load(Yii::$app->request->post())) {
            $message = '';
            if(count($model->choice)>1){
				$x = array(); //key -> recipes_id, value ->кол выбранных ингредиентов для данного массива
				//обхожу все выбранные ингредиенты
				for($i = 0; $i < count($model->choice); $i++){
					$binders = Binder::find()
						->where(['ingredient_id' => (int)$model->choice[$i]])
						->orderBy('recipe_id')
						->all();
					foreach($binders as $binder)
						if(array_key_exists($binder->recipe_id,$x)){
							$x[$binder->recipe_id]++; 
						} else {
							$x[$binder->recipe_id] = 1;
						}
				}
				arsort($x);
				//блюда с полным совпадением
				if(array_search($i,$x)){
					foreach($x as $key => $value) { 
						if($value == $i){
							$s[] = $key; //массив хранит перечень id рецептов
						} else {
							break;
						}    
					}
				} else {
					//неполное совпадение
					if(count($x)>0){
						foreach($x as $key => $value) { 
							if($value > 1){
								$s[] = $key; 
							} else {
								break;
							}    
						}
					} else {
						$message = 'Ничего не найдено';
					}    
				}
            } else { 
                $message = 'Выберите больше ингредиентов';
            }
			if(!isset($s))$s[] = 0;
            $rows = Recipes::findAll($s);
            return $this->render('list', ['s' => count($model->choice), 'message' => $message,'models' => $rows]);
        } else {
            return $this->render('index', ['model' => $model]);
        }
    }
    
}
