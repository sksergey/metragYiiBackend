<style>
  .carousel-inner > .item > img,
  .carousel-inner > .item > a > img {
      width: 70%;
      margin: auto;
  }
</style>

<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

use rico\yii2images\controllers\ImagesController;
use rico\yii2images\models\Image;

use yii\bootstrap\Carousel;

/* @var $this yii\web\View */
/* @var $model app\models\Apartment */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Apartments'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="apartment-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <? echo DetailView::widget([
    'model' => $model,
    'attributes' => [
        'id',
        [
            'label' => \Yii::t('yii','Type object'),
            'value' => $model->typeObject->name,
        ],
        'count_room',
        [
            'label' => \Yii::t('yii','Layout'),
            'value' => $model->layout->name,
        ],
        'floor',
        'floor_all',
        'city_or_region',
        'locality_id',
        'course_id',
        'region_id',
        'region_kharkiv_id',
        'region_kharkiv_admin_id',
        'street_id',
        'number_building',
        'corps',
        'number_apartment',
        'exchange',
        'exchange_formula',
        'landmark',
        'condit_id',
        'source_info_id',
        'price',
        'mediator_id',
        'metro_id',
        'phone',
        'total_area',
        'floor_area',
        'kitchen_area',
        'wc_id',
        'wall_material_id',
        'count_balcony',
        'count_balcony_glazed',
        'exclusive_user_id',
        'phone_line',
        'bath',
        'comment',
        'note',
        'notesite',
        'date_added',
        'date_modified',
        'date_modified_photo',
        'author_id',
        'update_author_id',
        'update_photo_user_id',
        'enabled',
     
    ],
]);
?>

<div class="container">
    <div class="col-xs-9 col-xm-9 col-xl-9">
    <? 
        $images = $model->getImages();
                $img = [];
        
                if($images){
                    foreach ($images as $image){
                        $img[] = '<img src="'. $image->getUrl('600x'). '" alt="">';
                     }
                }
                
        echo Carousel::widget(['items'=>$img]);
     ?>     
    </div>
</div>

</div>
