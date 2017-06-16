<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
?>
<?php echo $this->render('_excel-input', ['model' => $model]); ?>

<?php Pjax::begin(); ?>    <?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        //['class' => 'yii\grid\SerialColumn'],

        'id',
        'region_kharkiv_id',
        'street_id',
        'metro_id',
        'link1:ntext',
        'link2:ntext',
        // 'date',
        // 'type_object_id',
        'count_room',
        'floor',
        'floor_all',
        'total_area',
        'floor_area',
        // 'kitchen_area',
        // 'price',
        // 'phone:ntext',
        // 'status:ntext',
        // 'note:ntext',
        // 'kolfoto',
        // 'image:ntext',
        // 'view',

        ['class' => 'yii\grid\ActionColumn'],
    ],
]); ?>
<?php Pjax::end(); ?>