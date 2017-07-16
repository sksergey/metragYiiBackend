<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use kartik\export\ExportMenu;

/* @var $this yii\web\View */
/* @var $searchModel common\models\BuildingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
use backend\models\RegionKharkiv;
use backend\models\Layout;
use backend\models\TypeObject;
use backend\models\User;
use backend\models\Street;
use backend\models\Condit;
use backend\models\WallMaterial;
use backend\models\Mediator;

\yii\helpers\Url::remember();

$this->title = Yii::t('app', 'Buildings');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="building-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Building'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <div class="main-content">
        <?php
        $gridColumns = [
            //['class' => 'yii\grid\SerialColumn'],
            [
                'class' => 'yii\grid\ActionColumn',
                'controller' => 'apartment',
                'buttons' => [
                    'update' => function ($url,$model) {
                        return Html::a(
                            '<span class="glyphicon glyphicon-pencil"></span>',
                            $url,
                            [
                                'title' => Yii::t('app', 'Edit'),

                            ]);
                    },

                ],
            ],
            'id',
            [
                'attribute' => 'type_object_id',
                'label' => 'Тип объе-кта',
                'value' =>  function ($dataProvider) {
                    return TypeObject::findOne($dataProvider->type_object_id)->name;
                },
                'contentOptions' => ['style' => 'max-width: 30px; overflow: hidden' ],
            ],
            [
                'format' => 'html',
                'attribute' => 'region_kharkiv_id',
                'value' =>  function ($dataProvider) {
                    $region = RegionKharkiv::findOne($dataProvider->region_kharkiv_id)->name;
                    $str = str_replace(' ', ' <br>', $region);
                    return /*$str*/$region;
                },
                'contentOptions' => ['style' => 'max-width: 70px; overflow: hidden' ],
            ],
            [
                'format' => 'html',
                'attribute' => 'street_id',
                'value' =>  function ($dataProvider) {
                    $street = Street::findOne($dataProvider->street_id)->name;
                    $str = str_replace(' ', ' <br>', $street);
                    return /*$str*/$street;
                },
                'contentOptions' => ['style' => 'max-width: 70px; overflow: hidden' ],
            ],
            'number_building',
            'count_room',
            [
                'attribute' => 'floor',
                'value' =>  function ($dataProvider) {
                    return $dataProvider->floor;
                },
                'contentOptions' => ['style' => 'max-width: 30px; overflow: hidden' ],
            ],
            [
                'format' => 'html',
                'attribute' => 'floor_all',
                'label' => 'Этаж-ть',
                'value' =>  function ($dataProvider) {
                    return $dataProvider->floor_all;
                },
                'contentOptions' => ['style' => 'max-width: 30px; overflow: hidden' ],
            ],
            //'floor',
            //'floor_all',
            [
                'attribute' => 'total_area',
                'label' => 'Общая пл',
                'value' =>  function ($dataProvider) {
                    return (int)$dataProvider->total_area;
                },
                'contentOptions' => ['style' => 'max-width: 30px; overflow: hidden' ],
            ],
            [
                'attribute' => 'floor_area',
                'label' => 'Жилая пл',
                'value' =>  function ($dataProvider) {
                    return (int)$dataProvider->floor_area;
                },
                'contentOptions' => ['style' => 'max-width: 30px; overflow: hidden' ],
            ],
            [
                'attribute' => 'kitchen_area',
                'label' => 'Кухни пл',
                'value' =>  function ($dataProvider) {
                    return (int)$dataProvider->kitchen_area;
                },
                'contentOptions' => ['style' => 'max-width: 30px; overflow: hidden' ],
            ],
            //'total_area',
            //'floor_area',
            //'kitchen_area',
            [
                'attribute' => 'condit_id',
                'label' => 'Сост.',
                'value' =>  function ($dataProvider) {
                    return Condit::findOne($dataProvider->condit_id)->name;
                },
                'contentOptions' => ['style' => 'max-width: 30px; overflow: hidden' ],
            ],
            'price',
            [
                'format' => 'html',
                'attribute' => 'phone',
                'value' =>  function ($dataProvider) {
                    //$str = str_replace(',', ',<br>', $dataProvider->phone);
                    $str = strpos($dataProvider->phone, ",") === false ? $dataProvider->phone :
                        substr($dataProvider->phone,0,strpos($dataProvider->phone, ","));

                    //$str = (($pos=strpos($dataProvider->phone, ",")==false)?strlen($dataProvider->phone):$pos);
                    return $str/*$dataProvider->phone*/;
                }
            ],
            [
                'attribute' => 'layout_id',
                'label' => 'Плани-ровка',
                'value' =>  function ($dataProvider) {
                    return Layout::findOne($dataProvider->layout_id)->name;
                },
                'contentOptions' => ['style' => 'max-width: 30px; overflow: hidden' ],
            ],
            [
                'attribute' => 'wall_material_id',
                'label' => 'Матер. стен',
                'value' =>  function ($dataProvider) {
                    return WallMaterial::findOne($dataProvider->wall_material_id)->name;
                },
                'contentOptions' => ['style' => 'max-width: 30px; overflow: hidden' ],
            ],
            [
                'attribute' => 'count_balcony',
                'label' => 'Кол-во балк-в',
                'value' =>  function ($dataProvider) {
                    return $dataProvider->count_balcony;
                },
                'contentOptions' => ['style' => 'max-width: 30px; overflow: hidden' ],
            ],
            [
                'attribute' => 'count_balcony_glazed',
                'label' => 'Заст балк',
                'value' =>  function ($dataProvider) {
                    return $dataProvider->count_balcony_glazed;
                },
                'contentOptions' => ['style' => 'max-width: 30px; overflow: hidden' ],
            ],
            //'count_balcony',
            //'count_balcony_glazed',
            [
                'attribute' => 'mediator_id',
                'label' => 'Посред-ник',
                'value' =>  function ($dataProvider) {
                    return Mediator::findOne($dataProvider->mediator_id)->name;
                },
                'contentOptions' => ['style' => 'max-width: 30px; overflow: hidden' ],
            ],
            [
                'attribute' => 'author_id',
                'value' =>  function ($dataProvider) {
                    return User::findOne($dataProvider->author_id)->username;
                }
            ],
            [
                'attribute' => 'exclusive_user_id',
                'label' => 'Эксклю-зив',
                'value' =>  function ($dataProvider) {
                    return User::findOne($dataProvider->exclusive_user_id)->username;
                }
            ],
            [
                'label' => 'Фото',
                'value' =>  function ($dataProvider) {
                    if((bool) array_filter($dataProvider->getImages())){
                        return '+';
                    }else{
                        return '-';
                    }
                    //return var_dump($dataProvider->getImages());
                }
            ],

            [
                'format' => 'html',
                'attribute' => 'date_added',
                //'label' => 'Дата добавлeybz',
                'value' =>  function ($dataProvider) {
                    //$str = str_replace(' ', ' <br>', $dataProvider->date_added);
                    //return /*$str*/$dataProvider->date_added;
                    if($dataProvider->date_added=="0000-00-00 00:00:00")
                        return "";
                    return Yii::$app->formatter->asDateTime($dataProvider->date_added, 'dd.MM.yyyy');
                },
                'contentOptions' => ['style' => 'max-width: 40px; overflow: hidden' ],
            ],
            [
                'format' => 'html',
                'attribute' => 'date_modified',
                'value' =>  function ($dataProvider) {
                    //$str = str_replace(' ', ' <br>', $dataProvider->date_modified);
                    //return /*$str*/$dataProvider->date_modified;
                    if($dataProvider->date_modified=="0000-00-00 00:00:00")
                        return "";
                    //echo $dataProvider->date_modified."<br>";
                    return Yii::$app->formatter->asDateTime($dataProvider->date_modified, 'dd.MM.yyyy');
                },
                'contentOptions' => ['style' => 'max-width: 40px; overflow: hidden' ],
            ],
            //'date_added',
            /*[
                'attribute' => 'enabled',
                'value' => function($model) {
                    return $model->enabled == 0 ? Yii::t('app', 'Archive') : Yii::t('app', 'Active');
                },
                'filter' => [
                    0 => Yii::t('app', 'Archive'),
                    1 => Yii::t('app', 'Active')
                ]
            ],*/
        ];
        ?>
        <div class="export">
            <?php
            echo $exportMenu = ExportMenu::widget([
                'dataProvider' => $dataProvider,
                'columns' => $gridColumns,
                //'target' => ExportMenu::TARGET_SELF,
                'target' => ExportMenu::TARGET_BLANK,
                'stream' => false,
                'streamAfterSave' => true,
                'noExportColumns' => ['Action Column'],
                //'fontAwesome' => true,
                'dropdownOptions' => [
                    'label' => Yii::t('app', 'Export'),
                    'class' => 'btn btn-default',
                ],
                'exportConfig' => [
                    ExportMenu::FORMAT_HTML => false,
                    ExportMenu::FORMAT_CSV => false,
                    ExportMenu::FORMAT_TEXT => false,
                    ExportMenu::FORMAT_PDF => false,
                    //ExportMenu::FORMAT_EXCEL or 'Excel5'
                    //ExportMenu::FORMAT_EXCEL_X or 'Excel2007'
                ]
            ]);
            ?>
        </div>

        <?php Pjax::begin(); ?>    <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'rowOptions' => function ($model, $key, $index, $grid)
            {
                if($model->is_active() == false) {
                    return ['style' => 'background-color:#DDA0DD;'];
                }
            },
            'tableOptions' => [
                'class' => 'table table-striped table-bordered',
                'style' => 'font-size: 13px;'
            ],
            'columns' => $gridColumns,
        ]); ?>
        <?php Pjax::end(); ?>
    </div>
</div>
