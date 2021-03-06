<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\House */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Houses'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="house-view">

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

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
            'label' => \Yii::t('yii','Type object'),
            'value' => $model->typeObject->name,
            ],
            'count_room',
            [
            'label' => \Yii::t('yii','Partsite'),
            'value' => $model->partsite->name,
            ],
            [
            'label' => \Yii::t('yii','Parthouse'),
            'value' => $model->parthouse->name,
            ],
            'floor_all',
            [
            'label' => \Yii::t('yii','City Or Region'),
            'value' => $model->cityOrRegion,
            ],
            [
                'label' => \Yii::t('yii','Locality'),
                'value' => $model->locality->name,
            ],
            [
                'label' => \Yii::t('yii','Course'),
                'value' => $model->course->name,
            ],
            [
                'label' => \Yii::t('yii','Region'),
                'value' => $model->region->name,
            ],
            [
                'label' => \Yii::t('yii','Region Kharkiv'),
                'value' => $model->regionKharkiv->name,
            ],
            [
                'label' => \Yii::t('yii','Region Kharkiv Admin'),
                'value' => $model->regionKharkivAdmin->name,
            ],
            [
                'label' => \Yii::t('yii','Street'),
                'value' => $model->street->name,
            ],
            'number_building',
            'exchange',
            'exchange_formula',
            'landmark',
            [
            'label' => \Yii::t('yii','Condit'),
            'value' => $model->condit->name,
            ],
            [
                'label' => \Yii::t('yii','Source Info'),
                'value' => $model->sourceInfo->name,
            ],
            'price',
            [
            'label' => \Yii::t('yii','Mediator'),
            'value' => $model->mediator->name,
            ],
            [
                'label' => \Yii::t('yii','Metro'),
                'value' => $model->metro->name,
            ],
            'phone',
            'total_area_house',
            'total_area',
            'building_year',
            [
                'label' => \Yii::t('yii','Sewage'),
                'value' => $model->sewage->name,
            ],
            [
            'label' => \Yii::t('yii','Wall Material'),
            'value' => $model->wallMaterial->name,
            ],
            [
            'label' => \Yii::t('yii','Gas'),
            'value' => $model->gas->name,
            ],
            [
            'label' => \Yii::t('yii','Water'),
            'value' => $model->water->name,
            ],
            [
            'label' => \Yii::t('yii','Comfort'),
            'value' => $model->comfort->name,
            ],
            [
            'label' => \Yii::t('yii','Exclusive User'),
            'value' => $model->exclusiveUser->name,
            ],
            [
                'label' => \Yii::t('yii','Phone Line'),
                'value' => $model->phoneLineValue,
            ],
            [
                'label' => \Yii::t('yii','State Act'),
                'value' => $model->stateActValue,
            ],
            'comment:ntext',
            'note:ntext',
            'notesite:ntext',
            'date_added',
            'date_modified',
            'date_modified_photo',
            [
            'label' => \Yii::t('yii','Author'),
            'value' => $model->author->name,
            ],
            [
                'label' => \Yii::t('yii','Update Author'),
                'value' => $model->updateAuthor->name,
            ],
            [
                'label' => \Yii::t('yii','Update Photo User'),
                'value' => $model->updatePhotoUser->name,
            ],
            [
                'label' => \Yii::t('yii','Enabled'),
                'value' => $model->enabledValue,
            ],
            ],
    ]) ?>

</div>
