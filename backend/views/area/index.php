<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use backend\models\RegionKharkivAdmin;
use backend\models\Partsite;
use backend\models\TypeObject;
use backend\models\Users;
/* @var $this yii\web\View */
/* @var $searchModel common\models\AreaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Areas');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="area-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Area'), ['create'], ['class' => 'btn btn-success']) ?>
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
            [
                'attribute' => 'region_kharkiv_admin_id',
                'value' =>  function ($dataProvider) {
                    return RegionKharkivAdmin::findOne($dataProvider->region_kharkiv_admin_id)->name;
                }
            ],
            [
                'attribute' => 'partsite_id',
                'value' =>  function ($dataProvider) {
                    return Partsite::findOne($dataProvider->partsite_id)->name;
                }
            ],
            //'city_or_region',
            //'region_kharkiv_admin_id',
            // 'locality_id',
            // 'course_id',
            // 'region_id',
            // 'region_kharkiv_id',
            // 'street_id',
            // 'number_building',
            // 'exchange',
            // 'exchange_formula',
            // 'landmark',
            // 'source_info_id',
            // 'price',
            // 'mediator_id',
            // 'phone',
            // 'water_id',
            // 'total_area',
            // 'sewage_id',
            // 'purpose_id',
            // 'gas_id',
            // 'house_demolition',
            // 'exclusive_user_id',
            // 'phone_line',
            // 'state_act',
            // 'electric',
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
