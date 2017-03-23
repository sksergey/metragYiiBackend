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
        //$model = [];
        /*
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
        */
        $model = new ApartmentFind();

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
        $findModel = new ApartmentFind();
        //$dataProvider = $findModel->search(Yii::$app->request->queryParams);
        $dataProvider = $findModel->search(Yii::$app->request->get());
        var_dump(Yii::$app->request->get());
        die;
        //var_dump(Yii::$app->request->queryParams);
        //die;
        return $this->render('index', [
            'searchModel' => $findModel,
            'dataProvider' => $dataProvider,
        ]);
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
