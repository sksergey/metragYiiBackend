<?php

namespace backend\controllers;

use Yii;
use app\models\Apartment;
use app\models\ApartmentSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use yii\data\ActiveDataProvider;
use yii\web\UploadedFile;

use app\models\ApartmentFind;
use app\models\RegionKharkivAdmin;
use app\models\TypeObject;
use app\models\Locality;
use app\models\RegionKharkiv;
use app\models\Region;
use app\models\Street;
use app\models\Course;
use app\models\WallMaterial;
use app\models\Condit;
use app\models\Wc;
use app\models\Users;
use app\models\UserType;
use app\models\Layout;
/**
 * ApartmentController implements the CRUD actions for Apartment model.
 */
class ApartmentController extends Controller
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
     * Lists all Apartment models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ApartmentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Apartment model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Apartment model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Apartment();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Apartment model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Apartment model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Apartment model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Apartment the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Apartment::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    //-------------------------------------------------

    public function actionSearch()
    {
        $model = [];

        $model['ApartmentFind'] = new ApartmentFind();
        $model['RegionKharkivAdmin'] = new RegionKharkivAdmin();
        $model['TypeObject'] = new TypeObject();
        $model['Locality'] = new Locality();
        $model['Layout'] = new Layout();
        $model['RegionKharkiv'] = new RegionKharkiv();
        $model['Region'] = new Region();
        $model['Street'] = new Street();
        $model['Course'] = new Course();
        $model['WallMaterial'] = new WallMaterial();
        $model['Condit'] = new Condit();
        $model['Wc'] = new Wc();
        $model['Users'] = new Users();
        $model['UserType'] = new UserType();

        if (Yii::$app->request->post()) {

            //$url = Url::toRoute('/agency/testview');
            //return $this->redirect($url);

            //$post = Yii::$app->request->post();
            
            //print_r($post);
            /*
            $dataProvider = $this->getSearchResult($post);



            return $this->render('search-result',
            ['post' => $post, 'dataProvider' => $dataProvider]);
            */
            //return $this->render('apartments', ['post' => $post]);
        } else {
            // страница отображается первый раз
            return $this->render('find', ['model' => $model]);
        }
        
    }

    public function actionSearchresult()
    {
        $get = Yii::$app->request->get();

        $query = Apartment::find();

        if(!empty($get['ApartmentFind']['idFrom']))
        $query->andFilterWhere(['>=', 'id', $get['ApartmentFind']['idFrom']]);
        if(!empty($get['ApartmentFind']['idTo']))
        $query->andFilterWhere(['<=', 'id', $get['ApartmentFind']['idTo']]);
        if(!empty($get['ApartmentFind']['count_roomFrom']))
        $query->andFilterWhere(['>=', 'count_room', $get['ApartmentFind']['count_roomFrom']]);
        if(!empty($get['ApartmentFind']['count_roomTo']))
        $query->andFilterWhere(['<=', 'count_room', $get['ApartmentFind']['count_roomTo']]);
        if(!empty($get['ApartmentFind']['priceFrom']))
        $query->andFilterWhere(['>=', 'price', $get['ApartmentFind']['priceFrom']]);
        if(!empty($get['ApartmentFind']['priceTo']))
        $query->andFilterWhere(['<=', 'price', $get['ApartmentFind']['priceTo']]);
        if(!empty($get['ApartmentFind']['floorFrom']))
        $query->andFilterWhere(['>=', 'floor', $get['ApartmentFind']['floorFrom']]);
        if(!empty($get['ApartmentFind']['floorTo']))
        $query->andFilterWhere(['<=', 'floor', $get['ApartmentFind']['floorTo']]);
        if(!empty($get['ApartmentFind']['floorFrom']))
        $query->andFilterWhere(['>=', 'floor', $get['ApartmentFind']['floorFrom']]);
        if(!empty($get['ApartmentFind']['floorTo']))
        $query->andFilterWhere(['<=', 'floor', $get['ApartmentFind']['floorTo']]);
        if(!empty($get['ApartmentFind']['total_areaFrom']))
        $query->andFilterWhere(['>=', 'total_area', $get['ApartmentFind']['total_areaFrom']]);
        if(!empty($get['ApartmentFind']['total_areaTo']))
        $query->andFilterWhere(['<=', 'total_area', $get['ApartmentFind']['total_areaTo']]);
        if(!empty($get['ApartmentFind']['floor_areaFrom']))
        $query->andFilterWhere(['>=', 'floor_area', $get['ApartmentFind']['floor_areaFrom']]);
        if(!empty($get['ApartmentFind']['floor_areaTo']))
        $query->andFilterWhere(['<=', 'floor_area', $get['ApartmentFind']['floor_areaTo']]);
        if(!empty($get['ApartmentFind']['kitchen_areaFrom']))
        $query->andFilterWhere(['>=', 'kitchen_area', $get['ApartmentFind']['kitchen_areaFrom']]);
        if(!empty($get['ApartmentFind']['kitchen_areaTo']))
        $query->andFilterWhere(['<=', 'kitchen_area', $get['ApartmentFind']['kitchen_areaTo']]);

        if(!empty($get['TypeObject']['type_object_id']))
        $query->andwhere(['type_object_id' => $get['TypeObject']['type_object_id']]);
        if(!empty($get['RegionKharkivAdmin']['region_kharkiv_admin_id']))
        $query->andwhere(['region_kharkiv_admin_id' => $get['RegionKharkivAdmin']['region_kharkiv_admin_id']]);
        if(!empty($get['RegionKharkiv']['region_kharkiv_id']))
        $query->andwhere(['region_kharkiv_id' => $get['RegionKharkiv']['region_kharkiv_id']]);
        if(!empty($get['Region']['region_id']))
        $query->andwhere(['region_id' => $get['Region']['region_id']]);
        if(!empty($get['Locality']['locality_id']))
        $query->andwhere(['locality_id' => $get['Locality']['locality_id']]);
        if(!empty($get['Course']['course_id']))
        $query->andwhere(['course_id' => $get['Course']['course_id']]);
        if(!empty($get['Street']['street_id']))
        $query->andwhere(['street_id' => $get['Street']['street_id']]);
        if(!empty($get['WallMaterial']['wall_material_id']))
        $query->andwhere(['wall_material_id' => $get['WallMaterial']['wall_material_id']]);
        if(!empty($get['Condit']['condit_id']))
        $query->andwhere(['condit_id' => $get['Condit']['condit_id']]);
        if(!empty($get['Wc']['wc_id']))
        $query->andwhere(['wc_id' => $get['Wc']['wc_id']]);
        if(!empty($get['Users']['update_author_id']))
        $query->andwhere(['update_author_id' => $get['Users']['update_author_id']]);
        if(!empty($get['Users']['author_id']))
        $query->andwhere(['author_id' => $get['Users']['author_id']]);
        if(!empty($get['Users']['update_photo_user_id']))
        $query->andwhere(['update_photo_user_id' => $get['Users']['update_photo_user_id']]);
        if(!empty($get['Users']['exclusive_user_id']))
        $query->andwhere(['exclusive_user_id' => $get['Users']['exclusive_user_id']]);
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
        
        $searchModel = new ApartmentSearch();
        

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);


        return $this->render('find-result', ['dataProvider' => $dataProvider]);
    }

    public function actionAdd()
    {
        $values = Yii::$app->request->post('Apartment');
        if($values['id'] !='')
        {
            $model = Apartment::findOne($values['id']);
        }
        else
        {
            $model = new Apartment();
        }
        
        $model->attributes = $values;
        //$model->imageFiles = UploadedFile::getInstances($model, 'imageFiles');
        //var_dump($model->imageFiles);
        //die;
        if($model->save()){
            $model->imageFiles = UploadedFile::getInstances($model, 'imageFiles');
            $model->upload();
        }
        
        $data['id'] = $model->id;
        //var_dump($data['id']);
        //die;
        $apart = Apartment::findOne($data['id']);
        return $this->render('view', ['data' => $data, 'model' => $apart]);
    }
}
