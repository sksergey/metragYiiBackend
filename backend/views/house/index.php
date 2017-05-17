<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\HouseSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Houses');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="house-index">

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

            'id',
            'type_object_id',
            'count_room',
            'partsite_id',
            'parthouse_id',
            // 'floor_all',
            // 'city_or_region',
            // 'region_kharkiv_admin_id',
            // 'locality_id',
            // 'course_id',
            // 'region_id',
            // 'region_kharkiv_id',
            // 'street_id',
            // 'number_building',
            // 'exchange',
            // 'exchange_formula',
            // 'landmark',
            // 'condit_id',
            // 'source_info_id',
            // 'price',
            // 'mediator_id',
            // 'metro_id',
            // 'phone',
            // 'total_area_house',
            // 'total_area',
            // 'building_year',
            // 'sewage_id',
            // 'wall_material_id',
            // 'gas_id',
            // 'water_id',
            // 'comfort_id',
            // 'exclusive_user_id',
            // 'phone_line',
            // 'state_act',
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

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
