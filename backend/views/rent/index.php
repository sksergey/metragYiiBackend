<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use backend\models\RegionKharkivAdmin;
use backend\models\TypeObject;
use backend\models\Users;

/* @var $this yii\web\View */
/* @var $searchModel common\models\RentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Rents');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rent-index">

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
            ['class' => 'yii\grid\ActionColumn'],
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
            'count_room_rent',
            'floor',
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
            // 'landmark',
            // 'condit_id',
            // 'source_info_id',
            'price',
            // 'price_note',
            // 'comfort_id',
            // 'metro_id',
            // 'phone',
            // 'phone_site',
            // 'email_site:email',
            // 'exclusive_user_id',
            // 'tv',
            // 'refrigerator',
            // 'entry',
            // 'washer',
            // 'furniture',
            // 'conditioner',
            // 'garage',
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
