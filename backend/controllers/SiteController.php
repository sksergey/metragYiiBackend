<?php
namespace backend\controllers;

use backend\models\ApartmentFind;
use backend\models\MainSearch;
use common\models\Apartment;
use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;

/**
 * Site controller
 */
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
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index'],
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
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $model = new MainSearch();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $searchModel = $this->searchModelSelect($model->type_realty);
            if($searchModel){
                $searchModel->id = $model->id;
                $searchModel->phone = $model->phone;
            }
            $this->redirect('admin/apartment/searchresult?ApartmentFind%5Bphone%5D='.$model->phone.'&ApartmentFind%5Bid%5D='.$model->id);
            //return $this->render('entry-confirm', ['model' => $model]);
        } else {
            return $this->render('index', ['model' => $model]);
        }

    }

    public function searchModelSelect($type_realty){
        switch ($type_realty){
            case 'apartment':{
                $searchModel = new ApartmentFind();
                break;
            }
            case 'rent':{
                break;
            }
            case 'building':{
                break;
            }
            case 'house':{
                break;
            }
            case 'area':{
                break;
            }
            case 'commercial':{
                break;
            }
            default : {
                $searchModel = null;
            }
        }
        return $searchModel;
    }
    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
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
}
