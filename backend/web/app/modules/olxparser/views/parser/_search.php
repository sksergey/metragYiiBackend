<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\olxparser\models\ParserSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="parser-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'advert_id') ?>

    <?= $form->field($model, 'link') ?>

    <?= $form->field($model, 'path') ?>

    <?= $form->field($model, 'date') ?>

    <?php // echo $form->field($model, 'type_object_id') ?>

    <?php // echo $form->field($model, 'advert_from') ?>

    <?php // echo $form->field($model, 'type') ?>

    <?php // echo $form->field($model, 'type_flat') ?>

    <?php // echo $form->field($model, 'count_room') ?>

    <?php // echo $form->field($model, 'floor') ?>

    <?php // echo $form->field($model, 'floor_all') ?>

    <?php // echo $form->field($model, 'total_area') ?>

    <?php // echo $form->field($model, 'floor_area') ?>

    <?php // echo $form->field($model, 'kitchen_area') ?>

    <?php // echo $form->field($model, 'price') ?>

    <?php // echo $form->field($model, 'phone') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'note') ?>

    <?php // echo $form->field($model, 'kolfoto') ?>

    <?php // echo $form->field($model, 'image') ?>

    <?php // echo $form->field($model, 'view') ?>

    <?php // echo $form->field($model, 'count_similar_advs') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
