<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\olxparser\models\ParserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Parsers');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="parser-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Parser'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'advert_id',
            'link:ntext',
            'path:ntext',
            'date',
            // 'type_object_id',
            // 'advert_from',
            // 'type',
            // 'type_flat',
            // 'count_room',
            // 'floor',
            // 'floor_all',
            // 'total_area',
            // 'floor_area',
            // 'kitchen_area',
            // 'price',
            // 'phone:ntext',
            // 'status:ntext',
            // 'note:ntext',
            // 'kolfoto',
            // 'image:ntext',
            // 'view',
            // 'count_similar_advs',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
