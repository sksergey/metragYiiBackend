<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\olxparser\models\Parser */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Parsers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="parser-view">

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
            'advert_id',
            'link:ntext',
            'path:ntext',
            'date',
            'type_object_id',
            'advert_from',
            'type',
            'type_flat',
            'count_room',
            'floor',
            'floor_all',
            'total_area',
            'floor_area',
            'kitchen_area',
            'price',
            'phone:ntext',
            'status:ntext',
            'note:ntext',
            'kolfoto',
            'image:ntext',
            'view',
            'count_similar_advs',
        ],
    ]) ?>

</div>
