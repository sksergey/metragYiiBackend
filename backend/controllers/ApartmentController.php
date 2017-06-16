<?php

namespace backend\controllers;

use Yii;
use common\models\Apartment;
use common\models\ApartmentSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use yii\data\ActiveDataProvider;
use yii\web\UploadedFile;

use backend\models\ApartmentFind;
use app\modules\olxparser\models\Parser;
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
        $model = $this->findModel($id);
        $model->getResouseBoards('apartment');
        return $this->render('view', [
            'model' => $model,
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
        $model->getResouseBoards('apartment');

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            //$model->setResourseBoards();
            //return $this->redirect(['view', 'id' => $model->id]);
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
        $model = $this->findModel($id);
        $model->enabled = 0;
        $model->update(false);
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
        //var_dump($get);
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
        //TODO date filter some problem((
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
        $query->andFilterWhere(['like', 'phone', $get['ApartmentFind']['phone']]);
        //TODO this filter
        if($get['ApartmentFind']['middle_floor'] == '0'){
            $query->andFilterWhere(['floor' => '1']);
            //$query->orWhere(['like', 'floor', apartment.floor_all]);
        }

        if($get['ApartmentFind']['no_mediators'] == '1' ){
            $query->andWhere(['is', 'mediator_id', NULL]);
        }
        if($get['ApartmentFind']['no_mediators'] == '0' ){
            $query->andWhere(['not',['mediator_id' => NULL]]);
        }

        if($get['ApartmentFind']['exchange'] == '1' ){
            $query->andWhere(['=', 'exchange', '1']);
        }
        if($get['ApartmentFind']['exchange'] == '0' ){
            $query->andWhere(['=', 'exchange', '0']);
        }

        if($get['ApartmentFind']['enabled'] == '0' ){
            $query->andFilterWhere(['=', 'enabled', '0']);
        }
        if($get['ApartmentFind']['enabled'] == '1' ){
            $query->andFilterWhere(['=', 'enabled', '1']);
        }

        if($get['ApartmentFind']['note'] == 1 ){
            $query->andFilterWhere(['>', 'length(note)', '0']);
        }
        if($get['ApartmentFind']['note'] == 0 ){
            $query->andFilterWhere(['=', 'length(note)', '0']);
        }

        //TODO phone filter

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
                                $path = Yii::getAlias('@webroot')."/../../upload/images".$ph_path['1'];
                                if(file_exists($path)){
                                $model->attachImage($path);
                                }
                            }}
            }
            $start += 50;
        echo $start;
    }

    public function actionFileDelete()
    {
        echo $id = Yii::$app->request->post('key');
        echo Apartment::deleteImage($id);
    }

    public function actionAddFromParser($id)
    {
        $parser_model = Parser::findOne($id);
        $apartment_model = new Apartment();
        $apartment_model->note = $parser_model->link;
        $apartment_model->type_object_id = $parser_model->type_object_id;
        $apartment_model->count_room = $parser_model->count_room;
        $apartment_model->floor = $parser_model->floor;
        $apartment_model->floor_all = $parser_model->floor_all;
        $apartment_model->total_area = $parser_model->total_area;
        $apartment_model->floor_area = $parser_model->floor_area;
        $apartment_model->kitchen_area = $parser_model->kitchen_area;
        $price = explode(' ',$parser_model->price);
        $apartment_model->price = intval(trim($price['0']).trim($price['1']));
        $apartment_model->source_info_id = 4;
        $apartment_model->phone = $parser_model->phone;
        $apartment_model->notesite = $parser_model->note;
        $images = unserialize($parser_model->image);


        if ($apartment_model->load(Yii::$app->request->post()) && $apartment_model->save()) {
            return $this->redirect(['view', 'id' => $apartment_model->id]);
        } else {
            return $this->render('update_from_parser', [
                'model' => $apartment_model, 'images' => $images
            ]);
        }
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
        if(!$model['author_id']) $model['author_id'] = Yii::$app->user->id;
        else $model['update_author_id'] = Yii::$app->user->id;

        //if(!empty(UploadedFile::getInstances($model, 'imageFiles'))){ err WTF?
        if(UploadedFile::getInstances($model, 'imageFiles')){
            $model['update_photo_user_id'] = Yii::$app->user->id;
        }
        if($model->save()){
            $model->besplatka = $values['besplatka'];
            $model->est = $values['est'];
            $model->mesto = $values['mesto'];
            $model->setResourseBoards('apartment');
            $model->imageFiles = UploadedFile::getInstances($model, 'imageFiles');
            $model->upload();
        }

        $data['id'] = $model->id;
        $apart = Apartment::findOne($data['id']);
        $apart->getResouseBoards('apartment');
        return $this->render('view', ['data' => $data, 'model' => $apart]);
    }
}
