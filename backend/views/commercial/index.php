<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use backend\models\RegionKharkivAdmin;
use backend\models\Layout;
use backend\models\TypeObject;
use backend\models\Users;
/* @var $this yii\web\View */
/* @var $searchModel common\models\CommercialSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Commercials');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="commercial-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create'), ['create'], ['class' => 'btn btn-success']) ?>
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
            //'ownership_id',
            'floor',
            // 'floor_all',
            // 'city_or_region',
            // 'region_kharkiv_admin_id',
            // 'locality_id',
            // 'course_id',
            // 'region_id',
            // 'region_kharkiv_id',
            // 'street_id',
            // 'number_office',
            // 'corps',
            // 'exchange',
            // 'exchange_formula',
            // 'landmark',
            // 'condit_id',
            // 'source_info_id',
            // 'price',
            // 'price_square_meter',
            // 'mediator_id',
            // 'metro_id',
            // 'phone',
            // 'total_area_house',
            // 'total_area',
            // 'communication_id',
            // 'exclusive_user_id',
            // 'housing',
            // 'detached_building',
            // 'documents',
            // 'rent',
            // 'topicality',
            // 'avtorampa',
            // 'red_line',
            // 'infinite_period',
            // 'separate_entrance',
            // 'delivered',
            // 'phone_line',
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
            'price',
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
