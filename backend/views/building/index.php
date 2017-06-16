<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

use backend\models\TypeObject;
use backend\models\RegionKharkivAdmin;
use backend\models\Users;
/* @var $this yii\web\View */
/* @var $searchModel common\models\BuildingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Buildings');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="building-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Building'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\ActionColumn'],
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            [
                'attribute' => 'type_object_id',
                'value' =>  function ($dataProvider) {
                    return TypeObject::findOne($dataProvider->type_object_id)->name;
                }
            ],
            'count_room',
            //'layout_id',
            'floor',
            // 'floor_all',
            // 'city_or_region',
            [
                'attribute' => 'region_kharkiv_admin_id',
                'value' =>  function ($dataProvider) {
                    return RegionKharkivAdmin::findOne($dataProvider->region_kharkiv_admin_id)->name;
                }
            ],
            // 'locality_id',
            // 'course_id',
            // 'region_id',
            // 'region_kharkiv_id',
            // 'street_id',
            // 'number_building',
            // 'corps',
            // 'number_apartment',
            // 'exchange',
            // 'exchange_formula',
            // 'developer_id',
            // 'landmark',
            // 'condit_id',
            // 'source_info_id',
            // 'price',
            // 'price_square_meter',
            // 'mediator_id',
            // 'metro_id',
            // 'phone',
            // 'total_area',
            // 'floor_area',
            // 'kitchen_area',
            // 'wc_id',
            // 'wall_material_id',
            // 'count_balcony',
            // 'count_balcony_glazed',
            // 'exclusive_user_id',
            // 'phone_line',
            // 'bath',
            // 'comment:ntext',
            // 'note:ntext',
            // 'notesite:ntext',
            // 'date_added',
            // 'date_modified',
            // 'date_modified_photo',
            // 'author_id',
            // 'update_author_id',
            // 'update_photo_user_id',
            // 'enabled',
            [
                'attribute' => 'update_author_id',
                'value' =>  function ($dataProvider) {
                    return Users::findOne($dataProvider->update_author_id)->name;
                }
            ],
            [
                'attribute' => 'enabled',
                'value' => function($model) {
                    return $model->enabled == 0 ? Yii::t('app', 'Archive') : Yii::t('app', 'Active');
                },
                'filter' => [
                    0 => Yii::t('app', 'Archive'),
                    1 => Yii::t('app', 'Active')
                ]
            ],

        ],
    ]); ?>
<?php Pjax::end(); ?></div>
