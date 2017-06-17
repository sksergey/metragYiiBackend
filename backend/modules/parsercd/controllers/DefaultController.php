<?php

namespace app\modules\parsercd\controllers;

use yii\web\Controller;
use app\modules\parsercd\models\ExcelFileModel;
use app\modules\parsercd\models\ParsercdSearch;
use Yii;
use yii\web\UploadedFile;
use app\modules\parsercd\models\Parsercd;

/**
 * Default controller for the `parsercd` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        \app\modules\parsercd\ParsercdAssetsBundle::register($this->view);
        $model = new ExcelFileModel();

        if (Yii::$app->request->isPost) {
            $model->excelFile = UploadedFile::getInstance($model, 'excelFile');
            if ($model->upload()) {
                // file is uploaded successfully
                //return $this->render('excel-arr', ['data' => $data, 'model' => $model]);
                $data = $this->parserLiteStart();
                $header = true;
                foreach ($data as $obj)
                {
                    if(!$header){
                        $add = new Parsercd();
                        $result = $add->saveFromParser($obj);
                    }
                    $header = false;
                }

                //return $this->render('excel-arr', ['data' => $data, 'model' => $model]);
            }
        }
        $searchModel = new ParsercdSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model,
        ]);
        //return $this->render('_excel-input', ['model' => $model]);
    }

    public function parserLiteStart(){
        $fileName = 'C:\OpenServer\domains\yii-application\backend\web\excel\uploads\parse.xlsx';
        $data = \moonland\phpexcel\Excel::widget([
            'mode' => 'import',
            'fileName' => $fileName,
            'setFirstRecordAsKeys' => false, // if you want to set the keys of record column with first record, if it not set, the header with use the alphabet column on excel.
            'setIndexSheetByName' => true, // set this if your excel data with multiple worksheet, the index of array will be set with the sheet name. If this not set, the index will use numeric.
            'getOnlySheet' => 'sheet1', // you can set this property if you want to get the specified sheet from the excel data with multiple worksheet.
        ]);

        //$data = \moonland\phpexcel\Excel::import($fileName, $config); // $config is an optional
        /*
        $data = \moonland\phpexcel\Excel::import($fileName, [
            'setFirstRecordAsKeys' => true, // if you want to set the keys of record column with first record, if it not set, the header with use the alphabet column on excel.
            'setIndexSheetByName' => true, // set this if your excel data with multiple worksheet, the index of array will be set with the sheet name. If this not set, the index will use numeric.
            'getOnlySheet' => 'sheet1', // you can set this property if you want to get the specified sheet from the excel data with multiple worksheet.
        ]);*/

        return $data;
    }

    public function parserActiveStart(){
        $fileName = 'C:\OpenServer\domains\yii-application\backend\web\excel\uploads\parse.xlsx';
        $importer = new Importer([
            'filePath' => Yii::getAlias('@backend\web\excel\uploads\parse.xlsx'),
            'standardModelsConfig' => [
                [
                    'className' => Parsercd::className(),
                    'standardAttributesConfig' => [
                        /*[
                            'name' => 'type',
                            'valueReplacement' => Test::getTypesList(),
                        ],
                        [
                            'name' => 'description',
                            'valueReplacement' => function ($value) {
                                return $value ? Html::tag('p', $value) : '';
                            },
                        ],
                        [
                            'name' => 'category_id',
                            'valueReplacement' => function ($value) {
                                return Category::find()->select('id')->where(['name' => $value]);
                            },
                        ],*/
                        [
                            //'name' => 'Нас.п.',
                            //'valueReplacement' => Parsercd::path,
                        ],
                    ],
                ],
            ],
        ]);
    }
}
