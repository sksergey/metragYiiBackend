<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\ApartmentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

use app\models\RegionKharkivAdmin;
use app\models\Layout;
use app\models\TypeObject;
use app\models\Users;



$this->title = Yii::t('app', 'Apartments');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="apartment-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('yii', 'Create Apartment'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'class' => 'yii\grid\ActionColumn',
                //'controller' => 'apartment'
                /*'attribute' => 'Action',
                'value' => function($dataProvider){
                    //return Url::to(['agency/apartmentedit', 'id' => $dataProvider->id]);
                    return Html::a('Редактировать', ['agency/apartmentedit', 'id' => $dataProvider->id], ['class' => 'profile-link']);
                }*/
            ],
            'id',
            [
                'attribute' => 'type_object_id',
                'value' =>  function ($dataProvider) {
                    return TypeObject::findOne($dataProvider->type_object_id)->name;
                }
            ],
            [
                'attribute' => 'region_kharkiv_admin_id',
                'value' =>  function ($dataProvider) {
                    return RegionKharkivAdmin::findOne($dataProvider->region_kharkiv_admin_id)->name;
                }
            ],
            'count_room',
            [
                'attribute' => 'layout_id',
                'value' =>  function ($dataProvider) {
                    return Layout::findOne($dataProvider->layout_id)->name;
                    //return $dataProvider->layout_id;
                }
            ],
            'floor',
            'corps',
            'number_apartment',
            'note',
            'notesite',
            'phone',
            'price',
            [
                'attribute' => 'update_author_id',
                'value' =>  function ($dataProvider) {
                    return Users::findOne($dataProvider->update_author_id)->name;
                }
            ],
            'enabled',
            // 'floor_all',
            // 'city_or_region',
            // 'region_kharkiv_admin_id',
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
            // 'landmark',
            // 'condit_id',
            // 'source_info_id',
            // 'price',
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

            //['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
