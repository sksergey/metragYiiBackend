<?php

namespace backend\controllers;

use Yii;
use common\models\Apartment;
use backend\models\ApartmentSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use yii\data\ActiveDataProvider;
use yii\web\UploadedFile;

use backend\models\ApartmentFind;
use backend\models\RegionKharkivAdmin;
use backend\models\TypeObject;
use backend\models\Locality;
use backend\models\RegionKharkiv;
use backend\models\Region;
use backend\models\Street;
use backend\models\Course;
use backend\models\WallMaterial;
use backend\models\Condit;
use backend\models\Wc;
use backend\models\Users;
use backend\models\UserType;
use backend\models\Layout;
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
            /*return $this->render('create', [
                'model' => $model,
            ]);*/
            return $this->render('update', [
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
        $model = new ApartmentFind();
        return $this->render('find', ['model' => $model]);
        /*if (Yii::$app->request->post()) {
            //$dataProvider = $this->getSearchResult($post);
            //return $this->render('search-result',
            //['post' => $post, 'dataProvider' => $dataProvider]);
            //return $this->render('apartments', ['post' => $post]);
        } else {
            // страница отображается первый раз
            return $this->render('find', ['model' => $model]);
        }
        */
    }


    /*public function actionSearchresult()
    {
        $findModel = new ApartmentFind();
        //$dataProvider = $findModel->search(Yii::$app->request->queryParams);
        $dataProvider = $findModel->search(Yii::$app->request->get());
        //$findModel = new ApartmentSearch();
        //$dataProvider = $findModel->search(Yii::$app->request->get());
        //var_dump(Yii::$app->request->get());
        //die;
        //var_dump(Yii::$app->request->queryParams);
        //die;
        return $this->render('index', [
            //'searchModel' => $findModel,
            'dataProvider' => $dataProvider,
        ]);
    }*/

    public function actionSearchresult()
    {
        $get = Yii::$app->request->get();
        var_dump($get);
        //die;
        $query = Apartment::find();
        //begin filters
        $query->andFilterWhere(['>=', 'id', $get['ApartmentFind']['idFrom']]);
        $query->andFilterWhere(['<=', 'id', $get['ApartmentFind']['idTo']]);
        $query->andFilterWhere(['>=', 'count_room', $get['ApartmentFind']['count_roomFrom']]);
        $query->andFilterWhere(['<=', 'count_room', $get['ApartmentFind']['count_roomTo']]);
        $query->andFilterWhere(['>=', 'price', $get['ApartmentFind']['priceFrom']]);
        $query->andFilterWhere(['<=', 'price', $get['ApartmentFind']['priceTo']]);
        $query->andFilterWhere(['>=', 'floor', $get['ApartmentFind']['floorFrom']]);
        $query->andFilterWhere(['<=', 'floor', $get['ApartmentFind']['floorTo']]);
        $query->andFilterWhere(['>=', 'floor', $get['ApartmentFind']['floor_allFrom']]);
        $query->andFilterWhere(['<=', 'floor', $get['ApartmentFind']['floor_allTo']]);
        $query->andFilterWhere(['>=', 'total_area', $get['ApartmentFind']['total_areaFrom']]);
        $query->andFilterWhere(['<=', 'total_area', $get['ApartmentFind']['total_areaTo']]);
        $query->andFilterWhere(['>=', 'floor_area', $get['ApartmentFind']['floor_areaFrom']]);
        $query->andFilterWhere(['<=', 'floor_area', $get['ApartmentFind']['floor_areaTo']]);
        $query->andFilterWhere(['>=', 'kitchen_area', $get['ApartmentFind']['kitchen_areaFrom']]);
        $query->andFilterWhere(['<=', 'kitchen_area', $get['ApartmentFind']['kitchen_areaTo']]);
        //some problem((
        //$query->andFilterWhere(['>=', 'date_added', Yii::$app->formatter->asDateTime($get['ApartmentFind']['date_addedFrom'], 'yyyy-MM-dd HH:mm:ss')]);
        //$query->andFilterWhere(['<=', 'date_added', Yii::$app->formatter->asDateTime($get['ApartmentFind']['date_addedTo'], 'yyyy-MM-dd HH:mm:ss')]);

        $query->andFilterWhere(['type_object_id' => $get['ApartmentFind']['type_object_id']]);
        $query->andFilterWhere(['region_kharkiv_admin_id' => $get['ApartmentFind']['region_kharkiv_admin_id']]);
        $query->andFilterWhere(['region_kharkiv_id' => $get['ApartmentFind']['region_kharkiv_id']]);
        $query->andFilterWhere(['region_id' => $get['ApartmentFind']['region_id']]);
        $query->andFilterWhere(['locality_id' => $get['ApartmentFind']['locality_id']]);
        $query->andFilterWhere(['course_id' => $get['ApartmentFind']['course_id']]);
        $query->andFilterWhere(['street_id' => $get['ApartmentFind']['street_id']]);
        $query->andFilterWhere(['wall_material_id' => $get['ApartmentFind']['wall_material_id']]);
        $query->andFilterWhere(['condit_id' => $get['ApartmentFind']['condit_id']]);
        $query->andFilterWhere(['wc_id' => $get['ApartmentFind']['wc_id']]);
        $query->andFilterWhere(['update_author_id' => $get['ApartmentFind']['update_author_id']]);
        $query->andFilterWhere(['author_id' => $get['ApartmentFind']['author_id']]);
        $query->andFilterWhere(['update_photo_user_id' => $get['ApartmentFind']['update_photo_user_id']]);
        $query->andFilterWhere(['exclusive_user_id' => $get['ApartmentFind']['exclusive_user_id']]);

        if($get['ApartmentFind']['middle_floor'] == '0'){
            $query->andFilterWhere(['floor' => '1']);
            //$query->orWhere(['like', 'floor', apartment.floor_all]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
        return $this->render('find-result', ['dataProvider' => $dataProvider]);

        //$searchModel = new ApartmentSearch();
        return $this->render('index', [
            //'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function andFilterWhereactionAdd()
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

    public function actionLinkConvertor()
    {
        $count = Apartment::find()->count();

        return $this->render('linkconvertor', ['count' => $count]);
    }

    public function actionLinkimages($start = 0)
    {
        $posts = Yii::$app->db->createCommand("SELECT * FROM apartment ORDER BY id desc LIMIT $start, 50")
                ->queryAll();
            foreach ($posts as $post)
            {
                $photos = Yii::$app->db->createCommand("SELECT * FROM photo WHERE  `type_realty_id`= 2 AND `object_id`= {$post['id']}")
                    ->queryAll();
                if(!empty($photos))  
                {
                    foreach ($photos as $photo)
                            {
                                $model = Apartment::findOne($post['id']);
                                $ph_path = explode('/upload/images', $photo['path']);
                                $path = Yii::getAlias('@webroot')."/../../upload".$ph_path['1'];
                                //$path = Yii::getAlias('@webroot')."/../..".$photo['path'];
                                if(file_exists($path)){
                                $model->attachImage($path);
                                //echo "ok ".$post['id']."--".$path."<br>";
                                }
                                /*else
                                    echo "no photo in folder by id". $post['id'] . "!!".$path."<br>";*/
                            }}
                /*else
                    echo "no photo by id". $post['id'] . "!!<br>";*/

            }
            $start += 50;
        echo $start;
    }

    public function actionFileDelete()
    {
        echo $id = Yii::$app->request->post('key');
        echo Apartment::deleteImage($id);
        /*
        var_dump($key) ;
        $post = Yii::$app->request->post();
        var_dump($post);
        $get = Yii::$app->request->get();
        var_dump($get);*/
    }

    public function test()
    {
        echo "test";
    }
}
