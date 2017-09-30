<?php

namespace app\controllers;

use app\models\Article;
use app\models\Category;
use app\models\CommentForm;
use Yii;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $data = Article::getAll();
        $popular = Article::getPopular();
        $recent = Article::getRecent();
        $category = Category::find()->all();

        return $this->render('index', [
            'models' => $data['articles'],
            'pages' => $data['pagination'],
            'popular' => $popular,
            'recent' => $recent,
            'category' => $category,
        ]);

    }

    /**
     * Login action.
     *
     * @return Response|string
     */
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

    public function actionView($id){
        $article = Article::findOne($id);

        $popular = Article::getPopular();
        $recent = Article::getRecent();
        $category = Category::find()->all();
        $comments = $article->comment;
        $commentForm = new CommentForm();

        $article->viewedCount();

        return $this->render('single',[
            'article' => $article,
            'popular' => $popular,
            'recent' => $recent,
            'category' => $category,
            'comments' => $comments,
            'commentForm' =>$commentForm
        ]);
    }

    public function actionCategory($id){

        $query = Article::find()->where(['category_id'=>$id]);

        $popular = Article::getPopular();
        $recent = Article::getRecent();
        $category = Category::find()->all();

        $countQuery = clone $query;

        $pages = new Pagination([
            'totalCount' => $countQuery->count(),
            'pageSize' => 6,
        ]);

        $models = $query
            ->offset($pages->offset) //кол-во записей которые можно выбрать назад
            ->limit($pages->limit)
            ->all();

        $data ['articles'] = $models;
        $data ['pagination'] = $pages;

        return $this->render('category',[
            'articles'=>$data['articles'],
            'pagination'=>$data['pagination'],
            'popular' => $popular,
            'recent' => $recent,
            'category' => $category,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact(){
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout(){
        return $this->render('about');
    }


    public function actionSearch(){
        $q = trim(Yii::$app->request->get('q'));
        $query = Category::find()->where(['like','title',$q])->all();

        return $this->render('search', compact('query'));
    }

    public function actionComment($id){
        $model = new CommentForm();

        if(Yii::$app->request->isPost){
            $model->load(Yii::$app->request->post());
            if ($model->saveComment($id)){
                return $this->redirect(['site/view','id'=>$id]);
            }
        }
    }
}
