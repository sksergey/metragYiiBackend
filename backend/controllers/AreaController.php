<?php

namespace backend\controllers;

use Yii;
use common\models\Area;
use common\models\AreaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
/**
 * AreaController implements the CRUD actions for Area model.
 */
class AreaController extends Controller
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
     * Lists all Area models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AreaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Area model.
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
     * Creates a new Area model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Area();

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
     * Updates an existing Area model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->getResouseBoards('area');

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
     * Deletes an existing Area model.
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
     * Finds the Area model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Area the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Area::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionLinkConvertor()
    {
        $count = Area::find()->count();

        return $this->render('linkconvertor', ['count' => $count]);
    }

    public function actionLinkimages($start = 0)
    {
        $posts = Yii::$app->db->createCommand("SELECT * FROM area ORDER BY id desc LIMIT $start, 50")
            ->queryAll();
        foreach ($posts as $post)
        {
            $photos = Yii::$app->db->createCommand("SELECT * FROM photo WHERE  `type_realty_id`= 5 AND `object_id`= {$post['id']}")
                ->queryAll();
            if(!empty($photos))
            {
                foreach ($photos as $photo)
                {
                    $model = Area::findOne($post['id']);
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
        echo Area::deleteImage($id);
    }

    public function actionAdd()
    {
        $values = Yii::$app->request->post('Area');

        if($values['id'] !='')
        {
            $model = Area::findOne($values['id']);
        }
        else
        {
            $model = new Area();
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
            $model->setResourseBoards('area');
            $model->imageFiles = UploadedFile::getInstances($model, 'imageFiles');
            $model->upload();
        }

        $data['id'] = $model->id;
        $apart = Area::findOne($data['id']);
        $apart->getResouseBoards('area');
        return $this->render('view', ['data' => $data, 'model' => $apart]);
    }
}
