<?php
/**
 * Created by PhpStorm.
 * User: Миша
 * Date: 29.09.2017
 * Time: 8:55
 */

namespace app\controllers;


use app\models\LoginForm;
use app\models\SignupForm;
use Yii;
use yii\web\Controller;

class AuthController extends Controller{
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }
    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }


    public function actionSignup(){
        $model = new SignupForm();

        if(Yii::$app->request->isPost){
            $model->load(Yii::$app->request->post());
            if($model->signup()){
                return $this->redirect(['auth/login']);
            }
        }

        return $this->render('signup',[
           'model' => $model
        ]);
    }
}